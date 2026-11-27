<?php

namespace App\Console\Commands;

use App\Services\ImageCompressionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CompressExistingImagesCommand extends Command
{
    protected $signature = 'images:compress-webp
                            {--quality=82 : Kualitas kompresi WebP (1-100)}
                            {--max-width=1920 : Lebar maksimal gambar dalam pixel}
                            {--keep-originals : Jangan hapus file gambar lama setelah dikonversi}
                            {--dry-run : Simulasi tanpa mengubah file atau database}';

    protected $description = 'Kompres dan konversi semua gambar yang sudah terupload ke format WebP serta perbarui referensi di database';

    protected array $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

    /**
     * Daftar tabel & kolom gambar di database.
     */
    protected array $dbTargets = [
        ['table' => 'posts', 'column' => 'picture'],
        ['table' => 'sliders', 'column' => 'picture'],
        ['table' => 'flyers', 'column' => 'picture'],
        ['table' => 'prioritas_pembangunans', 'column' => 'picture'],
        ['table' => 'gallerys', 'column' => 'picture'],
        ['table' => 'albums', 'column' => 'picture'],
        ['table' => 'pegawais', 'column' => 'picture'],
        ['table' => 'pages', 'column' => 'picture'],
        ['table' => 'themes', 'column' => 'picture'],
        ['table' => 'users', 'column' => 'picture'],
    ];

    public function handle(ImageCompressionService $compressor): int
    {
        $quality = max(10, min(100, (int) $this->option('quality')));
        $maxWidth = max(200, (int) $this->option('max-width'));
        $keepOriginals = (bool) $this->option('keep-originals');
        $dryRun = (bool) $this->option('dry-run');

        $directories = array_filter([
            storage_path('app/public/uploads'),
            public_path('berkas'),
            public_path('berkas/uploads'),
        ], fn ($dir) => is_dir($dir));

        if (empty($directories)) {
            $this->warn('Tidak ada direktori upload yang ditemukan.');
            return Command::SUCCESS;
        }

        $this->info(($dryRun ? '[DRY-RUN] ' : '') . "Memulai kompresi gambar ke WebP (quality={$quality}, maxWidth={$maxWidth}px)...");

        $convertedMap = []; // oldFilename => newWebpFilename
        $totalOriginalBytes = 0;
        $totalWebpBytes = 0;
        $convertedCount = 0;
        $errorCount = 0;

        foreach ($directories as $dir) {
            $files = scandir($dir);
            if ($files === false) {
                continue;
            }

            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
                if (!is_file($fullPath)) {
                    continue;
                }

                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, $this->imageExtensions, true)) {
                    continue;
                }

                $webpFilename = pathinfo($file, PATHINFO_FILENAME) . '.webp';
                $webpPath = $dir . DIRECTORY_SEPARATOR . $webpFilename;
                $origSize = filesize($fullPath) ?: 0;

                if ($origSize === 0) {
                    $this->line("  [SKIP] {$file} (file kosong 0 bytes)");
                    continue;
                }

                if ($dryRun) {
                    $this->line("  [DRY-RUN] {$fullPath} -> {$webpFilename} (" . round($origSize / 1024, 1) . " KB)");
                    $convertedMap[$file] = $webpFilename;
                    $convertedCount++;
                    continue;
                }

                try {
                    if (!is_file($webpPath)) {
                        $ok = $compressor->compressExistingFile($fullPath, $webpPath, $maxWidth, $quality);
                        if (!$ok) {
                            $errorCount++;
                            continue;
                        }
                    }

                    $newSize = filesize($webpPath) ?: 0;
                    $totalOriginalBytes += $origSize;
                    $totalWebpBytes += $newSize;
                    $convertedMap[$file] = $webpFilename;
                    $convertedCount++;

                    Cache::forget('berkas_url_' . md5($file));
                    Cache::forget('berkas_url_' . md5($webpFilename));

                    if (!$keepOriginals && $fullPath !== $webpPath) {
                        @unlink($fullPath);
                    }
                } catch (\Throwable $e) {
                    $errorCount++;
                    $this->error("  Gagal mengonversi {$file}: " . $e->getMessage());
                }
            }
        }

        // Update referensi nama file di database
        $dbUpdated = 0;
        if (!$dryRun && !empty($convertedMap)) {
            foreach ($this->dbTargets as $target) {
                $table = $target['table'];
                $col = $target['column'];
                if (!Schema::hasTable($table) || !Schema::hasColumn($table, $col)) {
                    continue;
                }

                foreach ($convertedMap as $oldName => $newName) {
                    $affected = DB::table($table)->where($col, $oldName)->update([$col => $newName]);
                    $affected += DB::table($table)->where($col, 'uploads/' . $oldName)->update([$col => 'uploads/' . $newName]);
                    $dbUpdated += $affected;
                }
            }

            // Update logo pada settings
            if (Schema::hasTable('settings')) {
                foreach ($convertedMap as $oldName => $newName) {
                    $affected = DB::table('settings')
                        ->where('key', 'logo')
                        ->where('value', $oldName)
                        ->update(['value' => $newName]);
                    $dbUpdated += $affected;
                }
            }

            // Update referensi gambar di dalam konten HTML (posts.content & pages.content)
            foreach (['posts', 'pages'] as $htmlTable) {
                if (!Schema::hasTable($htmlTable) || !Schema::hasColumn($htmlTable, 'content')) {
                    continue;
                }
                foreach ($convertedMap as $oldName => $newName) {
                    $rows = DB::table($htmlTable)
                        ->where('content', 'like', '%' . $oldName . '%')
                        ->select('id', 'content')
                        ->get();
                    foreach ($rows as $row) {
                        $updatedHtml = str_replace($oldName, $newName, $row->content);
                        if ($updatedHtml !== $row->content) {
                            DB::table($htmlTable)->where('id', $row->id)->update(['content' => $updatedHtml]);
                            $dbUpdated++;
                        }
                    }
                }
            }

            // Bersihkan cache aplikasi agar URL baru langsung terbaca
            Cache::forget('global_app_settings');
            Cache::forget('home_sliders');
            Cache::forget('home_flyers');
            Cache::forget('home_latest_news_v2');
            Cache::forget('home_galleries_v2');
        }

        $this->newLine();
        $this->info('Selesai!');
        $this->line("- Gambar diproses  : {$convertedCount}");
        $this->line("- Referensi DB     : {$dbUpdated} baris diperbarui");
        if (!$dryRun && $totalOriginalBytes > 0) {
            $savedMB = round(($totalOriginalBytes - $totalWebpBytes) / 1048576, 2);
            $pct = round((1 - ($totalWebpBytes / $totalOriginalBytes)) * 100, 1);
            $this->line("- Ukuran awal      : " . round($totalOriginalBytes / 1048576, 2) . " MB");
            $this->line("- Ukuran WebP      : " . round($totalWebpBytes / 1048576, 2) . " MB");
            $this->line("- Penghematan      : {$savedMB} MB ({$pct}%)");
        }
        if ($errorCount > 0) {
            $this->warn("- Gagal            : {$errorCount} file");
        }

        return Command::SUCCESS;
    }
}

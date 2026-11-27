<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\ImageCompressionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImageOptimizeController extends Controller
{
    protected array $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

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

    protected function ensureAuthorized(): void
    {
        if (!Auth::check() || (!Auth::user()->hasRole('superadmin') && !Auth::user()->hasRole('admin'))) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->ensureAuthorized();
        return view('backend.image-optimize.index');
    }

    public function stats(Request $request)
    {
        $this->ensureAuthorized();
        $months = max(0, (int) $request->get('months', 3));
        return response()->json($this->collectStats($months));
    }

    public function processBatch(Request $request, ImageCompressionService $compressor)
    {
        $this->ensureAuthorized();

        $months = max(0, (int) $request->input('months', 3));
        $batchSize = max(1, min(50, (int) $request->input('batch_size', 15)));
        $quality = max(10, min(100, (int) $request->input('quality', 80)));
        $maxWidth = max(400, min(3840, (int) $request->input('max_width', 1920)));
        $keepOriginals = filter_var($request->input('keep_originals', false), FILTER_VALIDATE_BOOLEAN);

        $cutoff = $months > 0 ? now()->subMonths($months)->timestamp : null;
        $directories = $this->getUploadDirectories();

        $pendingFiles = [];
        foreach ($directories as $dir) {
            $files = @scandir($dir);
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
                $size = @filesize($fullPath) ?: 0;
                if ($size === 0) {
                    continue;
                }
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, $this->imageExtensions, true)) {
                    continue;
                }
                if ($cutoff !== null) {
                    $mtime = @filemtime($fullPath);
                    if ($mtime !== false && $mtime < $cutoff) {
                        continue;
                    }
                }
                $webpFilename = pathinfo($file, PATHINFO_FILENAME) . '.webp';
                $webpPath = $dir . DIRECTORY_SEPARATOR . $webpFilename;
                // If keep_originals is true and webp already exists, skip it
                if ($keepOriginals && is_file($webpPath)) {
                    continue;
                }
                $pendingFiles[] = [
                    'dir' => $dir,
                    'file' => $file,
                    'fullPath' => $fullPath,
                    'webpFilename' => $webpFilename,
                    'webpPath' => $webpPath,
                    'origSize' => $size,
                ];
            }
        }

        $slice = array_slice($pendingFiles, 0, $batchSize);
        $logs = [];
        $convertedMap = [];
        $processed = 0;
        $savedBytes = 0;

        foreach ($slice as $item) {
            try {
                if (!is_file($item['webpPath'])) {
                    $ok = $compressor->compressExistingFile($item['fullPath'], $item['webpPath'], $maxWidth, $quality);
                    if (!$ok) {
                        $logs[] = "[ERR] Gagal mengonversi {$item['file']}";
                        continue;
                    }
                }

                $newSize = @filesize($item['webpPath']) ?: 0;
                $diff = max(0, $item['origSize'] - $newSize);
                $savedBytes += $diff;
                $pct = $item['origSize'] > 0 ? round((1 - ($newSize / $item['origSize'])) * 100, 1) : 0;

                $convertedMap[$item['file']] = $item['webpFilename'];
                $processed++;

                Cache::forget('berkas_url_' . md5($item['file']));
                Cache::forget('berkas_url_' . md5($item['webpFilename']));

                if (!$keepOriginals && $item['fullPath'] !== $item['webpPath']) {
                    @unlink($item['fullPath']);
                }

                $logs[] = "[OK] {$item['file']} (" . $this->formatBytes($item['origSize']) . ") -> {$item['webpFilename']} (" . $this->formatBytes($newSize) . ") | Hemat {$pct}%";
            } catch (\Throwable $e) {
                $logs[] = "[SKIP] {$item['file']}: " . $e->getMessage();
            }
        }

        $dbUpdated = 0;
        if (!empty($convertedMap)) {
            $dbUpdated = $this->updateDatabaseReferences($convertedMap);
            Cache::forget('global_app_settings');
            Cache::forget('home_sliders');
            Cache::forget('home_flyers');
            Cache::forget('home_latest_news_v2');
            Cache::forget('home_galleries_v2');
        }

        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }

        $stats = $this->collectStats($months, $keepOriginals);

        return response()->json([
            'success' => true,
            'processed' => $processed,
            'db_updated' => $dbUpdated,
            'saved_bytes' => $savedBytes,
            'saved_human' => $this->formatBytes($savedBytes),
            'remaining' => $stats['pending_files'],
            'logs' => $logs,
            'stats' => $stats,
        ]);
    }

    protected function collectStats(int $months = 3, bool $keepOriginals = false): array
    {
        $cutoff = $months > 0 ? now()->subMonths($months)->timestamp : null;
        $directories = $this->getUploadDirectories();

        $totalFiles = 0;
        $totalBytes = 0;
        $webpFiles = 0;
        $pendingFiles = 0;
        $pendingBytes = 0;

        foreach ($directories as $dir) {
            $files = @scandir($dir);
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
                $size = @filesize($fullPath) ?: 0;
                if ($size === 0) {
                    continue;
                }
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, array_merge($this->imageExtensions, ['webp']), true)) {
                    continue;
                }
                if ($cutoff !== null) {
                    $mtime = @filemtime($fullPath);
                    if ($mtime !== false && $mtime < $cutoff) {
                        continue;
                    }
                }

                $totalFiles++;
                $totalBytes += $size;

                if ($ext === 'webp') {
                    $webpFiles++;
                } else {
                    $webpPath = $dir . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_FILENAME) . '.webp';
                    if ($keepOriginals && is_file($webpPath)) {
                        // Already converted when keeping originals
                    } else {
                        $pendingFiles++;
                        $pendingBytes += $size;
                    }
                }
            }
        }

        $webpPercent = $totalFiles > 0 ? round(($webpFiles / $totalFiles) * 100, 1) : 100;
        $estimatedSaveBytes = (int) round($pendingBytes * 0.65);

        return [
            'months' => $months,
            'total_files' => $totalFiles,
            'total_size_human' => $this->formatBytes($totalBytes),
            'webp_files' => $webpFiles,
            'webp_percent' => $webpPercent,
            'pending_files' => $pendingFiles,
            'estimated_save_human' => $this->formatBytes($estimatedSaveBytes),
        ];
    }

    protected function getUploadDirectories(): array
    {
        return array_values(array_filter([
            storage_path('app/public/uploads'),
            public_path('berkas'),
            public_path('berkas/uploads'),
        ], fn ($dir) => is_dir($dir)));
    }

    protected function updateDatabaseReferences(array $convertedMap): int
    {
        $dbUpdated = 0;

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

        if (Schema::hasTable('settings')) {
            foreach ($convertedMap as $oldName => $newName) {
                $dbUpdated += DB::table('settings')
                    ->where('key', 'logo')
                    ->where('value', $oldName)
                    ->update(['value' => $newName]);
            }
        }

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

        return $dbUpdated;
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        }
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }
}

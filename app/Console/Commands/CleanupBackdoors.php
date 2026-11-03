<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Finder\Finder;

class CleanupBackdoors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backdoor:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes suspicious files from public/ and storage/app/ folders, with separate logging.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $suspiciousExtensions = [
            'php', 'phtml', 'php5', 'phps', 'cgi', 'pl', 'py', 'sh', 'bash',
            'htaccess', 'html', 'htm', 'sql', 'xml', 'so', 'socket', 'phar', 'exe', 'dll',
        ];

        $log = Log::channel('backdoor_cleanup');

        $this->info('Memulai pembersihan di folder public...');
        $this->cleanDirectory(public_path(), $suspiciousExtensions, $log, true);

        $this->line('');

        $this->info('Memulai pembersihan di folder storage/app...');
        $this->cleanDirectory(storage_path('app'), $suspiciousExtensions, $log, false);

        $this->info('Proses pembersihan selesai.');
        return 0;
    }

    /**
     * Cleans a directory by deleting suspicious files.
     *
     * @param string $path
     * @param array $extensions
     * @param \Illuminate\Contracts\Logging\Log $log
     * @param bool $isPublicFolder
     */
    private function cleanDirectory(string $path, array $extensions, $log, bool $isPublicFolder)
    {
        try {
            $finder = new Finder();
            $finder->files()->in($path);

            // Kecualikan file dan folder penting di public
            if ($isPublicFolder) {
                // Gunakan exclude() untuk mengecualikan folder
                $finder->exclude('dashboard-kpb')->exclude('subdomain');
                // notPath() tetap digunakan untuk file
                $finder->notPath('index.php')->notPath('.htaccess')->notPath('googlef999394e30647c66.html');
            }

            // Tambahkan filter berdasarkan ekstensi
            foreach ($extensions as $ext) {
                $finder->name('*.'.$ext);
            }

            if (!$finder->hasResults()) {
                $this->info('Tidak ada file mencurigakan yang ditemukan.');
                $log->info('Tidak ada file mencurigakan yang ditemukan di folder ' . basename($path));
                return;
            }

            foreach ($finder as $file) {
                $filePath = $file->getRealPath();
                unlink($filePath);
                $this->info("Menghapus file: " . $filePath);
                $log->warning("File mencurigakan dihapus di " . basename($path) . ": " . $filePath);
            }

        } catch (\Exception $e) {
            $this->error('Gagal menjalankan proses pembersihan: ' . $e->getMessage());
            $log->error('Gagal menjalankan pembersihan di folder ' . basename($path) . ': ' . $e->getMessage());
        }
    }
}

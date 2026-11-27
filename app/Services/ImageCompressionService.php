<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageCompressionService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Upload an image file, compress & convert it to WebP (unless SVG/ICO),
     * save to storage/app/public/{subDir} and copy to public/berkas/.
     *
     * @param UploadedFile $file
     * @param string $subDir
     * @param int $maxWidth
     * @param int $quality
     * @return string Stored filename (e.g. abc123.webp)
     */
    public function uploadAndCompress(UploadedFile $file, string $subDir = 'uploads', int $maxWidth = 1920, int $quality = 82): string
    {
        $ext = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $baseHash = pathinfo($file->hashName(), PATHINFO_FILENAME);

        $storageDir = storage_path('app/public/' . trim($subDir, '/'));
        $publicBerkasDir = public_path('berkas');

        if (!is_dir($storageDir)) {
            @mkdir($storageDir, 0755, true);
        }
        if (!is_dir($publicBerkasDir)) {
            @mkdir($publicBerkasDir, 0755, true);
        }

        // Preserve vector/icon formats as-is
        if (in_array($ext, ['svg', 'ico'])) {
            $filename = $baseHash . '.' . $ext;
            Storage::disk('public')->putFileAs($subDir, $file, $filename);
            if (is_file($storageDir . DIRECTORY_SEPARATOR . $filename)) {
                @copy($storageDir . DIRECTORY_SEPARATOR . $filename, $publicBerkasDir . DIRECTORY_SEPARATOR . $filename);
            }
            return $filename;
        }

        $webpFilename = $baseHash . '.webp';
        $storageTarget = $storageDir . DIRECTORY_SEPARATOR . $webpFilename;
        $publicTarget = $publicBerkasDir . DIRECTORY_SEPARATOR . $webpFilename;

        try {
            @ini_set('memory_limit', '256M');
            $image = $this->manager->read($file->getRealPath());
            if ($image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }
            $encoded = $image->toWebp(quality: $quality);
            $encoded->save($storageTarget);

            if (is_file($storageTarget)) {
                @copy($storageTarget, $publicTarget);
            }

            Cache::forget('berkas_url_' . md5($webpFilename));
            return $webpFilename;
        } catch (\Throwable $e) {
            Log::warning('ImageCompressionService fallback to original upload: ' . $e->getMessage());

            // Fallback: store original file without crashing
            $fallbackName = $file->hashName();
            Storage::disk('public')->putFileAs($subDir, $file, $fallbackName);
            if (is_file($storageDir . DIRECTORY_SEPARATOR . $fallbackName)) {
                @copy($storageDir . DIRECTORY_SEPARATOR . $fallbackName, $publicBerkasDir . DIRECTORY_SEPARATOR . $fallbackName);
            }
            return $fallbackName;
        }
    }

    /**
     * Compress an existing local image file path to a .webp target path.
     */
    public function compressExistingFile(string $sourcePath, string $targetPath, int $maxWidth = 1920, int $quality = 82): bool
    {
        if (!is_file($sourcePath)) {
            return false;
        }

        $targetDir = dirname($targetPath);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        $image = $this->manager->read($sourcePath);
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }
        $image->toWebp(quality: $quality)->save($targetPath);

        return is_file($targetPath) && filesize($targetPath) > 0;
    }
}

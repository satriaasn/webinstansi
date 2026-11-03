<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FileController extends Controller
{
    /**
     * Allowed static file extensions for asset serving.
     */
    private const ALLOWED_ASSET_EXTENSIONS = [
        'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp',
        'ico', 'woff', 'woff2', 'ttf', 'eot', 'otf', 'map', 'pdf',
        'mp4', 'webm', 'ogg', 'mp3', 'wav'
    ];

    /**
     * Disallowed extensions in storage serving to prevent webshell execution.
     */
    private const DISALLOWED_STORAGE_EXTENSIONS = [
        'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'php8', 'phps', 'phar',
        'exe', 'sh', 'bash', 'cmd', 'bat', 'so', 'dll', 'cgi', 'pl', 'py'
    ];

    public function index($slashData = null)
    {
        if (empty($slashData) || str_contains($slashData, '..')) {
            abort(404);
        }

        $extension = strtolower(pathinfo($slashData, PATHINFO_EXTENSION));
        if (in_array($extension, self::DISALLOWED_STORAGE_EXTENSIONS, true)) {
            abort(403, 'Akses ke tipe berkas ini dilarang.');
        }

        if (!Storage::disk('public')->exists($slashData)) {
            $fallbacks = [
                'uploads/' . $slashData,
                'public/uploads/' . $slashData,
                'public/' . $slashData,
            ];
            $found = false;
            foreach ($fallbacks as $fb) {
                if (Storage::disk('public')->exists($fb)) {
                    $slashData = $fb;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                if (file_exists(public_path('berkas/' . $slashData))) {
                    return response()->file(public_path('berkas/' . $slashData));
                }
                abort(404);
            }
        }

        $file = Storage::disk('public')->path($slashData);
        $realFile = realpath($file);
        $publicRoot = realpath(Storage::disk('public')->path(''));

        // Prevent path traversal outside storage disk
        if (!$realFile || !str_starts_with($realFile, $publicRoot)) {
            abort(403, 'Akses tidak sah.');
        }

        return response()->file($realFile);
    }

    public function callFile($slashData = null)
    {
        return $this->serveSafeAsset($slashData);
    }

    public function callcssFile($slashData = null)
    {
        return $this->serveSafeAsset($slashData, 'text/css');
    }

    public function calljsFile($slashData = null)
    {
        return $this->serveSafeAsset($slashData, 'application/javascript');
    }

    private function serveSafeAsset($slashData, ?string $forcedContentType = null)
    {
        if (empty($slashData) || str_contains($slashData, '..')) {
            abort(404);
        }

        $assetsRoot = realpath(base_path('assets'));
        $targetFile = base_path($slashData);
        $realTarget = realpath($targetFile);

        // Security check: Target must exist and be strictly within base_path('assets')
        if (!$realTarget || !$assetsRoot || !str_starts_with($realTarget, $assetsRoot)) {
            abort(404);
        }

        $extension = strtolower(pathinfo($realTarget, PATHINFO_EXTENSION));
        if (!in_array($extension, self::ALLOWED_ASSET_EXTENSIONS, true)) {
            abort(403, 'Tipe berkas tidak diizinkan.');
        }

        $headers = [];
        if ($forcedContentType) {
            $headers['Content-Type'] = $forcedContentType;
        } elseif ($extension === 'css') {
            $headers['Content-Type'] = 'text/css';
        } elseif ($extension === 'js') {
            $headers['Content-Type'] = 'application/javascript';
        }

        return response()->file($realTarget, $headers);
    }

    public function uploadEditor(Request $request)
    {
        $rule['file'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

        $validator = Validator::make($request->all(), $rule, [], []);
        if ($validator->fails()) {
            return resValidator($validator);
        }

        $fileimage = $request->file('file');
        $hashImage = $fileimage->hashName();
        $fileimage->storeAs('public/editor', $hashImage);

        return response()->json(['location' => asset("berkas/editor/$hashImage")]);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor; // Pastikan model Visitor diimpor
use Illuminate\Support\Facades\Cache; // Import Cache Facade

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // --- Logika Pencatat Pengunjung (Disarankan menggunakan cache) ---

        $ip = $request->ip();
        $date = date('Y-m-d');
        $userAgent = $request->header('User-Agent');

        // Kunci cache unik per IP/Sesi dan tanggal
        $cacheKey = 'visitor_logged_' . md5($ip . $request->session()->getId() . $date);

        // Periksa di cache terlebih dahulu
        if (!Cache::has($cacheKey)) {
            // Jika tidak ada di cache, periksa database
            $existingVisitor = Visitor::where('session_id', $request->session()->getId())
                ->where('date_time', $date)
                ->first();

            if (!$existingVisitor) {
                // Jika belum ada di database, rekam
                $visitorData = [
                    'session_id' => $request->session()->getId(),
                    'ip_client' => $ip,
                    'user_agent' => $userAgent,
                    'date_time' => $date
                ];
                Visitor::create($visitorData);

                // Set cache agar tidak memproses lagi untuk hari ini
                Cache::put($cacheKey, true, now()->endOfDay());
            } else {
                // Jika sudah ada di database, set cache agar cepat diakses lain kali
                Cache::put($cacheKey, true, now()->endOfDay());
            }
        }

        // Lanjutkan permintaan ke controller atau middleware berikutnya
        return $next($request);
    }
}

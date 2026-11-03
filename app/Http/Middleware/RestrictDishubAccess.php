<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictDishubAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (app()->environment(['local', 'development'])) {
            return $next($request);
        }

        $allowedHosts = [
            'dishub.lampungprov.go.id',
            'localhost',
            '127.0.0.1',
            '::1',
        ];

        if (in_array($request->getHost(), $allowedHosts, true)) {
            return $next($request);
        }

        abort(403, 'Akses modul Dishub dibatasi.');
    }
}

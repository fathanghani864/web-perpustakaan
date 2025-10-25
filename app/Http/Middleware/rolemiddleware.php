<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!$request->user()) {
            // Arahkan ke login jika belum terautentikasi
            return redirect('/login');
        }

        // 2. Cek apakah role user SAMA dengan role yang diminta di route (dengan membandingkan case-insensitive)
        if (strtolower($request->user()->role) !== strtolower($role)) {
            // Jika tidak sama (misal admin masuk ke role:siswa), tolak akses
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
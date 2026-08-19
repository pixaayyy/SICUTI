<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pastikan user sudah login dan rolenya cocok
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Tendang ke halaman 403 jika role tidak sesuai
        abort(403, 'Akses Ditolak! Halaman ini bukan untuk role Anda.');
    }
}
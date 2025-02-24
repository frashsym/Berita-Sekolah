<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class SuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan memiliki role sebagai Super Admin
        if (!Auth::check() || Auth::user()->role_id != 1) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}

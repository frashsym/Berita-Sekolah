<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailSentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah session email sudah ada
        if (!$request->session()->has('email')) {
            return redirect()->route('password.request')->withErrors(['error' => 'Silakan masukkan email terlebih dahulu.']);
        }

        return $next($request);
    }
}

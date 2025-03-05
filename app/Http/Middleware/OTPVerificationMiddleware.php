<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OTPVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada session email dan otp_verified
        if (!$request->session()->has('email') || !$request->session()->has('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['error' => 'Akses tidak diizinkan.']);
        }

        return $next($request);
    }
}

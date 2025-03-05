<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Kunci cache untuk blokir dan attempt
        $lockKey = 'login_block_' . $email;
        $attemptKey = 'login_attempts_' . $email;

        // Cek apakah user sedang diblokir
        if (Cache::has($lockKey)) {
            $blockedUntil = Cache::get($lockKey);
            $remainingTime = max(0, $blockedUntil - now()->timestamp);

            if ($remainingTime > 0) {
                return response()->json([
                    'status' => 'blocked',
                    'remainingTime' => $remainingTime // Kirim waktu dalam detik ke frontend
                ], 429);
            } else {
                Cache::forget($lockKey);
                Cache::forget($attemptKey);
            }
        }

        // Ambil jumlah attempt dari cache
        $attempts = Cache::get($attemptKey, 0) + 1;

        // Coba otentikasi user
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            Cache::put($attemptKey, $attempts, 300); // Simpan attempt ke cache selama 3 menit

            // Jika gagal 3x, blokir login selama 3 menit
            if ($attempts >= 3) {
                $blockedUntil = now()->timestamp + 300; // Set waktu blokir
                Cache::put($lockKey, $blockedUntil, 300); // Simpan blokir selama 3 menit
                Cache::forget($attemptKey); // Reset attempt setelah diblokir

                return response()->json([
                    'status' => 'blocked',
                    'remainingTime' => 300 // Kirim 180 detik (3 menit)
                ], 429);
            }

            return response()->json([
                'status' => 'error',
                'message' => "Login gagal. Percobaan ke-$attempts dari 3."
            ], 401);
        }

        // Jika berhasil login, reset attempt dan blokir
        Cache::forget($attemptKey);
        Cache::forget($lockKey);
        $request->session()->regenerate();

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // public function logout(Request $request): RedirectResponse
    // {
    //     Auth::logout(); // Logout user

    //     $request->session()->invalidate(); // Hapus sesi
    //     $request->session()->regenerateToken(); // Regenerasi token CSRF

    //     return redirect()->route('login')->with('success', 'Anda telah logout.');
    // }
}

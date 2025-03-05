<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = DB::table('users')->where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        // Generate OTP 6 digit
        $otp = random_int(100000, 999999);

        // Simpan ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['otp_code' => $otp, 'otp_expires_at' => Carbon::now()->addMinutes(10), 'created_at' => Carbon::now()]
        );

        // Simpan email ke session
        session(['reset_email' => $request->email]);

        // Kirim email OTP
        Mail::raw("Kode OTP Anda untuk reset password: $otp (berlaku 10 menit)", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Kode OTP Reset Password');
        });

        // Redirect ke halaman OTP (tanpa email di URL)
        return redirect()->route('password.otp.form');
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        // Ambil email dari session
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan masukkan email terlebih dahulu.']);
        }

        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$resetRequest) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa']);
        }

        // Simpan email ke session agar bisa digunakan di halaman reset password
        session(['reset_email_verified' => $email]);

        // Redirect ke halaman reset password
        return redirect()->route('password.reset');
    }
}

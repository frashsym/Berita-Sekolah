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
    public function store(Request $request): RedirectResponse {
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
    
        // Kirim email OTP
        Mail::raw("Kode OTP Anda untuk reset password: $otp (berlaku 10 menit)", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode OTP Reset Password');
        });
    
        // Redirect langsung ke halaman OTP
        return redirect()->route('password.otp.form', ['email' => $request->email]);
    }

    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
        ]);

        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$resetRequest) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa']);
        }

        // Redirect ke halaman reset password
        return redirect()->route('password.reset', ['email' => $request->email]);
    }
}

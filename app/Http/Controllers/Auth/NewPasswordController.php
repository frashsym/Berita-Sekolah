<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create()
    {
        // Ambil email yang sudah diverifikasi dari session
        $email = session('reset_email_verified');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.reset-password');
    }


    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
        ]);

        // Ambil email dari session
        $email = session('reset_email_verified');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan verifikasi OTP terlebih dahulu.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session setelah reset password selesai
        session()->forget(['reset_email', 'reset_email_verified']);

        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login.');
    }
}

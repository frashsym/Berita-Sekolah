<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function profile(Request $request, $id)
    {
        $user = Auth::user();

        // Cek apakah user yang login mencoba mengakses profil orang lain
        if ($user->id != $id) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        // Jika permintaan berasal dari API (Postman atau AJAX), kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        // Jika dari browser, kembalikan tampilan halaman profile
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // Debugging: Pastikan data masuk
        // dd($request->all());

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:6',
        ]);

        // Jika ada foto yang diunggah
        if ($request->hasFile('foto')) { // <== Perbaiki key
            $file = $request->file('foto'); // <== Perbaiki key
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Coba cek apakah ada error dalam penyimpanan file
            if (!$file->move(public_path('images/profile'), $fileName)) {
                return back()->with('error', 'Gagal mengupload foto!');
            }

            // Hapus foto lama jika ada
            if ($user->photo && file_exists(public_path('images/profile/' . $user->photo))) {
                unlink(public_path('images/profile/' . $user->photo));
            }

            // Simpan nama foto baru
            $user->photo = $fileName;
        }

        // Update data user secara manual dan simpan
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save(); // Pastikan save() dipanggil

        return redirect()->route('profile', ['id' => $user->id])->with('success', 'Profile berhasil diperbarui!');
    }
}

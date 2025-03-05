<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar user (API & Web).
     */
    public function index()
    {
        $users = User::with('role')->paginate(5);
        $roles = Role::all();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        }

        return view('admin.admin.admin', compact('users', 'roles'));
    }

    /**
     * Menyimpan user baru (API & Web).
     */
    public function store(Request $request)
    {
        // Validasi input dengan pesan error kustom
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'role_id' => 'required|exists:roles,id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'role_id.required' => 'Pilih salah satu role.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan, coba gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'photo.image' => 'Foto harus berupa gambar.',
            'photo.mimes' => 'Format foto harus jpeg, png, jpg, atau gif.',
            'photo.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ]);

        // Proses upload foto jika ada
        $fileName = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profile'), $fileName);
        }

        // Simpan data admin baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $fileName, // Simpan nama file foto jika ada
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan.',
                'data' => $user,
            ], 201);
        }

        return redirect()->route('admin.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(Request $request, $id)
    {
        $user = User::with('role')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        return view('admin.admin.detail-admin', compact('user'));
    }

    /**
     * Mengupdate user (API & Web).
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'role_id.required' => 'Pilih salah satu role.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan, coba gunakan email lain.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::findOrFail($id);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profile'), $fileName);

            // Hapus foto lama jika ada
            if ($user->photo && file_exists(public_path('images/profile/' . $user->photo))) {
                unlink(public_path('images/profile/' . $user->photo));
            }

            // Simpan foto baru ke database
            $user->photo = $fileName;
        }

        // Update data user
        $user->update([
            'name' => $request->name ?? $user->name,
            'username' => $request->username ?? $user->username,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'photo' => $user->photo, // Pastikan foto disimpan
        ]);
        // dd($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui.',
                'data' => $user,
            ]);
        }


        return redirect()->route('admin.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user (API & Web).
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.index')->with('success', 'User berhasil dihapus!');
    }
}

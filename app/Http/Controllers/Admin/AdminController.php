<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar user (API & Web).
     */
    public function index()
    {
        $users = User::paginate(5);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        }

        return view('admin.admin.admin', compact('users'));
    }

    /**
     * Menyimpan user baru (API & Web).
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Simpan data ke database
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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

    /**
     * Menampilkan detail user (API & Web).
     */
    // public function show($id)
    // {
    //     $user = User::findOrFail($id);

    //     if (request()->wantsJson()) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $user,
    //         ]);
    //     }

    //     // return view('admin.admin.show', compact('user'));
    // }

    /**
     * Mengupdate user (API & Web).
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        $user = User::findOrFail($id);

        // Update data
        $user->update([
            'name' => $request->name ?? $user->name,
            'username' => $request->username ?? $user->username,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

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

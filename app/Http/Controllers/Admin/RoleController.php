<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Menampilkan daftar role (API).
     */
    public function index()
    {
        $roles = Role::paginate(5);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $roles,
            ]);
        }

        return view('admin.role.role', compact('roles'));
    }

    /**
     * Menyimpan role baru (API).
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|string|max:255|unique:roles',
        ]);

        // Simpan data ke database
        $role = Role::create([
            'role' => $request->role,
        ]);

        // Response JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil ditambahkan.',
                'data' => $role,
            ], 201);
        }

        // Jika dari Web, tampilkan SweetAlert dan redirect
        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan!');
    }

    /**
     * Mengupdate role (API).
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|string|max:255|unique:roles,role,' . $id,
        ]);

        // Ambil data role berdasarkan ID
        $role = Role::findOrFail($id);

        // Update data
        $role->update([
            'role' => $request->role,
        ]);

        // Response JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diperbarui.',
                'data' => $role,
            ]);
        }

        // Jika dari Web, tampilkan SweetAlert dan redirect
        return redirect()->route('role.index')->with('success', 'Role berhasil diupdate!');
    }

    /**
     * Menghapus role (API).
     */
    public function delete($id)
    {
        // Ambil data role berdasarkan ID
        $role = Role::findOrFail($id);

        // Hapus data
        $role->delete();

        // Response JSON
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus.',
            ]);
        }

        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus!');
    }
}

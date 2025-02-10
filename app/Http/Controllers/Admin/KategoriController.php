<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori (API).
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json([
            'success' => true,
            'data' => $kategoris,
        ]);
    }

    /**
     * Menyimpan kategori baru (API).
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|max:255|unique:kategori',
        ]);

        // Simpan data ke database
        $kategori = Kategori::create([
            'kategori' => $request->kategori,
        ]);

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $kategori,
        ], 201); // Status code 201: Created
    }

    /**
     * Menampilkan detail kategori (API).
     */
    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $kategori,
        ]);
    }

    /**
     * Mengupdate kategori (API).
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|max:255|unique:kategori,kategori,' . $id,
        ]);

        // Ambil data kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Update data
        $kategori->update([
            'kategori' => $request->kategori,
        ]);

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
            'data' => $kategori,
        ]);
    }

    /**
     * Menghapus kategori (API).
     */
    public function delete($id)
    {
        // Ambil data kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Hapus data
        $kategori->delete();

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }
}
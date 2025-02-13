<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori (API).
     */
    public function index()
    {
        $kategoris = Kategori::paginate(5);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $kategoris,
            ]);
        }

        return view('admin.kategori.kategori', compact('kategoris'));
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


        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan.',
                'data' => $kategori,
            ], 201);
        }

        // Jika dari Web, tampilkan SweetAlert dan redirect
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
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

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui.',
                'data' => $kategori,
            ]);
        }

        // Jika dari Web, tampilkan SweetAlert dan redirect
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
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
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.',
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}

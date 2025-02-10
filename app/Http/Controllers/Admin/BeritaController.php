<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    // public function index()
    // {
    //     return view('admin.berita');
    // }
    /**
     * Menampilkan daftar berita (API).
     */
    
    public function index()
    {
        $berita = Berita::with('kategori')->get();
        return response()->json([
            'success' => true,
            'data' => $berita,
        ]);
    }

    /**
     * Menyimpan berita baru (API).
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255|unique:berita',
            'isi_berita' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar_utama' => 'nullable|string',
        ]);

        // Simpan data ke database
        $berita = Berita::create($request->all());

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil ditambahkan.',
            'data' => $berita,
        ], 201);
    }

    /**
     * Menampilkan detail berita (API).
     */
    public function show($id)
    {
        $berita = Berita::with('kategori')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $berita,
        ]);
    }

    /**
     * Mengupdate berita (API).
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255|unique:berita,judul,' . $id,
            'isi_berita' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar_utama' => 'nullable|string',
        ]);

        // Ambil data berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Update data
        $berita->update($request->all());

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil diperbarui.',
            'data' => $berita,
        ]);
    }

    /**
     * Menghapus berita (API).
     */
    public function delete($id)
    {
        // Ambil data berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Hapus data
        $berita->delete();

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'Berita berhasil dihapus.',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita (API).
     */
     public function index(Request $request)
     {
         $berita = Berita::with('kategori')->get();
     
         // Jika permintaan berasal dari API (Postman atau AJAX), kembalikan JSON
         if ($request->wantsJson()) {
             return response()->json([
                 'success' => true,
                 'data' => $berita,
             ]);
         }
     
         // Jika dari browser, kembalikan tampilan halaman admin
         return view('admin.berita.berita', compact('berita'));
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
    public function show(Request $request, $id)
    {
        $berita = Berita::with('kategori')->findOrFail($id);
    
        // Jika permintaan berasal dari API (Postman atau AJAX), kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $berita,
            ]);
        }
    
        // Jika dari browser, kembalikan tampilan halaman detail berita
        return view('admin.berita.detail-berita', compact('berita'));
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

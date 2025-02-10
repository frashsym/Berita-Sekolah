<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Berita;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita (API).
     */
    public function index()
    {
        $berita = Berita::with('kategori')->get();
        $kategori = Kategori::all(); // Ambil semua kategori dari database

        // Cek jika request berasal dari API (Postman)
      if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $berita,  
            ]);
        }

        // Jika dari browser, tampilkan halaman berita
        return view('admin.berita.berita', compact('berita', 'kategori'));
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
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/berita'), $fileName);
        } else {
            $fileName = null;
        }

        // Simpan data berita ke database
        $berita = Berita::create([
            'judul' => $request->judul,
            'isi_berita' => $request->isi_berita,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'penulis' => $request->penulis,
            'kategori_id' => $request->kategori_id,
            'gambar_utama' => $fileName,
        ]);

        // Jika request dari API (Postman)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan.',
                'data' => $berita,
            ], 201);
        }

        // Jika dari Web, tampilkan SweetAlert dan redirect
        Alert::success('Sukses', 'Berita berhasil ditambahkan!');
        return redirect()->route('berita.index');
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

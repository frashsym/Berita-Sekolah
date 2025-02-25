<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $berita = Berita::with('kategori')->paginate(5);
        $kategori = Kategori::all();

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
            'judul' => 'required|string|max:255|',
            'isi_berita' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');

            // Ambil ekstensi file asli
            $extension = $file->getClientOriginalExtension();

            // Buat nama file baru dengan format [timestamp]_originalFileName.ext
            $fileName = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;

            // Pindahkan file ke folder penyimpanan
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
            'gambar_utama' => $fileName, // Simpan nama file dengan format yang diinginkan
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
        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
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
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil data berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Cek apakah ada gambar baru diunggah
        if ($request->hasFile('gambar_utama')) {
            $file = $request->file('gambar_utama');

            // Ambil ekstensi file asli
            $extension = $file->getClientOriginalExtension();

            // Buat nama file baru dengan format [timestamp]_originalFileName.ext
            $fileName = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;

            // Pindahkan file ke folder penyimpanan
            $file->move(public_path('images/berita'), $fileName);

            // Hapus gambar lama jika ada
            if ($berita->gambar_utama && file_exists(public_path('images/berita/' . $berita->gambar_utama))) {
                unlink(public_path('images/berita/' . $berita->gambar_utama));
            }

            // Simpan nama gambar baru
            $berita->gambar_utama = $fileName;
        }

        // Update data berita
        $berita->update([
            'judul' => $request->judul,
            'isi_berita' => $request->isi_berita,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'penulis' => $request->penulis,
            'kategori_id' => $request->kategori_id,
            'gambar_utama' => $berita->gambar_utama,
        ]);

        // **Cek jika request dari API (JSON)**
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui.',
                'data' => $berita,
            ]);
        }

        // **Jika dari Web, redirect ke halaman utama**
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate!');
    }


    /**
     * Menghapus berita (API).
     */
    public function delete($id)
    {
        // Ambil data berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Hapus gambar jika ada
        if ($berita->gambar_utama) {
            $path = public_path('images/berita/' . $berita->gambar_utama);
            if (file_exists($path)) {
                unlink($path); // Hapus file gambar
            }
        }

        // Hapus data berita
        $berita->delete();

        // Jika request dari API
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus.',
            ]);
        }

        // Jika dari Web, tampilkan SweetAlert dan redirect
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}

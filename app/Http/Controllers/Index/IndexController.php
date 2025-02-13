<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Berita;

class IndexController extends Controller
{
    public function index()
    {
        // Menggunakan eager loading untuk menghindari N+1 Query Problem
        $berita = Berita::with('kategori')->get();
        $kategori = Kategori::all();
        $beritaTerbaru = Berita::latest()->take(2)->get(); // Ambil 2 berita terbaru
        $beritaLainnya = Berita::latest()->skip(2)->take(3)->get(); // Ambil 3 berita setelah 2 terbaru

        // Jika request berasal dari API (Postman atau request JSON)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berita berhasil diambil',
                'berita' => $berita,
                'kategori' => $kategori
            ]);
        }

        // Mengirim data ke view dengan compact()
        return view('index.index', compact('berita', 'kategori', 'beritaTerbaru', 'beritaLainnya'));
    }

    public function about()
    {
        return view('index.about');
    }

    public function readmore(Request $request, $id)
    {
        $berita = Berita::with('kategori')->findOrFail($id);

        // Jika permintaan berasal dari API (Postman atau AJAX), kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $berita,
            ]);
        }

        // Kembalikan tampilan halaman readmore
        return view('index.readmore', compact('berita'));
    }

    public function kategori()
    {
        $kategoris = Kategori::get();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $kategoris,
            ]);
        }

        return view('index.kategori', compact('kategoris'));
    }

    public function beritaByKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $berita = Berita::where('kategori_id', $id)->latest()->get(); // Ambil berita berdasarkan kategori

        return view('index.berita-kategori', compact('kategori', 'berita'));
    }
}

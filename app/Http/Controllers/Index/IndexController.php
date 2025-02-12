<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
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
        return view('index.index', compact('berita', 'kategori', 'beritaTerbaru'));
    }

    public function about()
    {
        return view('index.about');
    }
}

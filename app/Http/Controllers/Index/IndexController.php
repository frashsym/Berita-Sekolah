<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Comment;
use App\Models\Berita;

class IndexController extends Controller
{
    public function index()
    {
        // Menggunakan eager loading untuk menghindari N+1 Query Problem
        $kategori = Kategori::all();
        $beritaTerbaru = Berita::latest()->take(2)->get(); // Ambil 2 berita utama
        $beritaLainnya = Berita::latest()->skip(2)->paginate(6); // Ambil berita lain (10 per halaman)

        // Jika request berasal dari API (Postman atau request JSON)
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berita berhasil diambil',
                'beritaTerbaru' => $beritaTerbaru,
                'beritaLainnya' => $beritaLainnya,
                'kategori' => $kategori
            ]);
        }

        // Mengirim data ke view dengan compact()
        return view('index.index', compact('beritaTerbaru', 'beritaLainnya', 'kategori'));
    }

    public function loadMore(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $beritaLainnya = Berita::latest()->skip(2)->paginate(6, ['*'], 'page', $page + 1);

            if ($beritaLainnya->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada berita lagi'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => view('index.partials.berita-list', compact('beritaLainnya'))->render(),
                'nextPage' => $beritaLainnya->hasMorePages() ? $page + 1 : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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

    /**
     * Menyimpan komentar dari user (API & Web).
     */
    public function komentar(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'isi_komentar' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'berita_id' => 'required|exists:berita,id',
        ]);

        $comment = Comment::create([
            'nama' => $request->nama,
            'isi_komentar' => $request->isi_komentar,
            'rating' => $request->rating,
            'tanggal_komentar' => now()->toDateString(),
            'jam_komentar' => now()->toTimeString(),
            'berita_id' => $request->berita_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan.',
            'data' => $comment,
        ]);
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

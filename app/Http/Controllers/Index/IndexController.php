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

        // Tambahkan view setiap kali berita dibuka
        $berita->increment('views');

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
            'isi_komentar' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'berita_id' => 'required|exists:berita,id',
        ]);

        $comment = Comment::create([
            'nama' => $request->nama,
            'isi_komentar' => $request->isi_komentar,
            'rating' => $request->rating,
            'tanggal_komentar' => now()->setTimezone('Asia/Jakarta')->toDateString(),
            'jam_komentar' => now()->setTimezone('Asia/Jakarta')->toTimeString(),
            'berita_id' => $request->berita_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan.',
            'data' => $comment,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari kategori yang sesuai
        $kategori = Kategori::where('kategori', 'LIKE', "%{$query}%")->first();

        // Cari berita berdasarkan judul atau isi berita
        $berita = Berita::where('judul', 'LIKE', "%{$query}%")
            ->orWhere('isi_berita', 'LIKE', "%{$query}%")
            ->get();

        if ($kategori) {
            // Jika ditemukan kategori, cari berita dalam kategori itu
            $beritaDalamKategori = Berita::where('kategori_id', $kategori->id)->get();
            return view('index.search.kategori', compact('kategori', 'beritaDalamKategori', 'query'));
        } elseif ($berita->isNotEmpty()) {
            // Jika ditemukan berita, tampilkan daftar berita
            return view('index.search.berita', compact('berita', 'query'));
        } else {
            // Jika tidak ada hasil, tampilkan halaman dengan pesan
            return view('index.search.berita', ['berita' => collect([]), 'query' => $query]);
        }
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

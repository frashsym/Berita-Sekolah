<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Berita;

class CommentController extends Controller
{
    /**
     * Menampilkan daftar komentar (API).
     */
    public function index()
    {
        $comments = Comment::with('berita')->paginate(5);
        $berita = Berita::all();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $comments,
            ]);
        }

        return view('admin.comments.comments', compact('comments', 'berita'));
    }

    /**
     * Menyimpan komentar baru (API).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'isi_komentar' => 'required|string',
            'rating' => 'required|max:5',
            'berita_id' => 'required|exists:berita,id',
        ]);

        // Tambahkan tanggal dan jam secara otomatis
        $data = $request->merge([
            'tanggal_komentar' => now()->setTimezone('Asia/Jakarta')->toDateString(),
            'jam_komentar' => now()->setTimezone('Asia/Jakarta')->toTimeString(),
        ])->all();

        // Simpan komentar
        $comment = Comment::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan.',
                'data' => $comment,
            ], 201);
        }

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail komentar (API).
     */
    public function show(Request $request, $id)
    {
        $comment = Comment::with('berita')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $comment,
            ]);
        }

        return view('admin.comments.detail-comments', compact('comment'));
    }

    /**
     * Mengupdate komentar (API).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'isi_komentar' => 'required|string',
            'tanggal_komentar' => 'required|date',
            'jam_komentar' => 'required',
            'berita_id' => 'required|exists:berita,id',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diperbarui.',
                'data' => $comment,
            ]);
        }

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil diperbarui!');
    }

    /**
     * Menghapus komentar (API).
     */
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
            ]);
        }

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil dihapus!');
    }
}

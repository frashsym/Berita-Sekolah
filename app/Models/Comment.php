<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments'; // Nama tabel

    protected $fillable = [
        'nama',
        'rating',
        'isi_komentar',
        'tanggal_komentar',
        'jam_komentar',
        'berita_id',
    ];

    /**
     * Relasi ke model Berita (Many to One)
     */
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            $comment->updateBeritaRating();
        });

        static::deleted(function ($comment) {
            $comment->updateBeritaRating();
        });
    }

    public function updateBeritaRating()
    {
        $berita = $this->berita;
        if ($berita) {
            $averageRating = $berita->comments()->avg('rating');
            $berita->update(['rating' => $averageRating]);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita'; // Nama tabel di database

    protected $fillable = [
        'judul',
        'isi_berita',
        'tanggal_publikasi',
        'penulis',
        'kategori_id',
        'gambar_utama',
    ];

    /**
     * Relasi dengan model Kategori (Many to One).
     * Setiap berita memiliki satu kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'berita_id');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('judul'); // Judul berita
            $table->text('isi_berita'); // Isi berita
            $table->date('tanggal_publikasi'); // Tanggal publikasi berita
            $table->string('penulis'); // Nama penulis
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade'); // FK ke tabel kategori
            $table->string('gambar_utama')->nullable(); // Gambar utama (opsional)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            $table->dropForeign(['kategori_id']);
        });

        // Hapus tabel berita
        Schema::dropIfExists('berita');
    }
};

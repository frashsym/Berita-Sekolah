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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('isi_komentar')->nullable();
            $table->date('tanggal_komentar');
            $table->time('jam_komentar');
            $table->foreignId('berita_id')->constrained('berita')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['berita_id']); // Hapus foreign key sebelum drop tabel
        });

        Schema::dropIfExists('comments');
    }
};

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Berita;
use App\Models\Kategori;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    protected $model = Berita::class;

    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(6), // Judul berita acak
            'isi_berita' => $this->faker->paragraphs(5, true), // Isi berita acak lebih panjang
            'tanggal_publikasi' => $this->faker->date(), // Tanggal random
            'penulis' => $this->faker->name(), // Nama penulis acak
            'kategori_id' => Kategori::inRandomOrder()->first()->id ?? 1, // Pilih kategori acak
            'gambar_utama' => 'ijazah.jpeg', // Gunakan 1 gambar yang sama di lokal
        ];
    }
}

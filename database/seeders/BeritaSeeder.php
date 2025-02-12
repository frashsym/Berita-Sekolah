<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Berita;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $berita = [
            [
                'judul' => 'Siswa RPL NeperTimes Juara Lomba Coding Nasional',
                'isi_berita' => 'Tim siswa jurusan Rekayasa Perangkat Lunak (RPL) dari NeperTimes berhasil meraih juara 1 dalam lomba coding tingkat nasional yang diselenggarakan di Jakarta.',
                'tanggal_publikasi' => Carbon::now()->subDays(1),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => 1,
                'gambar_utama' => 'ijazah.jpeg',
            ],
            [
                'judul' => 'OSIS NeperTimes Gelar Acara Bakti Sosial',
                'isi_berita' => 'Organisasi Siswa Intra Sekolah (OSIS) NeperTimes mengadakan kegiatan bakti sosial di panti asuhan sekitar untuk membantu anak-anak kurang mampu.',
                'tanggal_publikasi' => Carbon::now()->subDays(2),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => 2,
                'gambar_utama' => 'ijazah.jpeg',
            ],
            [
                'judul' => 'Lomba Desain UI/UX Diselenggarakan di NeperTimes',
                'isi_berita' => 'Sebagai bagian dari program peningkatan keterampilan digital, sekolah NeperTimes mengadakan lomba desain UI/UX yang diikuti oleh siswa dari berbagai jurusan.',
                'tanggal_publikasi' => Carbon::now()->subDays(3),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => 3,
                'gambar_utama' => 'ijazah.jpeg',
            ],
            [
                'judul' => 'Siswa NeperTimes Raih Beasiswa ke Luar Negeri',
                'isi_berita' => 'Seorang siswa berprestasi dari NeperTimes berhasil mendapatkan beasiswa penuh untuk melanjutkan studi di salah satu universitas ternama di luar negeri.',
                'tanggal_publikasi' => Carbon::now()->subDays(4),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => 1,
                'gambar_utama' => 'ijazah.jpeg',
            ],
            [
                'judul' => 'Kunjungan Industri ke Perusahaan Teknologi Terkenal',
                'isi_berita' => 'Siswa NeperTimes dari jurusan RPL melakukan kunjungan industri ke salah satu perusahaan teknologi terbesar di Indonesia untuk belajar lebih dalam tentang dunia IT.',
                'tanggal_publikasi' => Carbon::now()->subDays(5),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => 4,
                'gambar_utama' => 'ijazah.jpeg',
            ],
        ];

        // Tambahkan berita lainnya hingga total 30 berita
        for ($i = 6; $i <= 30; $i++) {
            $berita[] = [
                'judul' => "Kegiatan Ke-$i di NeperTimes Berjalan Sukses",
                'isi_berita' => "Kegiatan ke-$i yang diselenggarakan oleh sekolah NeperTimes berlangsung dengan meriah. Para siswa sangat antusias mengikuti acara tersebut.",
                'tanggal_publikasi' => Carbon::now()->subDays($i),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => rand(1, 4), // Pastikan kategori tersedia di database
                'gambar_utama' => 'ijazah.jpeg',
            ];
        }

        // Insert data ke database
        DB::table('berita')->insert($berita);
    }
}

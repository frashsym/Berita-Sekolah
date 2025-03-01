<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $berita = [];
        $now = Carbon::now()->setTimezone('Asia/Jakarta');

        // Generate the first 5 news items with sequential dates over the last 5 days
        for ($i = 0; $i < 5; $i++) {
            $berita[] = [
                'judul' => [
                    'Siswa RPL NeperTimes Juara Lomba Coding Nasional',
                    'OSIS NeperTimes Gelar Acara Bakti Sosial',
                    'Lomba Desain UI/UX Diselenggarakan di NeperTimes',
                    'Siswa NeperTimes Raih Beasiswa ke Luar Negeri',
                    'Kunjungan Industri ke Perusahaan Teknologi Terkenal'
                ][$i],
                'isi_berita' => [
                    'Tim siswa jurusan Rekayasa Perangkat Lunak (RPL) dari NeperTimes berhasil meraih juara 1 dalam lomba coding tingkat nasional yang diselenggarakan di Jakarta.',
                    'Organisasi Siswa Intra Sekolah (OSIS) NeperTimes mengadakan kegiatan bakti sosial di panti asuhan sekitar untuk membantu anak-anak kurang mampu.',
                    'Sebagai bagian dari program peningkatan keterampilan digital, sekolah NeperTimes mengadakan lomba desain UI/UX yang diikuti oleh siswa dari berbagai jurusan.',
                    'Seorang siswa berprestasi dari NeperTimes berhasil mendapatkan beasiswa penuh untuk melanjutkan studi di salah satu universitas ternama di luar negeri.',
                    'Siswa NeperTimes dari jurusan RPL melakukan kunjungan industri ke salah satu perusahaan teknologi terbesar di Indonesia untuk belajar lebih dalam tentang dunia IT.'
                ][$i],
                'tanggal_publikasi' => $now->copy()->subDays($i),
                'jam_publikasi' => $now->copy()->subDays($i)->setTime(rand(0, 23), rand(0, 59), rand(0, 59))->toTimeString(),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => $i % 4 + 1,
                'gambar_utama' => 'ijazah.jpeg',
            ];
        }

        // Generate the remaining news items with random dates before the main news items
        for ($i = 6; $i <= 30; $i++) {
            $randomDate = $now->copy()->subDays(rand(6, 30));
            $berita[] = [
                'judul' => "Kegiatan Ke-$i di NeperTimes Berjalan Sukses",
                'isi_berita' => "Kegiatan ke-$i yang diselenggarakan oleh sekolah NeperTimes berlangsung dengan meriah. Para siswa sangat antusias mengikuti acara tersebut.",
                'tanggal_publikasi' => $randomDate,
                'jam_publikasi' => $randomDate->setTime(rand(0, 23), rand(0, 59), rand(0, 59))->toTimeString(),
                'penulis' => 'Admin NeperTimes',
                'kategori_id' => rand(1, 4), // Pastikan kategori tersedia di database
                'gambar_utama' => 'ijazah.jpeg',
            ];
        }

        // Insert data ke database
        DB::table('berita')->insert($berita);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommentSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            [
                'nama' => 'John Doe',
                'isi_komentar' => 'Artikel ini sangat bermanfaat!',
                'tanggal_komentar' => Carbon::now()->toDateString(),
                'jam_komentar' => Carbon::now()->toTimeString(),
                'berita_id' => 1,
            ],
            [
                'nama' => 'Jane Smith',
                'isi_komentar' => 'Saya sangat setuju dengan pendapat ini.',
                'tanggal_komentar' => Carbon::now()->subDay()->toDateString(),
                'jam_komentar' => Carbon::now()->subHour()->toTimeString(),
                'berita_id' => 2,
            ],
            [
                'nama' => 'Michael Jordan',
                'isi_komentar' => 'Berita yang menarik untuk dibaca.',
                'tanggal_komentar' => Carbon::now()->subDays(2)->toDateString(),
                'jam_komentar' => Carbon::now()->subHours(2)->toTimeString(),
                'berita_id' => 3,
            ],
            [
                'nama' => 'Emma Watson',
                'isi_komentar' => 'Terima kasih telah berbagi informasi ini.',
                'tanggal_komentar' => Carbon::now()->subDays(3)->toDateString(),
                'jam_komentar' => Carbon::now()->subHours(3)->toTimeString(),
                'berita_id' => 1,
            ],
            [
                'nama' => 'Chris Hemsworth',
                'isi_komentar' => 'Saya memiliki pandangan berbeda, tetapi ini menarik!',
                'tanggal_komentar' => Carbon::now()->subDays(4)->toDateString(),
                'jam_komentar' => Carbon::now()->subHours(4)->toTimeString(),
                'berita_id' => 2,
            ],
        ]);
    }
}

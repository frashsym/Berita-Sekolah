<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['kategori' => 'Akademik',],
            ['kategori' => 'Pengumuman',],
            ['kategori' => 'Prestasi',],
            ['kategori' => 'Event',],
            ['kategori' => 'Ekstrakurikuler',],
            ['kategori' => 'Alumni',],
            ['kategori' => 'Fasilitas',],
            ['kategori' => 'Kerjasama',],
            ['kategori' => 'Lowongan Kerja',],
        ]);
    }
}

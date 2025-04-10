<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\KategoriSeeder;
use Database\Seeders\BeritaSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            BeritaSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders; // Tambahkan namespace yang benar

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'NeperTimes',
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        
        User::create([
            'name' => 'User NeperTimes',
            'username' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
        ]);
        
        User::create([
            'name' => 'Player NeperTimes',  
            'username' => 'Player',
            'email' => 'player@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}

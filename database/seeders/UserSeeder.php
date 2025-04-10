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
            'name' => 'John Doe',
            'username' => 'Admin_1',
            'role_id' => 1,
            'email' => 'admin' . rand(1, 100) . '@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'username' => 'User_2',
            'role_id' => 2,
            'email' => 'user' . rand(1, 100) . '@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Michael Johnson',
            'username' => 'Player_3',
            'role_id' => 2,
            'email' => 'player' . rand(1, 100) . '@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Emily Davis',
            'username' => 'Editor_4',
            'role_id' => 2,
            'email' => 'editor' . rand(1, 100) . '@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Chris Wilson',
            'username' => 'Guest_5',
            'role_id' => 2,
            'email' => 'guest' . rand(1, 100) . '@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}

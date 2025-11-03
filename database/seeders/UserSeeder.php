<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::firstOrCreate([
            'first_name' => 'Admin',
            'about' => 'Saya merupakan seorang Admin pertama',
            'phone_number' => '081234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User
        User::firstOrCreate([
            'first_name' => 'Satria',
            'last_name' => 'Bahari',
            'about' => 'Lorem Ipsum Dolor Sit Amet',
            'phone_number' => '082183340920',
            'email' => 'satria@gmail.com',
            'password' => Hash::make('satria'),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::firstOrCreate([
            'id' => 3,
            'first_name' => 'adoloka',
            'email' => 'adoloka.id@gmail.com',
            'google_id' => '115655485714016429101',
            'password' => Hash::make('adoloka123'),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

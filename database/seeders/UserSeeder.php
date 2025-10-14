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
        User::firstOrCreate([
            'first_name' => 'Satria',
            'last_name' => 'Bahari',
            'email' => 'satria@gmail.com',
            'phone_number' => '082183340920',
            'password' => Hash::make('satria'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name'   => 'Satria',
                'last_name'    => 'Bahari',
                'phone_number' => '082183340920',
                'password'     => Hash::make('satria'),
            ]
        );

        $umkms = [
            [
                'user_id' => $user->id,
                'name' => 'Pisang Melet',
                'type' => 'Makanan dan Minuman',
                'city' => 'Jambi',
                'latitude' => -1.6101223,
                'longitude' => 103.6148452,
                'address' => 'Jl. Sultan Thaha No.45, Jambi',
                'description' => 'Menjual pisang nugget dengan berbagai topping kekinian dan harga terjangkau.',
            ],
            [
                'user_id' => $user->id,
                'name' => 'AdoLoka Craft',
                'type' => 'Kerajinan Tangan',
                'city' => 'Muaro Jambi',
                'latitude' => -1.6783214,
                'longitude' => 103.5129371,
                'address' => 'Desa Mendalo Darat, Muaro Jambi',
                'description' => 'Produk kerajinan tangan berbahan dasar ecoprint dan anyaman lokal.',
            ],
            [
                'user_id' => $user->id,
                'name' => 'Kopi Nusantara',
                'type' => 'Minuman',
                'city' => 'Kota Jambi',
                'latitude' => -1.599883,
                'longitude' => 103.618912,
                'address' => 'Jl. M. Husni Thamrin No.23, Kota Jambi',
                'description' => 'Kedai kopi lokal yang menyajikan berbagai varian kopi dari Sumatera dan Jawa.',
            ],
        ];

        foreach ($umkms as $umkm) {
            Umkm::create($umkm);
        }
    }
}

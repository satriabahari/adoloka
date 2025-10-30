<?php

namespace Database\Seeders;

use App\Models\Umkm;
use App\Models\User;
use App\Models\EventAndUmkmCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan user tersedia
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name'   => 'Satria',
                'last_name'    => 'Bahari',
                'phone_number' => '082183340920',
                'password'     => Hash::make('satria'),
                'role_id'      => 2,
            ]
        );

        // Ambil semua kategori dari EventAndUmkmCategory
        $categories = EventAndUmkmCategory::pluck('id', 'name');

        // Daftar UMKM
        $umkms = [
            [
                'user_id'      => $user->id,
                'name'         => 'Pisang Melet',
                'category_id'  => $categories['UMKM Kuliner'] ?? null, // ambil dari kategori
                'city'         => 'Jambi',
                'latitude'     => -1.6101223,
                'longitude'    => 103.6148452,
                'address'      => 'Jl. Sultan Thaha No.45, Jambi',
                'description'  => 'Menjual pisang nugget dengan berbagai topping kekinian dan harga terjangkau.',
            ],
            [
                'user_id'      => $user->id,
                'name'         => 'AdoLoka Craft',
                'category_id'  => $categories['UMKM Perkebunan'] ?? null,
                'city'         => 'Muaro Jambi',
                'latitude'     => -1.6783214,
                'longitude'    => 103.5129371,
                'address'      => 'Desa Mendalo Darat, Muaro Jambi',
                'description'  => 'Produk kerajinan tangan berbahan dasar ecoprint dan anyaman lokal.',
            ],
            [
                'user_id'      => $user->id,
                'name'         => 'Kopi Nusantara',
                'category_id'  => $categories['UMKM Kuliner'] ?? null,
                'city'         => 'Kota Jambi',
                'latitude'     => -1.599883,
                'longitude'    => 103.618912,
                'address'      => 'Jl. M. Husni Thamrin No.23, Kota Jambi',
                'description'  => 'Kedai kopi lokal yang menyajikan berbagai varian kopi dari Sumatera dan Jawa.',
            ],
        ];

        // Insert ke database
        foreach ($umkms as $umkm) {
            if ($umkm['category_id']) { // hanya buat kalau kategori ditemukan
                Umkm::create($umkm);
            }
        }
    }
}

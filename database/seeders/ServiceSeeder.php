<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Umkm;
use App\Models\ServiceCategory;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. Buat user ---
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name' => 'Satria',
                'last_name' => 'Bahari',
                'phone_number' => '082183340920',
                'password' => Hash::make('satria'),
            ]
        );

        // --- 2. Buat UMKM ---
        $umkm = Umkm::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'UMKM Satria',
                'type' => 'Branding & Promosi',
                'city' => 'Jambi',
            ]
        );

        // --- 3. Buat kategori layanan ---
        $branding = ServiceCategory::firstOrCreate(
            ['slug' => 'branding'],
            ['name' => 'Branding']
        );

        $promosi = ServiceCategory::firstOrCreate(
            ['slug' => 'promosi'],
            ['name' => 'Promosi']
        );

        // --- 4. Data layanan ---
        $brandingServices = [
            [
                'name' => 'Desain Logo Profesional',
                'description' => 'Desain logo modern dengan 2x revisi dan file master (AI/PSD/SVG).',
                'price' => 100000,
                'revision_max' => 2,
                'delivery_days_min' => 3,
                'delivery_days_max' => 5,
                'has_brand_identity' => true,
            ],
            [
                'name' => 'Brand Guidelines Mini',
                'description' => 'Panduan dasar logo usage, warna, tipografi, dan contoh aplikasi.',
                'price' => 150000,
                'revision_max' => 2,
                'delivery_days_min' => 3,
                'delivery_days_max' => 5,
                'has_brand_identity' => true,
            ],
        ];

        $promosiServices = [
            [
                'name' => 'Foto Katalog Produk',
                'description' => 'Paket foto studio profesional untuk katalog produk UMKM.',
                'price' => 100000,
                'unit' => '/10 Foto',
                'revision_max' => 1,
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
            ],
            [
                'name' => 'Desain Poster Promosi',
                'description' => 'Poster A3/A4 untuk promo offline/online siap cetak & upload.',
                'price' => 75000,
                'unit' => '/Poster',
                'revision_max' => 2,
                'delivery_days_min' => 1,
                'delivery_days_max' => 2,
            ],
        ];

        // --- 5. Simpan layanan branding ---
        foreach ($brandingServices as $data) {
            Service::updateOrCreate(
                ['name' => $data['name']],
                [
                    ...$data,
                    'slug' => Str::slug($data['name']),
                    'category_id' => $branding->id,
                    'user_id' => $user->id,
                    'umkm_id' => $umkm->id,
                    'consultation_link' => 'https://wa.me/6281234567890',
                    'is_active' => true,
                ]
            );
        }

        // --- 6. Simpan layanan promosi ---
        foreach ($promosiServices as $data) {
            Service::updateOrCreate(
                ['name' => $data['name']],
                [
                    ...$data,
                    'slug' => Str::slug($data['name']),
                    'category_id' => $promosi->id,
                    'user_id' => $user->id,
                    'umkm_id' => $umkm->id,
                    'consultation_link' => 'https://wa.me/6281234567890',
                    'is_active' => true,
                ]
            );
        }
    }
}

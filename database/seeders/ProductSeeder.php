<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Umkm;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // === 1. Buat user utama ===
        $user = User::firstOrCreate(
            ['email' => 'satria@gmail.com'],
            [
                'first_name' => 'Satria',
                'last_name' => 'Bahari',
                'phone_number' => '082183340920',
                'password' => Hash::make('satria'),
            ]
        );

        // === 2. Buat UMKM ===
        $umkm = Umkm::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Pisang Melet',
                'type' => 'Kuliner',
                'city' => 'Jambi',
                'latitude' => -1.6101223,
                'longitude' => 103.6148452,
                'address' => 'Jl. Sultan Thaha No.45, Jambi',
                'description' => 'Menjual pisang nugget dengan berbagai topping kekinian dan harga terjangkau.',
            ]
        );

        // === 3. Buat kategori produk ===
        $categories = [
            'Kuliner',
            'Kerajinan',
            'Kesehatan dan Kecantikan',
            'Jasa',
            'Fashion dan Aksesoris',
            'Perkebunan',
        ];

        foreach ($categories as $name) {
            ProductCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // === 4. Data produk ===
        $products = [
            [
                'name' => 'Batik By Butik bu Revi',
                'description' => 'Karya batik cantik penuh pesona dengan motif khas tradisional Indonesia.',
                'price' => 275000,
                'stock' => 50,
                'category' => 'Kerajinan',
                'image' => 'batik.png',
            ],
            [
                'name' => 'Es Kelapa Kopyor Bang Jalil',
                'description' => 'Minuman segar es kelapa kopyor dengan gula aren asli.',
                'price' => 10000,
                'stock' => 140,
                'category' => 'Kuliner',
                'image' => 'es-kelapa.png',
            ],
            [
                'name' => 'Kebab Khas Turki',
                'description' => 'Kebab lezat dengan daging pilihan dan saus spesial yang menggugah selera.',
                'price' => 18000,
                'stock' => 90,
                'category' => 'Kuliner',
                'image' => 'kebab.png',
            ],
            [
                'name' => 'Tas Anyaman Rotan',
                'description' => 'Tas anyaman rotan handmade dengan desain etnik modern.',
                'price' => 185000,
                'stock' => 35,
                'category' => 'Kerajinan',
                'image' => 'batik.png',
            ],
            [
                'name' => 'Risol Mayo Mbak Anne',
                'description' => 'Risoles isi sayuran dengan saus mayo yang creamy dan lezat.',
                'price' => 5500,
                'stock' => 200,
                'category' => 'Kuliner',
                'image' => 'risol.png',
            ],
        ];

        // === 5. Simpan produk ke database ===
        foreach ($products as $data) {
            $category = ProductCategory::where('name', $data['category'])->first();

            $slug = Str::slug($data['name']);
            $imagePath = public_path('images/products/' . $data['image']);

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'is_active' => true,
                    'category_id' => $category?->id,
                    'user_id' => $user->id,
                    'umkm_id' => $umkm->id,
                ]
            );

            // Bersihkan media lama biar tidak double
            $product->clearMediaCollection('product');

            // Upload gambar jika file ada
            if (file_exists($imagePath)) {
                $product
                    ->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('product');
            }
        }
    }
}

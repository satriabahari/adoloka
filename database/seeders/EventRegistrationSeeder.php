<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            if (Event::count() === 0) {
                $this->call(EventSeeder::class);
            }

            $faker = fake('id_ID');

            $businessTypes = [
                'UMKM Kuliner',
                'UMKM Perkebunan',
                'UMKM Fashion',
                'UMKM Kerajinan',
                'UMKM Jasa Kreatif',
            ];

            // Letak file opsional (jika ada)
            $brandPhoto   = public_path('images/seed/brand_photo.jpg');
            $productPhoto = public_path('images/seed/product_photo.jpg');
            $ktpPhoto     = public_path('images/seed/ktp_photo.jpg');

            Event::query()->each(function (Event $event) use ($faker, $businessTypes, $brandPhoto, $productPhoto, $ktpPhoto) {
                $registrantCount = $faker->numberBetween(2, 5);

                for ($i = 0; $i < $registrantCount; $i++) {
                    $brandName = Str::headline($faker->unique()->words($faker->numberBetween(1, 3), true));

                    $registration = EventRegistration::create([
                        'event_id'                => $event->id,
                        'umkm_brand_name'         => $brandName,
                        'partner_address'         => $faker->streetAddress() . ', ' . $faker->city(),
                        'business_type'           => $faker->randomElement($businessTypes),
                        'owner_name'              => $faker->name(),
                        'whatsapp_number'         => $this->indoWhatsapp($faker->numerify('08##########')),
                        'instagram_name'          => Str::lower(Str::slug($brandName, '_')),
                        'business_license_number' => strtoupper($faker->bothify('NIB-##########')),
                    ]);

                    // Simpan gambar ke koleksi 'event_registration' dengan custom property 'kind'
                    $this->attachReplaceByKind($registration, 'brand', $brandPhoto);
                    $this->attachReplaceByKind($registration, 'product', $productPhoto);
                    $this->attachReplaceByKind($registration, 'ktp', $ktpPhoto);
                }
            });
        });
    }

    private function indoWhatsapp(string $number): string
    {
        $n = preg_replace('/\D+/', '', $number);
        if (Str::startsWith($n, '62')) {
            $n = '0' . substr($n, 2);
        }
        if (!Str::startsWith($n, '0')) {
            $n = '0' . $n;
        }
        return $n;
    }

    /**
     * Gantikan media lama per "kind" dalam koleksi 'event_registration' lalu tambah yang baru (jika file ada).
     */
    private function attachReplaceByKind(EventRegistration $registration, string $kind, string $path): void
    {
        // Hapus media lama dengan kind yang sama
        $registration->getMedia('event_registration')
            ->filter(fn($m) => $m->getCustomProperty('kind') === $kind)
            ->each->delete();

        // Tambahkan file jika tersedia
        if (is_file($path)) {
            $registration
                ->addMedia($path)
                ->withCustomProperties(['kind' => $kind])
                ->preservingOriginal()
                ->toMediaCollection('event_registration');
        }
    }
}

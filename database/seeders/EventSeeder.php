<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventAndUmkmCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $datas = [
            [
                'title' => 'Pasar Buah Jambi',
                'description' => 'Jadikan usahamu terkenal pada event tersebut.',
                'latitude' => -1.6101,
                'longitude' => 103.6131,
                'start_date' => '2026-08-10',
                'end_date'   => '2026-08-12',
                'type' => 'tahunan',
                'categories' => ['UMKM Perkebunan', 'UMKM Kuliner'],
                'is_strategic_location' => true,
                'image' => 'concert.jpg',
            ],
            [
                'title' => 'Car Free Night',
                'description' => 'Ramaikan malam bebas kendaraan sambil berjualan.',
                'latitude' => -1.6075,
                'longitude' => 103.6139,
                'start_date' => '2026-09-23',
                'end_date'   => '2026-09-23',
                'type' => 'mingguan',
                'categories' => ['UMKM Kuliner', 'UMKM Perkebunan'],
                'is_strategic_location' => true,
                'image' => 'party.jpg',
            ],
            [
                'title' => 'Car Free Day',
                'description' => 'Kesempatan branding usahamu di CFD.',
                'latitude' => -1.6022,
                'longitude' => 103.6170,
                'start_date' => '2026-09-28',
                'end_date'   => '2026-09-29',
                'type' => 'mingguan',
                'categories' => ['UMKM Kuliner', 'UMKM Perkebunan'],
                'is_strategic_location' => true,
                'image' => 'seminar.jpg',
            ],
            [
                'title' => 'Jambi Business Center',
                'description' => 'Jadikan usahamu terkenal pada Jambi Business Center.',
                'latitude' => -1.6135,
                'longitude' => 103.6128,
                'start_date' => '2025-08-10',
                'end_date'   => '2025-08-21',
                'type' => 'tahunan',
                'category' => 'UMKM Perkebunan',
                'is_strategic_location' => true,
                'image' => 'talkshow.jpg',
            ],
        ];

        foreach ($datas as $data) {
            $data['slug'] = Str::slug($data['title']);

            // Media
            $imageFile = $data['image'] ?? null;
            unset($data['image']);

            // Kategori
            $single = $data['category'] ?? null;
            $multiple = $data['categories'] ?? null;
            unset($data['category'], $data['categories']);

            // Simpan event
            $event = Event::updateOrCreate(['slug' => $data['slug']], $data);

            // Media koleksi 'event'
            $event->clearMediaCollection('event');
            if ($imageFile) {
                $path = public_path('/images/events/' . $imageFile);
                if (file_exists($path)) {
                    $event->addMedia($path)->preservingOriginal()->toMediaCollection('event');
                }
            }

            // Sinkronisasi kategori
            $names = $multiple ?: ($single ? [$single] : []);
            if ($names) {
                $ids = [];
                foreach ($names as $name) {
                    $cat = EventAndUmkmCategory::firstOrCreate(
                        ['slug' => Str::slug($name)],
                        ['name' => $name]
                    );
                    $ids[] = $cat->id;
                }
                $event->categories()->sync($ids);
            } else {
                $event->categories()->sync([]);
            }
        }
    }
}

{{-- @php
    $items = [
        ['name' => 'Kuliner', 'icon' => 'cup-hot'],
        ['name' => 'Kerajinan', 'icon' => 'brush'],
        ['name' => 'Kesehatan dan kecantikan', 'icon' => 'heart-pulse'],
        ['name' => 'Jasa', 'icon' => 'briefcase'],
        ['name' => 'Fashion dan Aksesoris', 'icon' => 'bag-heart'],
        ['name' => 'Perkebunan', 'icon' => 'flower3'],
    ];
@endphp

<div class="mx-auto px-4 pb-8">
    <div class="bg-white rounded-2xl p-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-sky-900">Berbagai Produk UMKM</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($items as $item)
                <div
                    class="group flex items-center gap-4 border border-gray-100 rounded-xl bg-white p-5 shadow hover:shadow-md transition hover:-translate-y-1 cursor-pointer">
                    <div
                        class="w-14 h-14 rounded-lg bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition">
                        <x-dynamic-component :component="'bi-' . $item['icon']" class="w-7 h-7 text-sky-600" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-sky-900">{{ $item['name'] }}</h3>
                        <p class="text-xs text-gray-500">Lihat produk</p>
                    </div>
                    <x-bi-arrow-right-short
                        class="text-gray-400 text-2xl opacity-0 group-hover:opacity-100 transition" />
                </div>
            @endforeach
        </div>
    </div>
</div> --}}

@php
    $items = [
        ['name' => 'Kuliner', 'icon' => 'cup-hot'],
        ['name' => 'Kerajinan', 'icon' => 'brush'],
        ['name' => 'Kesehatan dan kecantikan', 'icon' => 'heart-pulse'],
        ['name' => 'Jasa', 'icon' => 'briefcase'],
        ['name' => 'Fashion dan Aksesoris', 'icon' => 'bag-heart'],
        ['name' => 'Perkebunan', 'icon' => 'flower3'],
    ];
@endphp

<div class="mx-auto px-4 py-16 bg-white">
    <div class="rounded-2xl p-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8 animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-sky-900">Berbagai Produk UMKM</h2>
            <p class="text-gray-600 hidden md:block">Jelajahi kategori produk pilihan</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($items as $index => $item)
                <div
                    class="group flex items-center gap-4 border-2 border-gray-100 rounded-xl bg-white p-6 shadow-sm hover:shadow-xl hover:border-sky-300 transition-all duration-300 hover:-translate-y-1 cursor-pointer animate-fade-in-up"
                    style="animation-delay: {{ $index * 0.1 }}s">
                    <div
                        class="w-14 h-14 rounded-xl bg-sky-50 flex items-center justify-center group-hover:bg-sky-500 transition-all duration-300 group-hover:scale-110">
                        <x-dynamic-component :component="'bi-' . $item['icon']" class="w-7 h-7 text-sky-600 group-hover:text-white transition-colors duration-300" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-bold text-sky-900 group-hover:text-sky-600 transition-colors">{{ $item['name'] }}</h3>
                        <p class="text-xs text-gray-500 group-hover:text-sky-500 transition-colors">Lihat produk</p>
                    </div>
                    <svg class="w-6 h-6 text-gray-300 group-hover:text-sky-500 transform group-hover:translate-x-1 transition-all duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>

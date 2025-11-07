@props(['categories'])

@php
    // Mapping icon untuk setiap kategori berdasarkan slug atau nama
    $categoryIcons = [
        'kuliner' => 'cup-hot',
        'kerajinan' => 'brush',
        'kesehatan-dan-kecantikan' => 'heart-pulse',
        'jasa' => 'briefcase',
        'fashion-dan-aksesoris' => 'bag-heart',
        'perkebunan' => 'flower3',
    ];
@endphp

<div class="mx-auto px-4 py-16 bg-white">
    <div class="rounded-2xl p-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8 animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-primary-900">Berbagai Produk UMKM</h2>
            <a href="{{ route('products.index') }}"
                class="text-primary-600 hover:text-primary-700 font-medium hidden md:flex items-center gap-2 transition-colors">
                Lihat Semua
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($categories as $index => $category)
                @php
                    // Ambil icon berdasarkan slug, atau gunakan default 'tag' jika tidak ada
                    $icon = $categoryIcons[$category->slug] ?? 'tag';
                @endphp

                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                    class="group flex items-center gap-4 border-2 border-gray-100 rounded-xl bg-white p-6 shadow-sm hover:shadow-xl hover:border-primary-300 transition-all duration-300 hover:-translate-y-1 cursor-pointer animate-fade-in-up"
                    style="animation-delay: {{ $index * 0.1 }}s">
                    <div
                        class="w-14 h-14 rounded-xl bg-primary-50 flex items-center justify-center group-hover:bg-primary-500 transition-all duration-300 group-hover:scale-110">
                        <x-dynamic-component :component="'bi-' . $icon"
                            class="w-7 h-7 text-primary-600 group-hover:text-white transition-colors duration-300" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-base font-bold text-primary-900 group-hover:text-primary-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-gray-500 group-hover:text-primary-500 transition-colors">Lihat produk</p>
                    </div>
                    <svg class="w-6 h-6 text-gray-300 group-hover:text-primary-500 transform group-hover:translate-x-1 transition-all duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <p class="text-slate-500 font-medium">Belum ada kategori tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile View All Button -->
        @if ($categories->isNotEmpty())
            <div class="mt-8 md:hidden">
                <a href="{{ route('products.index') }}"
                    class="block w-full text-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold transition-colors">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
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

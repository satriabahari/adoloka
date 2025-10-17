<x-app-layout>
    {{-- HERO --}}
    <section
        class="py-12 flex flex-col gap-12 bg-gradient-to-r from-[rgb(17,65,119)] via-[#006A9A] to-[#17A18A] text-white items-center justify-center">
        <h1 class="text-3xl md:text-4xl font-extrabold">Menu Produk UMKM</h1>

        {{-- SEARCH BAR --}}
        <div class="max-w-xl w-full px-4">
            <input type="text" placeholder="Cari..."
                class="w-full rounded-full border px-8 text-black border-gray-200 focus:ring-2 focus:ring-sky-400 focus:outline-none p-3">
        </div>
    </section>



    {{-- CONTENT --}}
    <section class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            {{-- <a href="{{ route('events') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-50 hover:bg-sky-100 text-sky-800 transition">
                ← Back
            </a> --}}

            <button
                class="flex gap-2 mb-8 bg-gradient-to-r from-[rgb(17,65,119)] via-[#006A9A] to-[#17A18A] text-white py-1 px-4 rounded-md">
                <x-heroicon-o-arrow-left />
                <p>Back</p>
            </button>
        </div>

        <div class="flex gap-4">

            <livewire:filter-products />

            {{-- GRID PRODUK --}}
            {{-- <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <x-product-card :image="$product->image_url" :title="$product->name" :price="'Rp' . number_format($product->price, 0, ',', '.')" :rating="rand(3, 5)"
                    :reviews="rand(120, 800)" />
                    <x-product-card :product="$product" />
                @endforeach
            </div> --}}
        </div>
    </section>
</x-app-layout>

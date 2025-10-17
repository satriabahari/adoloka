@props([
    'title' => 'Harga paket',
    'price' => 'Rp. 50.000 - Rp 100.000',
    'delivery' => '3–5 hari',
    'revision' => '1–3 kali',
])

<div class="rounded-3xl bg-white ring-1 ring-gray-200 shadow-[0_10px_40px_rgba(0,0,0,0.06)] p-6 md:p-8 max-w-sm">
    {{-- Title --}}
    <h3 class="text-gray-900 font-medium mb-2">{{ $title }}</h3>

    {{-- Price --}}
    <p class="text-2xl md:text-3xl font-semibold text-[#114177] mb-6">{{ $price }}</p>

    {{-- Details --}}
    <div class="text-sm text-gray-700 space-y-2 mb-6">
        <div class="flex justify-between">
            <span>Delivery time</span>
            <span>{{ $delivery }}</span>
        </div>
        <div class="flex justify-between">
            <span>Revisi</span>
            <span>{{ $revision }}</span>
        </div>
    </div>

    <hr class="border-gray-300 mb-6">

    {{-- Buttons --}}
    <div class="flex flex-col gap-3">
        {{-- Primary Button --}}
        <button
            class="w-full py-3 rounded-lg text-white font-medium text-sm tracking-wide
            bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] hover:opacity-90 transition">
            pesan sekarang
        </button>

        {{-- Secondary Button --}}
        <button
            class="w-full py-3 rounded-lg text-[#114177] font-medium text-sm border border-gray-400 hover:bg-gray-50 transition">
            konsultasi gratis
        </button>
    </div>
</div>

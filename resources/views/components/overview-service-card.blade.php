@props([
    'title' => 'Overview',
    // Isi 6 poin (akan otomatis mengalir jika jumlahnya berbeda)
    'items' => [
        'Mockup preview',
        'File PNG, JPG',
        'Konsep logo original',
        '1 Konsep logo utama',
        'Brand guideline sederhana',
        'Panduan penggunaan logo',
    ],
])

<div class="pt-12">
    {{-- Judul --}}
    <h3 class="text-xl md:text-2xl font-medium text-gray-900 mb-3">{{ $title }}</h3>

    {{-- Kartu --}}
    <div class="rounded-3xl bg-white ring-1 ring-gray-200 shadow-[0_12px_18px_rgba(0,0,0,0.08)] p-5 md:p-8">
        <ul class="grid grid-cols-1 md:grid-cols-3 gap-y-10 md:gap-y-12">
            @foreach ($items as $item)
                <li class="text-center text-gray-800">
                    {{ $item }}
                </li>
            @endforeach
        </ul>
    </div>
</div>

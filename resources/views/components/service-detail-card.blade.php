@props([
    'category' => 'Brand Identity',
    'duration' => '3–5 Hari',
    'title' => 'Desain Logo Profesional',
    'image' => '/images/sample-service.jpg',
    'desc' =>
        'Bangun identitas brand Anda dengan logo profesional. Kami menghadirkan desain logo modern, mudah diingat, dan fleksibel untuk mendukung berbagai kebutuhan bisnis Anda.',
])

<div class="rounded-3xl bg-white ring-1 ring-gray-200 shadow-[0_10px_40px_rgba(0,0,0,0.06)] p-6 md:p-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
        {{-- LEFT: Text --}}
        <div class="order-2 md:order-1">
            {{-- Pills --}}
            <div class="flex items-center gap-4 mb-6">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                    {{ $category }}
                </span>
                <span class="inline-flex items-center gap-2 text-gray-600">
                    {{-- Clock icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2.25a9.75 9.75 0 1 0 9.75 9.75A9.761 9.761 0 0 0 12 2.25Zm0 17.5a7.75 7.75 0 1 1 7.75-7.75A7.759 7.759 0 0 1 12 19.75Zm.75-12a.75.75 0 0 0-1.5 0v4.25c0 .199.079.39.22.53l2.75 2.75a.75.75 0 1 0 1.06-1.06l-2.53-2.53V7.75Z" />
                    </svg>
                    <span class="text-sm font-medium">{{ $duration }}</span>
                </span>
            </div>

            {{-- Title --}}
            <h2 class="text-3xl md:text-4xl font-semibold tracking-tight text-gray-900 mb-5">
                {{ $title }}
            </h2>

            {{-- Description (split into lines mirip contoh) --}}
            <div class="text-gray-700 leading-7 space-y-4 max-w-xl">
                @php
                    // Jika ingin memecah jadi beberapa baris persis seperti contoh, pisahkan pakai "\n\n"
                    $paragraphs = preg_split("/\n{2,}/", trim($desc));
                @endphp
                @foreach ($paragraphs as $p)
                    <p>{{ $p }}</p>
                @endforeach
            </div>
        </div>

        {{-- RIGHT: Image --}}
        <div class="order-1 md:order-2">
            <div class="rounded-2xl overflow-hidden ring-1 ring-gray-200">
                <img src="{{ $image }}" alt="{{ $title }}"
                    class="w-full h-full object-cover aspect-[4/3] md:aspect-square" />
            </div>
        </div>
    </div>
</div>

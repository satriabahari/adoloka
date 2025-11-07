@props([
    'title' => 'Mengapa Harus',
    'highlight' => 'Adoloka?',
    'image' => 'images/home/benefit.jpg',
    'items' => [],
])

<section class="bg-sky-50 rounded-2xl py-16 px-6 md:px-12">
    <div class="container mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-primary-900 mb-12 text-center md:text-left animate-fade-in">
            {{ $title }} <span class="text-primary-600">{{ $highlight }}</span>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="order-2 lg:order-1 animate-slide-in-left">
                <div
                    class="bg-white rounded-3xl shadow-2xl p-3 border border-primary-100 hover:shadow-primary-200 transition-all duration-300 hover:-translate-y-2">
                    <img src="{{ asset($image) }}" alt="why" class="w-full rounded-2xl">
                </div>
            </div>

            {{-- Benefits List --}}
            <div class="order-1 lg:order-2 animate-slide-in-right">
                <div
                    class="bg-white rounded-2xl shadow-xl p-8 border border-primary-100 hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-xl font-bold text-sky-900 mb-6 flex items-center gap-2">
                        <span class="w-1 h-8 bg-primary-500 rounded-full"></span>
                        Jika kamu merasa...
                    </h3>

                    <ul class="space-y-5">
                        @foreach ($items as $i => $item)
                            <li
                                class="flex items-start group animate-fade-in-up [animation-delay:{{ number_format(($i + 1) * 0.1, 1) }}s]">
                                <div
                                    class="flex-shrink-0 w-6 h-6 bg-primary-500 rounded-full mt-1 mr-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-sky-800 group-hover:text-sky-900 transition-colors">
                                    {{ Arr::get($item, 'text') }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

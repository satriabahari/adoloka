<x-app-layout>
    <div class="max-w-7xl mx-auto pt-12">
        {{-- Back Button --}}
        {{-- <div class="mb-8">
            <a href="{{ route('home') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-sky-200 text-sky-700 bg-white shadow-sm hover:bg-sky-50 hover:shadow-md transition-all duration-200 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div> --}}

        <div class="mb-8">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="font-medium">Kembali</span>
            </a>

            <h1 class="text-3xl font-bold text-slate-800">Event Mendatang</h1>
            <p class="text-slate-600 mt-2">Jelajahi berbagai event menarik yang akan datang. Temukan pengalaman baru dan
                bergabunglah bersama kami!</p>
        </div>

        {{-- Header Section --}}
        {{-- <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <div
                    class="h-12 w-12 rounded-full bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1
                    class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-700 to-sky-900">
                    Event Mendatang
                </h1>
            </div>
            <p class="text-lg text-slate-600 max-w-xl">
                Jelajahi berbagai event menarik yang akan datang. Temukan pengalaman baru dan bergabunglah bersama
                kami!
            </p>
        </div> --}}

        {{-- Events Grid --}}
        <div class="grid grid-cols-1 gap-6 lg:gap-8">
            @foreach ($events as $event)
                <x-event-card :event="$event" :title="$event->title" :description="$event->description" :image="$event->image_url"
                    :chips="[
                        // kirim SEMUA kategori lewat key 'categories'
                        ['is_strategic_location' => $event->is_strategic_location ? 'Lokasi Strategis' : null],
                        ['type' => $event->type ? ucfirst($event->type) : null],
                        ['categories' => $event->categories->pluck('name')->all()],
                    ]" />
            @endforeach

        </div>

        {{-- Empty State --}}
        @if ($events->isEmpty())
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-sky-100 mb-6">
                    <svg class="w-10 h-10 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Event</h3>
                <p class="text-gray-600">Event menarik akan segera hadir. Pantau terus halaman ini!</p>
            </div>
        @endif
    </div>
</x-app-layout>

{{-- @props(['events'])

<section class="bg-white py-16">
    <div class="container mx-auto px-12">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-900">
                Pilih Event yang sesuai dengan usahamu
            </h2>
            <a href="{{ route('events') }}"
                class="border border-sky-500 text-sky-600 hover:bg-sky-50 px-5 py-2 rounded-full transition">
                Lihat Semua Event
            </a>
        </div>

        <!-- Event Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-24">
            @foreach ($events as $event)
                <a href="{{ route('events.show', $event->slug) }}"
                    class="bg-white rounded-2xl shadow-md ring-1 ring-gray-200 overflow-hidden hover:shadow-lg transition">
                    <!-- Event Image -->
                    <div class="h-56 w-full overflow-hidden">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Event Info -->
                    <div class="p-5">
                        <h3 class="text-lg font-medium text-gray-800 mb-3">
                            {{ $event->title }}
                        </h3>

                        <div class="flex flex-col gap-2 text-sm text-gray-700">
                            <!-- Date -->
                            <div class="flex items-center gap-2">
                                <x-bxs-time-five class="w-6 h-6" />
                                <span>{{ $event->date_range }}</span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-2">
                                <x-bxs-map class="w-6 h-6" />
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section> --}}

@props(['events'])

<section class="bg-gradient-to-b from-white to-sky-50 py-16">
    <div class="container mx-auto px-12">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8 animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
                Pilih Event yang sesuai dengan usahamu
            </h2>
            <a href="{{ route('events') }}"
                class="border-2 border-sky-500 text-sky-600 hover:bg-sky-500 hover:text-white px-6 py-2.5 rounded-full transition-all duration-300 font-medium hover:shadow-lg">
                Lihat Semua Event
            </a>
        </div>

        <!-- Event Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($events as $event)
                <a href="{{ route('events.show', $event->slug) }}"
                    class="bg-white rounded-2xl shadow-md ring-1 ring-gray-100 overflow-hidden hover:shadow-2xl hover:ring-sky-300 transition-all duration-300 transform hover:-translate-y-2 group animate-fade-in-up"
                    style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <!-- Event Image -->
                    <div class="h-56 w-full overflow-hidden relative">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-sky-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>

                    <!-- Event Info -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 group-hover:text-sky-600 transition-colors">
                            {{ $event->title }}
                        </h3>

                        <div class="flex flex-col gap-3 text-sm text-gray-600">
                            <!-- Date -->
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition-colors">
                                    <x-bxs-time-five class="w-5 h-5 text-sky-600" />
                                </div>
                                <span>{{ $event->date_range }}</span>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition-colors">
                                    <x-bxs-map class="w-5 h-5 text-sky-600" />
                                </div>
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

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
            transform: translateY(30px);
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
        animation: fadeInUp 0.8s ease-out forwards;
    }
</style>

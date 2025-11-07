@props(['events'])

<section class="bg-sky-50 rounded-2xl py-16">
    <div class="container mx-auto px-12">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8 animate-fade-in">
            <h2 class="text-2xl md:text-3xl font-bold text-primary-900">
                Pilih Event yang sesuai dengan usahamu
            </h2>
            <a href="{{ route('events.index') }}"
                class="border-2 border-primary-500 text-primary-600 hover:bg-primary-500 hover:text-white px-6 py-2.5 rounded-full transition-all duration-300 font-medium hover:shadow-lg">
                Lihat Semua Event
            </a>
        </div>

        <!-- Event Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($events as $event)
                <a href="{{ route('events.show', $event->slug) }}"
                    class="bg-white rounded-2xl shadow-md ring-1 ring-sky-100 overflow-hidden hover:shadow-2xl hover:ring-primary-300 transition-all duration-300 transform hover:-translate-y-2 group animate-fade-in-up"
                    style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <!-- Event Image -->
                    <div class="h-56 w-full overflow-hidden relative">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-primary-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>

                    <!-- Event Info -->
                    <div class="p-6">
                        <h3
                            class="text-lg font-semibold text-sky-800 mb-4 group-hover:text-primary-600 transition-colors">
                            {{ $event->title }}
                        </h3>

                        <div class="grid grid-cols-[1fr_auto] justify-center items-center gap-3 text-sm text-sky-600">
                            <!-- Date -->
                            <div
                                class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                                <x-bxs-time-five class="w-5 h-5 text-primary-600" />
                            </div>
                            <span>{{ $event->date_range }}</span>

                            <!-- Address -->
                            <div
                                class="w-10 h-10 rounded-full bg-primary-50 flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                                <x-bxs-map class="w-5 h-5 text-primary-600" />
                            </div>
                            <span>{{ $event->address }}</span>
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

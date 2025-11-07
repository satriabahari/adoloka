@props(['title', 'description' => null, 'image' => null, 'chips' => [], 'event' => null])

@php
    // Ubah semua chips menjadi list of ['key' => ..., 'value' => ...]
    // - ['categories' => ['A','B']] -> [['key'=>'category','value'=>'A'], ['key'=>'category','value'=>'B']]
    // - ['type' => 'X']             -> [['key'=>'type','value'=>'X']]
    // - ['is_strategic_location'=>'Lokasi Strategis'] -> [['key'=>'is_strategic_location','value'=>'Lokasi Strategis']]
    $chipItems = collect($chips)
        ->flatMap(function ($item) {
            if (!is_array($item)) {
                return [];
            }

            if (array_key_exists('categories', $item) && is_array($item['categories'])) {
                return collect($item['categories'])->filter()->map(fn($c) => ['key' => 'category', 'value' => $c]);
            }

            $key = array_key_first($item);
            $val = $item[$key] ?? null;

            return $val ? [['key' => $key, 'value' => $val]] : [];
        })
        // (opsional) hilangkan duplikat kategori persis sama
        ->unique(function ($i) {
            return $i['key'] === 'category' ? 'category-' . $i['value'] : $i['key'] . '-' . $i['value'];
        })
        ->values();

    $detailUrl = $event ? route('events.show', $event) : '#';
@endphp

<div
    class="group bg-white rounded-2xl shadow-md hover:shadow-xl ring-1 ring-slate-200 overflow-hidden transition-all duration-300 hover:-translate-y-1">
    <div class="grid md:grid-cols-[280px,1fr] items-stretch h-full">
        {{-- Image Section --}}
        <div class="relative overflow-hidden bg-slate-100">
            <a href="{{ $detailUrl }}" class="block h-full">
                <div class="aspect-[4/3] md:aspect-auto md:h-full w-full overflow-hidden">
                    @if ($image)
                        <img src="{{ $image }}" alt="{{ $title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                            <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </a>

            {{-- Event Badge Overlay --}}
            <div class="absolute top-4 left-4">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/95 text-primary-700 shadow-lg backdrop-blur-sm">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                    EVENT
                </span>
            </div>
        </div>

        {{-- Content Section --}}
        <div class="p-6 md:p-7 flex flex-col justify-between">
            <div>
                {{-- Title --}}
                <h2
                    class="text-2xl md:text-3xl leading-tight font-bold text-slate-900 mb-3 group-hover:text-primary-700 transition-colors duration-200">
                    <a href="{{ $detailUrl }}" class="hover:underline underline-offset-4 decoration-2">
                        {{ $title }}
                    </a>
                </h2>

                {{-- Description --}}
                @if ($description)
                    <p class="text-slate-600 leading-relaxed line-clamp-2 mb-4">
                        {{ $description }}
                    </p>
                @endif

                {{-- Chips/Tags --}}
                @if ($chipItems->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach ($chipItems as $chip)
                            @php
                                $key = $chip['key'];
                                $label = $chip['value'];

                                $classes = match ($key) {
                                    'is_strategic_location' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                                    'type' => 'bg-green-50 border-green-200 text-green-700',
                                    'category' => 'bg-primary-50 border-primary-200 text-primary-700',
                                    default => 'bg-slate-50 border-slate-200 text-slate-700',
                                };
                            @endphp

                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $classes }}">
                                {{ $label }}
                            </span>
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- Action Button --}}
            <div class="mt-auto pt-4">
                <a href="{{ $detailUrl }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 shadow-md hover:shadow-lg transition-all duration-200 group">
                    <span>Lihat Detail</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

@props(['title', 'description' => null, 'image' => null, 'chips' => [], 'event' => null])

@php
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
                            class="w-full h-full flex items-center justify-center bg-gradient-to-br from-sky-100 to-sky-200">
                            <svg class="w-16 h-16 text-sky-400" fill="none" stroke="currentColor"
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
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/95 text-sky-700 shadow-lg backdrop-blur-sm">
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
                    class="text-2xl md:text-3xl leading-tight font-bold text-slate-900 mb-3 group-hover:text-sky-700 transition-colors duration-200">
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
                @if (count(array_filter($chips)))
                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach ($chips as $chip)
                            @if ($chip)
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $chip }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Action Button --}}
            <div class="mt-auto pt-4">
                <a href="{{ $detailUrl }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 shadow-md hover:shadow-lg transition-all duration-200 group">
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

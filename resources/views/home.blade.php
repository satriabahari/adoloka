<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="max-w-7xl mx-auto ">
        <div class="bg-white overflow-hidden shadow-sm">
            <x-hero />
            {{-- <x-events-home /> --}}
            <x-products />
            <x-why />
            <x-feature />
            <x-faq />
        </div>
    </div>
</x-app-layout>

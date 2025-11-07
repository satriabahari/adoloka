<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white">
        <div class="bg-white overflow-hidden shadow-sm">
            <x-hero />
            <x-service-card />
            <x-events-home :events="$events" />
            <x-category-card :categories="$categories" />
            <x-benefits :items="$benefits" />
            <x-feature />
            <x-faq />
        </div>
    </div>
</x-app-layout>

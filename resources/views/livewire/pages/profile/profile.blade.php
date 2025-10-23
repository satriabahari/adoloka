    <div class="container mx-auto pt-12 max-w-6xl">
        <button onclick="window.history.back()"
            class="flex items-center gap-2 text-sky-600 hover:text-sky-700 transition-colors mb-8 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-medium">Kembali</span>
        </button>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <livewire:profile.update-profile-information />

            <livewire:profile.update-umkm-information />

            <livewire:profile.update-product-information />

            <livewire:profile.update-service-information />
        </div>
    </div>

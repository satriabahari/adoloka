    <div class="container mx-auto px-4 py-12 ">
        <button
            class="flex gap-2 mb-8 items-center bg-gradient-to-r from-[rgb(17,65,119)] via-[#006A9A] to-[#17A18A] text-white py-1 px-4 rounded-md">
            <x-bi-arrow-left-short />
            <p>Back</p>
        </button>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <livewire:profile.update-profile-information />

            <livewire:profile.update-umkm-information />

            <livewire:profile.update-product-information />

            <livewire:profile.update-service-information />
        </div>
    </div>

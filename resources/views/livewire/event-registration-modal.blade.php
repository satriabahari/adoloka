@push('styles')
    @vite('resources/css/registration.css')
@endpush

<div>
    <!-- Trigger Button -->
    <button wire:click="openModal" type="button"
        class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl font-semibold text-sky-800
               ring-2 ring-sky-200 hover:ring-sky-300 bg-white hover:bg-sky-50 transition-all duration-200
               hover:shadow-md">
        Daftar
    </button>

    <!-- Modal Backdrop & Content -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>

        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4 pt-16">
            <div x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" @click.away="$wire.closeModal()"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden">

                <!-- Header -->
                <div
                    class="sticky top-0 bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white">Form Pendaftaran Event</h2>
                    <button wire:click="closeModal" type="button"
                        class="text-white hover:bg-white/20 rounded-lg p-1 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Content -->
                <div class="p-6 overflow-y-auto max-h-[calc(85vh-80px)]">
                    <form wire:submit.prevent="submit" class="space-y-5">

                        <!-- Nama Brand UMKM -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Brand UMKM <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="umkm_brand_name"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('umkm_brand_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Mitra -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Alamat Mitra <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="partner_address" rows="3"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition"></textarea>
                            @error('partner_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Jenis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="business_type"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('business_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Pemilik -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Pemilik <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="owner_name"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('owner_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Whatsapp -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nomor Whatsapp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="whatsapp_number"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition"
                                placeholder="08xxxxxxxxxx">
                            @error('whatsapp_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Instagram -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Instagram
                            </label>
                            <input type="text" wire:model="instagram_name"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition"
                                placeholder="@username">
                            @error('instagram_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Brand -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Foto Brand UMKM <span class="text-red-500">*</span>
                            </label>
                            <div
                                class="relative border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-sky-400 transition">
                                <input type="file" wire:model="brand_photo" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="flex flex-col items-center justify-center text-slate-600">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm">
                                        @if ($brand_photo)
                                            {{ $brand_photo->getClientOriginalName() }}
                                        @else
                                            Klik untuk upload foto
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @error('brand_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Produk -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Foto Produk <span class="text-red-500">*</span>
                            </label>
                            <div
                                class="relative border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-sky-400 transition">
                                <input type="file" wire:model="product_photo" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="flex flex-col items-center justify-center text-slate-600">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm">
                                        @if ($product_photo)
                                            {{ $product_photo->getClientOriginalName() }}
                                        @else
                                            Klik untuk upload foto
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @error('product_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- KTP Pemilik UMKM -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                KTP Pemilik UMKM <span class="text-red-500">*</span>
                            </label>
                            <div
                                class="relative border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-sky-400 transition">
                                <input type="file" wire:model="ktp_photo" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="flex flex-col items-center justify-center text-slate-600">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm">
                                        @if ($ktp_photo)
                                            {{ $ktp_photo->getClientOriginalName() }}
                                        @else
                                            Klik untuk upload foto
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @error('ktp_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Izin Berusaha -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nomor Izin Berusaha <span class="text-sky-600 text-xs">*Jika Ada</span>
                            </label>
                            <input type="text" wire:model="business_license_number"
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
                            @error('business_license_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex gap-3">
                            <button type="button" wire:click="closeModal"
                                class="flex-1 px-6 py-3 border border-slate-300 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-sky-500 to-sky-600 text-white rounded-lg font-semibold hover:from-sky-600 hover:to-sky-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <span wire:loading.remove wire:target="submit">Konfirmasi</span>
                                <span wire:loading wire:target="submit">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading wire:target="brand_photo,product_photo,ktp_photo"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-6 w-6 text-sky-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-slate-700 font-medium">Mengupload file...</span>
            </div>
        </div>
    </div>
</div>

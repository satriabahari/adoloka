<div x-data x-on:keydown.escape.window="$wire.close()" class="relative z-[60]">
    @if ($this->open)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="close"></div>
    @endif

    {{-- Modal --}}
    <div x-cloak x-show="@js($this->open)" x-transition.opacity
        class="fixed inset-0 flex items-start md:items-center justify-center p-4 md:p-6">
        <div class="w-full max-w-md md:max-w-lg rounded-2xl bg-white shadow-2xl ring-1 ring-black/10 overflow-hidden">
            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-4">
                <button type="button" class="p-2 rounded-full hover:bg-slate-100" wire:click="close">
                    <x-bi-arrow-left-short class="w-6 h-6 text-slate-700" />
                </button>
                <p class="text-sm font-medium text-slate-500">form event</p>
                <div class="w-8"></div>
            </div>

            {{-- Body --}}
            <div class="px-6 pb-6">
                {{-- STEP 1 --}}
                @if ($step === 1)
                    <div class="space-y-5">
                        @foreach ([['label' => 'Nama Brand UMKM', 'model' => 'brand_name'], ['label' => 'Alamat Mitra', 'model' => 'mitra_address'], ['label' => 'Jenis', 'model' => 'type'], ['label' => 'Nama Pemilik', 'model' => 'owner_name'], ['label' => 'Nomor Whatsapp', 'model' => 'whatsapp'], ['label' => 'Nama Instagram', 'model' => 'instagram']] as $f)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">{{ $f['label'] }}</label>
                                <input type="text" wire:model.defer="{{ $f['model'] }}"
                                    class="w-full border-0 border-b border-dotted border-slate-300 focus:border-slate-400 focus:ring-0 rounded-none px-0"
                                    placeholder="">
                                @error($f['model'])
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        <button wire:click="next" type="button"
                            class="w-full h-10 rounded-md bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] text-white font-semibold">
                            Selanjutnya
                        </button>
                    </div>
                @endif

                {{-- STEP 2 --}}
                @if ($step === 2)
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Brand UMKM</label>
                            <div class="text-slate-800 font-semibold">{{ $brand_name }}</div>
                        </div>

                        {{-- Foto Produk --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Foto Produk</label>
                            <label
                                class="flex items-center justify-center w-full h-28 border rounded-md bg-white shadow-sm cursor-pointer">
                                <input class="hidden" type="file" accept="image/*" wire:model="product_photo">
                                <x-bi-image class="w-6 h-6 text-slate-500" />
                            </label>
                            @error('product_photo')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            @if ($product_photo)
                                <img class="mt-2 rounded-md ring-1 ring-slate-200"
                                    src="{{ $product_photo->temporaryUrl() }}">
                            @endif
                        </div>

                        {{-- KTP Pemilik --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">KTP Pemilik UMKM</label>
                            <label
                                class="flex items-center justify-center w-full h-28 border rounded-md bg-white shadow-sm cursor-pointer">
                                <input class="hidden" type="file" accept="image/*" wire:model="owner_ktp">
                                <x-bi-image class="w-6 h-6 text-slate-500" />
                            </label>
                            @error('owner_ktp')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            @if ($owner_ktp)
                                <img class="mt-2 rounded-md ring-1 ring-slate-200"
                                    src="{{ $owner_ktp->temporaryUrl() }}">
                            @endif
                        </div>

                        {{-- Nomor Izin Usaha (opsional) --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Nomor Izin Berusaha
                                <span class="text-slate-400">*</span>
                                <a class="text-primary-600 underline">Jika Ada</a>
                            </label>
                            <input type="text" wire:model.defer="business_permit_no"
                                class="w-full border-0 border-b border-dotted border-slate-300 focus:border-slate-400 focus:ring-0 rounded-none px-0"
                                placeholder="">
                            @error('business_permit_no')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="button" wire:click="back"
                                class="flex-1 h-10 rounded-md ring-1 ring-slate-300 text-slate-700 font-medium">
                                Kembali
                            </button>
                            <button wire:click="submit" type="button"
                                class="flex-1 h-10 rounded-md bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] text-white font-semibold">
                                Konfirmasi
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

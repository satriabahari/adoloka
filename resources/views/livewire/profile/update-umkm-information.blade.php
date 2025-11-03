<div class="w-full">
    @if (session()->has('message'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-100 text-emerald-700 text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- KARTU: Info UMKM -->
    <div
        class="rounded-2xl bg-white/95 backdrop-blur ring-1 ring-gray-200 shadow-[0_16px_40px_rgba(17,65,119,0.15)] overflow-hidden">
        <div class="bg-gradient-to-r from-sky-500 to-sky-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">UMKM</h2>
                        <p class="text-sm text-sky-200">Transaksi pembelian Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div
                class="rounded-xl bg-gradient-to-br from-white to-slate-50 border border-slate-200 shadow-sm p-4 md:p-5">
                <div class="space-y-5">
                    {{-- Nama UMKM --}}
                    <div>
                        <p class="text-sm text-gray-500">Nama UMKM</p>
                        <div class="mt-1.5 flex items-center gap-3">
                            @if (!$editing['nama_umkm'])
                                <span class="flex-1 text-gray-800 font-medium">{{ $nama_umkm ?? '-' }}</span>
                                <button wire:click="toggle('nama_umkm')"
                                    class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                    Edit
                                </button>
                            @else
                                <input type="text" wire:model.live="nama_umkm"
                                    class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                                <button wire:click="save('nama_umkm')"
                                    class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                    Save
                                </button>
                            @endif
                        </div>
                        @error('nama_umkm')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori UMKM --}}
                    <div>
                        <p class="text-sm text-gray-500">Kategori UMKM</p>
                        <div class="mt-1.5 flex items-center gap-3">
                            @if (!$editing['kategori'])
                                <span class="flex-1 text-gray-800 font-medium">{{ $kategori_nama ?? '-' }}</span>
                                <button wire:click="toggle('kategori')"
                                    class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                    Edit
                                </button>
                            @else
                                <select wire:model.live="category_id"
                                    class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($categoryOptions as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <button wire:click="save('kategori')"
                                    class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                    Save
                                </button>
                            @endif
                        </div>
                        @error('category_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Asal Produk --}}
                    <div>
                        <p class="text-sm text-gray-500">Asal Produk</p>
                        <div class="mt-1.5 flex items-center gap-3">
                            @if (!$editing['asal_produk'])
                                <span class="flex-1 text-gray-800 font-medium">{{ $asal_produk }}</span>
                            @else
                                <input type="text" wire:model.live="asal_produk"
                                    class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                            @endif

                            @if (!$editing['asal_produk'])
                                <button wire:click="toggle('asal_produk')"
                                    class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                                    Edit
                                </button>
                            @else
                                <button wire:click="save('asal_produk')"
                                    class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                    Save
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- KARTU: Deskripsi UMKM -->
            <div
                class="mt-4 rounded-xl bg-gradient-to-br from-white to-slate-50 border border-slate-200 shadow-sm p-4 md:p-5">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-gray-900">Deskripsi UMKM</h3>

                    @if (!$editing['deskripsi'])
                        <button wire:click="toggle('deskripsi')"
                            class="px-4 py-1.5 text-xs rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm">
                            Edit
                        </button>
                    @else
                        <button wire:click="save('deskripsi')"
                            class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                            Save
                        </button>
                    @endif
                </div>

                @if (!$editing['deskripsi'])
                    <p class="text-sm leading-6 text-gray-600">
                        {{ $deskripsi ?? 'Belum ada deskripsi' }}
                    </p>
                @else
                    <textarea rows="4" wire:model.live="deskripsi"
                        class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500"></textarea>
                @endif
            </div>

            <!-- KARTU: Status Produk -->
            <div class="mt-4 rounded-xl ring-1 ring-gray-200 bg-white shadow-sm">
                <div class="p-5 md:p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Status Produk</h4>

                    <div class="space-y-4">
                        <!-- Halal Status -->
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 mb-2">Halal Status</p>
                                <input type="file" wire:model="halal_certificate" id="halal-upload" class="hidden"
                                    accept="image/*">
                                <label for="halal-upload"
                                    class="cursor-pointer inline-flex items-center text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                                    Upload
                                </label>
                                @if ($halal_certificate)
                                    <button wire:click="uploadCertificate('halal')"
                                        class="ml-2 text-xs px-3 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                        Simpan
                                    </button>
                                @endif
                                @error('halal_certificate')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($umkm && $umkm->halal_verified)
                                    <span
                                        class="inline-flex items-center text-xs font-medium px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                                        Verified
                                    </span>
                                @endif
                                @if ($umkm && $umkm->getFirstMediaUrl('halal_certificate'))
                                    <button wire:click="viewCertificate('halal')" type="button"
                                        class="text-xs px-3 py-1 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                                        View
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- BPOM Details -->
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 mb-2">BPOM Details</p>
                                <input type="file" wire:model="bpom_certificate" id="bpom-upload" class="hidden"
                                    accept="image/*">
                                <label for="bpom-upload"
                                    class="cursor-pointer inline-flex items-center text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                                    Upload
                                </label>
                                @if ($bpom_certificate)
                                    <button wire:click="uploadCertificate('bpom')"
                                        class="ml-2 text-xs px-3 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                        Simpan
                                    </button>
                                @endif
                                @error('bpom_certificate')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($umkm && $umkm->bpom_verified)
                                    <span
                                        class="inline-flex items-center text-xs font-medium px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                                        Verified
                                    </span>
                                @endif
                                @if ($umkm && $umkm->getFirstMediaUrl('bpom_certificate'))
                                    <button wire:click="viewCertificate('bpom')" type="button"
                                        class="text-xs px-3 py-1 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                                        View
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- NIB -->
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm text-gray-700 mb-2">NIB</p>
                                <input type="file" wire:model="nib_certificate" id="nib-upload" class="hidden"
                                    accept="image/*">
                                <label for="nib-upload"
                                    class="cursor-pointer inline-flex items-center text-xs px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                                    Upload
                                </label>
                                @if ($nib_certificate)
                                    <button wire:click="uploadCertificate('nib')"
                                        class="ml-2 text-xs px-3 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                                        Simpan
                                    </button>
                                @endif
                                @error('nib_certificate')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($umkm && $umkm->nib_verified)
                                    <span
                                        class="inline-flex items-center text-xs font-medium px-3 py-1 rounded-full bg-emerald-100 text-emerald-700">
                                        Verified
                                    </span>
                                @endif
                                @if ($umkm && $umkm->getFirstMediaUrl('nib_certificate'))
                                    <button wire:click="viewCertificate('nib')" type="button"
                                        class="text-xs px-3 py-1 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                                        View
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Image -->
    @if ($showImageModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
            wire:click="closeModal">
            <div class="relative max-w-3xl p-4" wire:click.stop>
                <button wire:click="closeModal"
                    class="absolute top-6 right-6 px-2 text-white hover:text-gray-300 text-2xl bg-primary hover:bg-primary-hover rounded-full duration-200 transition">
                    ×
                </button>
                <img src="{{ $viewImage }}" alt="Certificate" class="max-w-full max-h-[70vh] rounded-lg">
            </div>
        </div>
    @endif
</div>

<div
    class="mx-auto max-w-xl h-fit rounded-2xl bg-white/95 backdrop-blur shadow-[0_20px_60px_rgba(17,65,119,0.20)] ring-1 ring-gray-200 p-6 md:p-8">

    <!-- HEADER: Avatar + Tombol Upload -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <div class="h-24 w-24 rounded-full ring-4 ring-white shadow-md overflow-hidden">
                <img src="{{ asset('/images/avatar-profile.png') }}" alt="Avatar" class="h-full w-full object-cover">
            </div>
        </div>

        <button type="button"
            class="px-5 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm transition">
            Upload Photo
        </button>
    </div>

    <!-- KARTU: Data Utama -->
    <div class="rounded-xl ring-1 ring-gray-200 bg-white shadow-sm mb-6">
        <div class="p-5 md:p-6 space-y-5">

            {{-- Your Name --}}
            <div>
                <p class="text-sm text-gray-500 mb-1">Your Name</p>

                <div class="flex items-center gap-3">
                    @if (!$editing['name'])
                        <input disabled type="text" value="{{ $name }}"
                            class="flex-1 bg-transparent border-none focus:ring-0 text-gray-800 font-medium">
                    @else
                        <input type="text" wire:model.live="name"
                            class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                    @endif

                    @if (!$editing['name'])
                        <button wire:click="toggle('name')"
                            class="text-xs px-4 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                            Edit
                        </button>
                    @else
                        <button wire:click="save('name')"
                            class="text-xs px-4 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                            Save
                        </button>
                    @endif
                </div>
            </div>

            {{-- Email --}}
            <div>
                <p class="text-sm text-gray-500 mb-1">Email</p>

                <div class="flex items-center gap-3">
                    @if (!$editing['email'])
                        <input disabled type="text" value="{{ $email }}"
                            class="flex-1 bg-transparent border-none focus:ring-0 text-gray-800 font-medium">
                    @else
                        <input type="email" wire:model.live="email"
                            class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                    @endif

                    @if (!$editing['email'])
                        <button wire:click="toggle('email')"
                            class="text-xs px-4 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                            Edit
                        </button>
                    @else
                        <button wire:click="save('email')"
                            class="text-xs px-4 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                            Save
                        </button>
                    @endif
                </div>
            </div>

            {{-- Nomor Handphone --}}
            <div>
                <p class="text-sm text-gray-500 mb-1">Nomor Handphone</p>

                <div class="flex items-center gap-3">
                    @if (!$editing['phone'])
                        <input disabled type="text" value="{{ $phone }}"
                            class="flex-1 bg-transparent border-none focus:ring-0 text-gray-800 font-medium">
                    @else
                        <input type="text" wire:model.live="phone"
                            class="flex-1 rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500">
                    @endif

                    @if (!$editing['phone'])
                        <button wire:click="toggle('phone')"
                            class="text-xs px-4 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                            Edit
                        </button>
                    @else
                        <button wire:click="save('phone')"
                            class="text-xs px-4 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                            Save
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- KARTU: About -->
    <div class="rounded-xl ring-1 ring-gray-200 bg-white shadow-sm mb-6">
        <div class="p-5 md:p-6">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-lg font-semibold text-gray-900">
                    About <span class="text-sky-700">Sid</span>
                </h4>

                @if (!$editing['about'])
                    <button wire:click="toggle('about')"
                        class="text-xs px-4 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                        Edit
                    </button>
                @else
                    <button wire:click="save('about')"
                        class="text-xs px-4 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                        Save
                    </button>
                @endif
            </div>

            @if (!$editing['about'])
                <p class="text-sm leading-6 text-gray-600">
                    {{ $about }}
                </p>
            @else
                <textarea rows="4" wire:model.live="about"
                    class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500"></textarea>
            @endif
        </div>
    </div>

    <!-- KARTU: Status Produk -->
    

</div>

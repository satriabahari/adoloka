<div
    class="mx-auto  w-full h-fit rounded-2xl bg-white/95 backdrop-blur shadow-[0_20px_60px_rgba(17,65,119,0.20)] ring-1 ring-gray-200 p-6 md:p-8">

    @if (session()->has('message'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-100 text-emerald-700 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- HEADER: Avatar + Tombol Upload -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="h-24 w-24 rounded-full ring-4 ring-white shadow-md overflow-hidden">
                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="h-full w-full object-cover">
            </div>
        </div>

        <div>
            <input type="file" wire:model="avatar" id="avatar-upload" class="hidden" accept="image/*">
            <label for="avatar-upload"
                class="cursor-pointer px-5 py-2 text-sm font-medium rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 shadow-sm transition">
                Upload Photo
            </label>
        </div>
    </div>

    @if ($avatar && is_object($avatar))
        <div class="mb-4 flex items-center gap-2">
            <span class="text-sm text-gray-600">File dipilih: {{ $avatar->getClientOriginalName() }}</span>
            <button wire:click="uploadAvatar"
                class="px-4 py-1.5 text-xs rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                Simpan Avatar
            </button>
        </div>
    @endif

    @error('avatar')
        <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
    @enderror

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
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
                @error('phone')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <p class="text-sm text-gray-500 mb-1">Password</p>

                @if (!$editing['password'])
                    <div class="flex items-center gap-3">
                        <input disabled type="password" value="••••••••"
                            class="flex-1 bg-transparent border-none focus:ring-0 text-gray-800 font-medium">
                        <button wire:click="toggle('password')"
                            class="text-xs px-4 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700">
                            Edit
                        </button>
                    </div>
                @else
                    <div class="space-y-3">
                        <div class="relative">
                            <input type="{{ $show_current_password ? 'text' : 'password' }}"
                                wire:model="current_password" placeholder="Password saat ini"
                                class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500 pr-10">
                            <button type="button" wire:click="$toggle('show_current_password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($show_current_password)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    @endif
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="relative">
                            <input type="{{ $show_password ? 'text' : 'password' }}" wire:model="password"
                                placeholder="Password baru"
                                class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500 pr-10">
                            <button type="button" wire:click="$toggle('show_password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($show_password)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    @endif
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="relative">
                            <input type="{{ $show_password_confirmation ? 'text' : 'password' }}"
                                wire:model="password_confirmation" placeholder="Konfirmasi password baru"
                                class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500 pr-10">
                            <button type="button" wire:click="$toggle('show_password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if ($show_password_confirmation)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    @endif
                                </svg>
                            </button>
                        </div>

                        <button wire:click="save('password')"
                            class="text-xs px-4 py-1.5 rounded-full bg-sky-600 hover:bg-sky-700 text-white">
                            Save Password
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- KARTU: About -->
    <div class="rounded-xl ring-1 ring-gray-200 bg-white shadow-sm mb-6">
        <div class="p-5 md:p-6">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-lg font-semibold text-gray-900">
                    About <span class="text-sky-700">{{ explode(' ', $name)[0] }}</span>
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
                    {{ $about ?? 'Belum ada deskripsi' }}
                </p>
            @else
                <textarea rows="4" wire:model.live="about"
                    class="w-full rounded-lg border-gray-300 focus:ring-sky-500 focus:border-sky-500"></textarea>
            @endif
        </div>
    </div>

</div>

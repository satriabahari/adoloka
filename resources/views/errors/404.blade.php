<x-app-layout>
    <div class="min-h-screen flex items-center justify-center pt-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100  rounded-3xl shadow-xl overflow-hidden">
                <div class="flex flex-col gap-8 p-8 md:p-12">
                    <!-- Ilustrasi SVG -->
                    <div class="flex items-center justify-center">
                        <div class="w-full max-w-md">
                            <img src="{{ asset('images/errors/404.svg') }}" alt="404 Illustration" class="w-full h-auto">
                        </div>
                    </div>

                    <!-- Konten -->
                    <div class="flex flex-col justify-center items-center space-y-6">
                        <div class="text-center flex flex-col justify-center items-center">
                            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-2">404</h1>
                            <h2 class="text-2xl md:text-3xl font-semibold text-primary-600 mb-4">Halaman Tidak Ditemukan
                            </h2>
                            <p class="text-gray-600 text-lg leading-relaxed w-1/2">
                                Maaf, halaman yang Anda cari tidak dapat ditemukan. Halaman mungkin telah dipindahkan
                                atau tidak pernah ada.
                            </p>
                        </div>

                        <!-- Tombol Aksi -->
                        <a href="{{ url('/') }}"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-primary-600 text-white font-semibold hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="min-h-screen flex items-center justify-center pt-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            <div class="bg-gradient-to-br from-sky-50 to-sky-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="flex flex-col gap-8 p-8 md:p-12">
                    <!-- Ilustrasi SVG -->
                    <div class="flex items-center justify-center">
                        <div class="w-full max-w-md">
                            <img src="{{ asset('images/errors/403.svg') }}" alt="403 Illustration" class="w-full h-auto">
                        </div>
                    </div>

                    <!-- Konten -->
                    <div class="flex flex-col justify-center items-center space-y-6">
                        <div class="text-center flex flex-col justify-center items-center">
                            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-2">403</h1>
                            <h2 class="text-2xl md:text-3xl font-semibold text-sky-600 mb-4">
                                Akses Ditolak
                            </h2>
                            <p class="text-gray-600 text-lg leading-relaxed w-full md:w-2/3">
                                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi
                                administrator jika Anda merasa ini adalah kesalahan.
                            </p>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ url('/') }}"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Kembali ke Beranda
                            </a>

                            <button onclick="window.history.back()"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-white text-sky-600 font-semibold border-2 border-sky-600 hover:bg-sky-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18">
                                    </path>
                                </svg>
                                Halaman Sebelumnya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

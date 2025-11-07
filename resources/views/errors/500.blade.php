<x-app-layout>
    <div class="min-h-screen flex items-center justify-center pt-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-3xl shadow-xl overflow-hidden">
                <div class="flex flex-col gap-8 p-8 md:p-12">
                    <!-- Ilustrasi SVG -->
                    <div class="flex items-center justify-center">
                        <div class="w-full max-w-md">
                            <img src="{{ asset('images/errors/500.webp') }}" alt="500 Illustration" class="w-full h-auto">
                        </div>
                    </div>

                    <!-- Konten -->
                    <div class="flex flex-col justify-center space-y-6">
                        <div class="text-center flex flex-col justify-center items-center">
                            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-2">500</h1>
                            <h2 class="text-2xl md:text-3xl font-semibold text-primary-600 mb-4">Terjadi Kesalahan
                                Server
                            </h2>
                            <p class="text-gray-600 text-lg leading-relaxed w-1/2">
                                Maaf, terjadi kesalahan pada server kami. Tim teknis kami telah diberitahu dan sedang
                                menangani masalah ini. Silakan coba lagi dalam beberapa saat.
                            </p>
                        </div>

                        <!-- Status Info -->
                        <div class="bg-primary-50 rounded-xl p-4 border border-primary-200">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-primary-800">
                                    <p class="font-semibold mb-1">Apa yang bisa Anda lakukan?</p>
                                    <ul class="space-y-1 text-primary-700">
                                        <li>• Muat ulang halaman ini</li>
                                        <li>• Coba lagi dalam beberapa menit</li>
                                        <li>• Kembali ke halaman sebelumnya</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button onclick="location.reload()"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-primary-600 text-white font-semibold hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Muat Ulang
                            </button>
                            <a href="{{ url('/') }}"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Kembali ke Beranda
                            </a>
                            <button onclick="window.history.back()"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
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

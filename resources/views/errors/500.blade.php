<x-app-layout>
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-sky-50 to-white text-center">
        <h1 class="text-6xl font-bold text-sky-600 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Oops! Halaman tidak ditemukan</h2>
        <p class="text-gray-500 mb-6">Sepertinya halaman yang kamu cari tidak tersedia atau sudah dipindahkan.</p>
        <a href="{{ url('/') }}"
            class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition">
            Kembali ke Beranda
        </a>
    </div>
</x-app-layout>

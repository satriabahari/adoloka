<div class="relative bg-white overflow-hidden">
    <!-- Gambar background -->
    <img src="/images/home/hero.jpg" alt="Background" class="w-full h-screen object-cover block select-none bg-white"
        style="box-shadow: none; border: none;">

    <div class="absolute inset-0 bg-gradient-to-b from-sky-900/50 via-sky-800/40 to-sky-900/60"></div>

    <!-- Overlay konten -->
    <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 animate-fade-in-down">
            Hadir mempromosikan usahamu
        </h1>
        <p class="text-lg md:text-xl text-gray-100 mb-8 max-w-2xl animate-fade-in-up animation-delay-200">
            Membantu bisnismu dikenal lebih luas lewat kehadiran langsung di event yang tepat sasaran
        </p>
        <button
            class="bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary-hover text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 animate-fade-in animation-delay-400">
            Produk UMKM
        </button>
    </div>
</div>

<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
        opacity: 0;
        animation-fill-mode: forwards;
    }
</style>

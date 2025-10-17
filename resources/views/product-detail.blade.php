<x-app-layout>
    @php
        $image = $product->getFirstMediaUrl('product_image') ?: $product->image_url;
    @endphp

    {{-- HERO HEADER --}}
    <section class="relative h-[200px] md:h-[260px] overflow-hidden">
        <img src="{{ asset('images/products/heading.png') }}" alt="Header"
            class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/50"></div>

        <div class="relative container mx-auto h-full flex items-center justify-between px-4">
            <a href="{{ route('events') }}"
                class="inline-flex items-center gap-2 px-4 py-1 rounded-md bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A] text-white">
                <x-bi-arrow-left-short />
                <p>Back</p>
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow">Menu Produk UMKM</h1>
        </div>
    </section>

    {{-- PRODUCT DETAIL --}}
    <section class="max-w-6xl mx-auto px-4 py-10 md:py-12">
        <div class="grid md:grid-cols-2 gap-10">
            {{-- LEFT IMAGE --}}
            <div>
                <img src="{{ $image }}" alt="{{ $product->name }}"
                    class="rounded-xl w-full object-cover shadow-md ring-1 ring-gray-200">
            </div>

            {{-- RIGHT DETAILS --}}
            <div>
                {{-- Title --}}
                <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $product->name }}</h1>

                {{-- Description (dipindah ke bawah title) --}}
                <p class="text-slate-600 leading-relaxed mb-4">
                    {{ $product->description }}
                </p>

                {{-- Price --}}
                <p class="text-sky-700 text-2xl font-semibold mb-4">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </p>

                {{-- Availability --}}
                <p class="text-sm text-green-600 font-medium mb-1">
                    Ketersediaan: {{ $product->stock > 0 ? 'Ada' : 'Habis' }}
                </p>
                <p class="text-sm text-slate-600">Category: {{ $product->category->name ?? '-' }}</p>
                <p class="text-sm text-slate-600 mb-6">Asal Produk: Desa Mekar Jaya</p>

                {{-- Quantity + Buttons --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button id="decrease-qty"
                            class="px-3 py-2 text-gray-700 font-bold hover:bg-gray-100 transition">−</button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="w-10 text-center border-x border-gray-300 text-gray-800 font-semibold">
                        <button id="increase-qty"
                            class="px-3 py-2 text-gray-700 font-bold hover:bg-gray-100 transition">+</button>
                    </div>

                    <button id="buy-now-btn"
                        class="bg-blue-800 hover:bg-blue-900 text-white font-semibold px-6 py-2.5 rounded-lg shadow transition disabled:opacity-50 disabled:cursor-not-allowed">
                        BELI SEKARANG
                    </button>
                </div>

                {{-- Alert Messages --}}
                <div id="alert-container"></div>
            </div>
        </div>
    </section>

    {{-- Midtrans Snap Script --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        // Quantity controls
        const qtyInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-qty');
        const increaseBtn = document.getElementById('increase-qty');
        const buyNowBtn = document.getElementById('buy-now-btn');
        const alertContainer = document.getElementById('alert-container');

        decreaseBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            if (value > 1) qtyInput.value = value - 1;
        });

        increaseBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            let max = parseInt(qtyInput.max);
            if (value < max) qtyInput.value = value + 1;
        });

        // Buy Now - Midtrans Integration
        buyNowBtn.addEventListener('click', async () => {
            const quantity = parseInt(qtyInput.value);

            if (quantity < 1) return showAlert('Jumlah minimal 1', 'error');
            if (quantity > {{ $product->stock }}) return showAlert('Stok tidak mencukupi', 'error');

            buyNowBtn.disabled = true;
            buyNowBtn.textContent = 'Memproses...';

            try {
                const response = await fetch('{{ route('order.create', $product) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: () => window.location.href =
                            '{{ route('order.success') }}?order_id=' + data.order_id,
                        onPending: () => window.location.href =
                            '{{ route('order.pending') }}?order_id=' + data.order_id,
                        onError: () => window.location.href = '{{ route('order.failed') }}?order_id=' +
                            data.order_id,
                        onClose: () => {
                            showAlert('Pembayaran dibatalkan', 'warning');
                            buyNowBtn.disabled = false;
                            buyNowBtn.textContent = 'BELI SEKARANG';
                        }
                    });
                } else {
                    showAlert(data.message, 'error');
                    buyNowBtn.disabled = false;
                    buyNowBtn.textContent = 'BELI SEKARANG';
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan, silakan coba lagi', 'error');
                buyNowBtn.disabled = false;
                buyNowBtn.textContent = 'BELI SEKARANG';
            }
        });

        function showAlert(message, type) {
            const alertClass = type === 'error' ? 'bg-red-100 text-red-700' :
                type === 'warning' ? 'bg-yellow-100 text-yellow-700' :
                'bg-green-100 text-green-700';

            alertContainer.innerHTML = `
                <div class="${alertClass} px-4 py-3 rounded-lg mb-4">
                    ${message}
                </div>
            `;
            setTimeout(() => alertContainer.innerHTML = '', 5000);
        }
    </script>
</x-app-layout>

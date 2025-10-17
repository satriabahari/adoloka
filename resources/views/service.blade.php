<x-app-layout>
    <div class="container mx-auto px-4 pt-24">
        <div class="flex gap-12">
            <x-service-detail-card image="/images/services/service.png" category="Brand Identity" duration="3–5 Hari"
                title="Desain Logo Profesional" :desc="'Bangun identitas brand Anda dengan logo profesional. Kami menghadirkan desain logo modern, mudah diingat, dan fleksibel untuk mendukung berbagai kebutuhan bisnis Anda.'" />


            <x-price-service-card title="Harga paket" price="Rp. 50.000 - Rp 100.000" delivery="3–5 hari"
                revision="1–3 kali" />
        </div>

        <x-overview-service-card />
    </div>
</x-app-layout>

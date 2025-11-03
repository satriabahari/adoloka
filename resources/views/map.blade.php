<x-app-layout>
    <div class="max-w-5xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-4">Lokasi dengan Leaflet.js</h1>

        <div id="map" style="height: 400px; border-radius: 10px;"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Koordinat lokasi (misal: Jambi)
            var lat = -1.6101;
            var lng = 103.6131;

            // Inisialisasi peta
            var map = L.map('map').setView([lat, lng], 13);

            // Tambahkan tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Buat marker
            var marker = L.marker([lat, lng]).addTo(map);

            // Tambahkan popup
            marker.bindPopup('<b>Halo!</b><br>Klik marker untuk buka Google Maps.');

            // Ketika marker diklik → buka Google Maps
            marker.on('click', function() {
                var googleMapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
                window.open(googleMapsUrl, '_blank');
            });
        });
    </script>
</x-app-layout>

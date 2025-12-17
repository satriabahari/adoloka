<div>
    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign up</h2>
    <p class="text-gray-600 mb-8">Registrasi akun untuk UMKM (Informasi Jenis Usaha)</p>

    <form wire:submit.prevent="nextStep" class="space-y-5">
        <!-- Business Name & Type -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Usaha</label>
                <input type="text" wire:model.defer="business_name" placeholder="Terpopak-makyus"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                @error('business_name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Usaha</label>
                <select wire:key="umkm-category-select" wire:model.defer="umkm_category_id"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition bg-white">
                    <option value="" hidden>Pilih kategori</option>
                    @foreach ($umkmCategories as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
                @error('umkm_category_id')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- City with Autocomplete -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Daerah/Kota Usaha</label>
            <div class="relative">
                <input type="text" id="city-autocomplete" wire:model.defer="city"
                    placeholder="Ketik untuk mencari kota..." autocomplete="off"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition">
                <div id="city-suggestions"
                    class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    <!-- Suggestions will be populated here -->
                </div>
            </div>
            @error('city')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Location Map & Description -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Leaflet Map with Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Usaha</label>

                <!-- Address Search Bar -->
                <div class="relative mb-3">
                    <input type="text" id="address-search" placeholder="Cari alamat..." autocomplete="off"
                        class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition text-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <div id="address-suggestions"
                        class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                        <!-- Address suggestions will be populated here -->
                    </div>
                </div>

                <!-- Map Container -->
                <div id="umkm-map" wire:ignore
                    class="w-full h-52 border-2 border-gray-300 rounded-lg bg-gray-50 relative overflow-hidden shadow-sm">
                </div>

                <input type="hidden" wire:model="latitude">
                <input type="hidden" wire:model="longitude">
                <input type="hidden" wire:model="address" id="hidden-address">

                @if ($latitude && $longitude)
                    <div class="mt-2 p-2 bg-green-50 rounded-lg">
                        <p class="text-xs text-green-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Lokasi tersimpan:</span>
                        </p>
                        <p class="text-xs text-gray-600 mt-0.5 font-mono pl-5">
                            {{ number_format($latitude, 6) }}, {{ number_format($longitude, 6) }}
                        </p>
                        <p class="text-xs text-gray-700 mt-1 pl-5" id="selected-address">
                            @if ($address)
                                {{ $address }}
                            @else
                                <span class="text-gray-400 italic">Memuat alamat...</span>
                            @endif
                        </p>
                    </div>
                @endif

                @error('latitude')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
                @error('address')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Usaha</label>
                <textarea wire:model.defer="business_description" rows="10" placeholder="Ceritakan tentang usaha Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none resize-none transition"></textarea>
                @error('business_description')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-3 pt-4">
            <button type="button" wire:click="previousStep"
                class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md">
                Kembali
            </button>
            <button type="submit"
                class="flex-1 bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3.5 rounded-lg transition duration-200 shadow-sm hover:shadow-md">
                Selanjutnya
            </button>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 pt-2">
            Already have an account? <a href="/login"
                class="text-primary-500 hover:text-primary-600 font-medium">Login</a>
        </p>
    </form>
</div>

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        let umkmMap;
        let umkmMarker;
        let mapInitialized = false;
        let searchTimeout;
        let addressSearchTimeout;
        const GEOAPIFY_API_KEY = '{{ env('GEOAPIFY_API_KEY', '') }}';

        function initUmkmMap() {
            const mapContainer = document.getElementById('umkm-map');
            if (!mapContainer) {
                console.error('Map container not found');
                return;
            }

            // Clear any existing map instance
            if (umkmMap) {
                try {
                    umkmMap.remove();
                } catch (e) {
                    console.log('Error removing map:', e);
                }
                umkmMap = null;
                umkmMarker = null;
            }

            // Reset the container innerHTML to ensure clean state
            mapContainer.innerHTML = '';
            mapInitialized = false;

            const defaultLat = {{ $latitude ?? '-1.6101' }};
            const defaultLng = {{ $longitude ?? '103.6131' }};

            try {
                // Wait for container to be ready
                setTimeout(() => {
                    umkmMap = L.map('umkm-map', {
                        center: [defaultLat, defaultLng],
                        zoom: 13,
                        zoomControl: true,
                        scrollWheelZoom: true,
                        preferCanvas: false
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                        maxZoom: 19
                    }).addTo(umkmMap);

                    mapInitialized = true;

                    // Force map to render properly - multiple times to ensure it works
                    setTimeout(() => {
                        if (umkmMap) {
                            umkmMap.invalidateSize();
                        }
                    }, 100);

                    setTimeout(() => {
                        if (umkmMap) {
                            umkmMap.invalidateSize();
                        }
                    }, 500);

                    setTimeout(() => {
                        if (umkmMap) {
                            umkmMap.invalidateSize();
                        }
                    }, 1000);

                    // Add click handler
                    umkmMap.on('click', function(e) {
                        placeUmkmMarker(e.latlng);
                    });

                    // Jika sudah ada koordinat, tampilkan marker
                    if (defaultLat && defaultLng && (defaultLat !== -1.6101 || defaultLng !== 103.6131)) {
                        placeUmkmMarker(L.latLng(defaultLat, defaultLng));
                    } else if (navigator.geolocation) {
                        // Gunakan lokasi user
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const userLocation = L.latLng(position.coords.latitude, position.coords
                                    .longitude);
                                if (umkmMap) {
                                    umkmMap.setView(userLocation, 15);
                                    placeUmkmMarker(userLocation);
                                }
                            },
                            (error) => {
                                console.log('Geolocation failed:', error);
                            }
                        );
                    }
                }, 100);
            } catch (error) {
                console.error('Error initializing map:', error);
                mapInitialized = false;
            }
        }

        function placeUmkmMarker(latlng) {
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `
                <div style="position: relative;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                              fill="#0ea5e9" stroke="#fff" stroke-width="2"/>
                        <circle cx="12" cy="9" r="2.5" fill="#fff"/>
                    </svg>
                </div>
            `,
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            if (umkmMarker) {
                umkmMarker.setLatLng(latlng);
            } else {
                umkmMarker = L.marker(latlng, {
                    icon: customIcon,
                    draggable: true,
                    title: "Lokasi Usaha Anda"
                }).addTo(umkmMap);

                umkmMarker.on('dragend', function() {
                    updateUmkmLocation(umkmMarker.getLatLng());
                });
            }

            updateUmkmLocation(latlng);
        }

        function updateUmkmLocation(latlng) {
            const lat = latlng.lat.toFixed(8);
            const lng = latlng.lng.toFixed(8);

            // Update Livewire properties
            @this.set('latitude', lat);
            @this.set('longitude', lng);

            // Fetch address using Geoapify Reverse Geocoding
            if (GEOAPIFY_API_KEY) {
                const addressElement = document.getElementById('selected-address');
                if (addressElement) {
                    addressElement.innerHTML = '<span class="text-gray-400 italic">Mengambil alamat...</span>';
                }

                fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${lat}&lon=${lng}&apiKey=${GEOAPIFY_API_KEY}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        let address = 'Alamat tidak tersedia';

                        if (data.features && data.features.length > 0) {
                            const props = data.features[0].properties;

                            // Prioritaskan format alamat lengkap
                            if (props.formatted) {
                                address = props.formatted;
                            } else if (props.address_line1) {
                                address = props.address_line1;
                                if (props.address_line2) {
                                    address += ', ' + props.address_line2;
                                }
                            } else {
                                // Bangun alamat dari komponen
                                const parts = [];
                                if (props.street) parts.push(props.street);
                                if (props.suburb) parts.push(props.suburb);
                                if (props.city) parts.push(props.city);
                                if (props.state) parts.push(props.state);
                                if (props.country) parts.push(props.country);

                                address = parts.length > 0 ? parts.join(', ') : 'Alamat tidak tersedia';
                            }

                            // Update address display
                            if (addressElement) {
                                addressElement.innerHTML = `<span class="text-gray-700">${address}</span>`;
                            }

                            // Update Livewire address property
                            @this.set('address', address);

                            // Update hidden input untuk fallback
                            const hiddenAddressInput = document.getElementById('hidden-address');
                            if (hiddenAddressInput) {
                                hiddenAddressInput.value = address;
                            }

                            console.log('Address updated:', address);
                        } else {
                            if (addressElement) {
                                addressElement.innerHTML =
                                    '<span class="text-gray-500 italic">Alamat tidak ditemukan</span>';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching address:', error);
                        const addressElement = document.getElementById('selected-address');
                        if (addressElement) {
                            addressElement.innerHTML =
                                '<span class="text-red-500 italic">Gagal mengambil alamat</span>';
                        }
                    });
            } else {
                console.warn('Geoapify API key not configured');
            }
        }

        // City Autocomplete
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - Initializing map...');

            // Initialize map with longer delay to ensure DOM is ready
            setTimeout(() => {
                initUmkmMap();
            }, 300);

            const cityInput = document.getElementById('city-autocomplete');
            const citySuggestions = document.getElementById('city-suggestions');

            if (cityInput && GEOAPIFY_API_KEY) {
                cityInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();

                    if (query.length < 3) {
                        citySuggestions.classList.add('hidden');
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        fetch(
                                `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&type=city&filter=countrycode:id&apiKey=${GEOAPIFY_API_KEY}`
                            )
                            .then(response => response.json())
                            .then(data => {
                                citySuggestions.innerHTML = '';

                                if (data.features && data.features.length > 0) {
                                    data.features.forEach(feature => {
                                        const city = feature.properties.city || feature
                                            .properties.name;
                                        const state = feature.properties.state || '';
                                        const country = feature.properties.country ||
                                            '';

                                        const div = document.createElement('div');
                                        div.className =
                                            'px-4 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-0';
                                        div.innerHTML = `
                                            <div class="font-medium text-gray-900">${city}</div>
                                            <div class="text-xs text-gray-500">${state}${state && country ? ', ' : ''}${country}</div>
                                        `;

                                        div.addEventListener('click', function() {
                                            cityInput.value = city;
                                            @this.set('city', city);
                                            citySuggestions.classList.add(
                                                'hidden');
                                        });

                                        citySuggestions.appendChild(div);
                                    });

                                    citySuggestions.classList.remove('hidden');
                                } else {
                                    citySuggestions.classList.add('hidden');
                                }
                            })
                            .catch(error => console.error('Error fetching cities:', error));
                    }, 300);
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!cityInput.contains(e.target) && !citySuggestions.contains(e.target)) {
                        citySuggestions.classList.add('hidden');
                    }
                });
            }

            // Address Search Autocomplete
            const addressInput = document.getElementById('address-search');
            const addressSuggestions = document.getElementById('address-suggestions');

            if (addressInput && GEOAPIFY_API_KEY) {
                addressInput.addEventListener('input', function() {
                    clearTimeout(addressSearchTimeout);
                    const query = this.value.trim();

                    if (query.length < 3) {
                        addressSuggestions.classList.add('hidden');
                        return;
                    }

                    addressSearchTimeout = setTimeout(() => {
                        fetch(
                                `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(query)}&filter=countrycode:id&apiKey=${GEOAPIFY_API_KEY}`
                            )
                            .then(response => response.json())
                            .then(data => {
                                addressSuggestions.innerHTML = '';

                                if (data.features && data.features.length > 0) {
                                    data.features.forEach(feature => {
                                        const address = feature.properties.formatted ||
                                            feature.properties.address_line1;
                                        const lat = feature.properties.lat;
                                        const lon = feature.properties.lon;

                                        const div = document.createElement('div');
                                        div.className =
                                            'px-4 py-2.5 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-0 text-sm';
                                        div.innerHTML = `
                                            <div class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="text-gray-700">${address}</span>
                                            </div>
                                        `;

                                        div.addEventListener('click', function() {
                                            addressInput.value = '';
                                            addressSuggestions.classList.add(
                                                'hidden');

                                            const latlng = L.latLng(lat, lon);
                                            umkmMap.setView(latlng, 16);
                                            placeUmkmMarker(latlng);
                                        });

                                        addressSuggestions.appendChild(div);
                                    });

                                    addressSuggestions.classList.remove('hidden');
                                } else {
                                    addressSuggestions.classList.add('hidden');
                                }
                            })
                            .catch(error => console.error('Error fetching addresses:', error));
                    }, 300);
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!addressInput.contains(e.target) && !addressSuggestions.contains(e.target)) {
                        addressSuggestions.classList.add('hidden');
                    }
                });
            }
        });

        document.addEventListener('livewire:load', function() {
            console.log('Livewire loaded - Reinitializing map...');
            setTimeout(() => {
                initUmkmMap();
            }, 300);
        });

        // Re-initialize map when navigating back to this step
        window.addEventListener('reinit-map', function() {
            console.log('Reinit map event triggered');

            setTimeout(() => {
                initUmkmMap();
            }, 300);
        });

        // Livewire navigation hook
        document.addEventListener('livewire:navigated', function() {
            console.log('Livewire navigated - Checking map...');
            const mapContainer = document.getElementById('umkm-map');
            if (mapContainer) {
                setTimeout(() => {
                    initUmkmMap();
                }, 300);
            }
        });

        // Prevent map from being destroyed on Livewire updates
        document.addEventListener('livewire:update', function() {
            console.log('Livewire update detected');
        });

        // Re-render map after any Livewire update
        Livewire.hook('message.processed', (message, component) => {
            console.log('Livewire message processed');
            const mapContainer = document.getElementById('umkm-map');
            if (mapContainer && umkmMap) {
                setTimeout(() => {
                    if (umkmMap) {
                        umkmMap.invalidateSize();
                    }
                }, 100);
            }
        });
    </script>

    <style>
        #umkm-map {
            min-height: 208px;
            height: 208px;
            width: 100%;
            z-index: 1;
            position: relative;
        }

        /* Ensure Leaflet container maintains size */
        #umkm-map .leaflet-container {
            height: 208px !important;
            width: 100% !important;
        }

        .custom-marker {
            background: transparent;
            border: none;
        }

        .leaflet-container {
            height: 100%;
            width: 100%;
            z-index: 1;
        }

        /* Prevent Leaflet from being hidden */
        .leaflet-pane,
        .leaflet-tile,
        .leaflet-marker-icon,
        .leaflet-marker-shadow,
        .leaflet-tile-container,
        .leaflet-map-pane {
            visibility: visible !important;
            opacity: 1 !important;
        }

        #city-suggestions,
        #address-suggestions {
            max-height: 240px;
            z-index: 1000;
        }

        #city-suggestions>div:first-child,
        #address-suggestions>div:first-child {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        #city-suggestions>div:last-child,
        #address-suggestions>div:last-child {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
    </style>
@endpush

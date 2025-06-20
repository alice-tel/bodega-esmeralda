<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    topStations: Array,
    stations: {
        type: Array,
        required: true,
    }
});

const showWelcome = ref(false);
const map = ref(null);
const mapContainer = ref(null);
const stationsArray = Object.entries(props.stations);

onMounted(() => {
    if (!localStorage.getItem('welcomeShown')) {
        showWelcome.value = true;
        localStorage.setItem('welcomeShown', 'true');

        setTimeout(() => {
            showWelcome.value = false;
        }, 3000);
    }

    setUpIcon();
    setUpMap();
    setUpMapMarkers();
    setUpMapReseizer();
});

function setUpIcon(){
    // Fix for default markers in Leaflet with Webpack
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    });
}

function setUpMap(){
    // Detect mobile
    const isMobile = window.innerWidth <= 640; // Tailwind's sm breakpoint
    const zoomLevel = isMobile ? 4 : 6; // 4 for mobile, 6 for desktop

    map.value = L.map(mapContainer.value, {
        dragging: false,
        zoomControl: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        tap: false,
        touchZoom: false,
    }).setView([-34.6118, -58.3960], zoomLevel);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map.value);
}

function setUpMapMarkers(){
    for (const station of stationsArray) {
        const data = station[1];
        const temperature = data['temperature'];
        addMapMarker(data['longitude'], data['latitude'], temperature);
    }
}

function addMapMarker(longitude, latitude, temperature){
    const tempIcon = L.divIcon({
        className: 'custom-temp-marker',
        html: `<div class="temp-marker">${temperature}°C</div>`,
        iconSize: [30, 30],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    L.marker([latitude, longitude], { icon: tempIcon })
        .addTo(map.value);
}

function setUpMapReseizer(){
    // Resize map when container changes
    setTimeout(() => {
        map.value.invalidateSize();
    }, 100);
}


onUnmounted(() => {
    if (map.value) {
        map.value.remove();
    }
});

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <span class="text-lg sm:text-xl font-semibold leading-tight text-font-800">
                    Welcome, {{ $page.props.auth.user.name }}
                </span>
                <a :href="route('export.data')" download="'measurements.il'" >
                    <button class="bg-details-100 hover:from-details-100 hover:to-red-800 text-white font-s py-1.5 px-3 rounded-lg text-sm shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        Export
                    </button>
                </a>
            </div>
        </template>

        <div class="space-y-4 px-2 py-3 sm:px-2 sm:py-1 md:px-2 lg:px-2">
            <template v-if="showWelcome">
                <div class="mb-4 sm:mb-2">
                    <div class="bg-secondary-100 shadow rounded-lg p-4 sm:p-8 text-background-100">
                        You're logged in!
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 sm:gap-4">
                <Link
                    :href="route('map')"
                    class="bg-background-100 shadow rounded-lg p-3 sm:p-8 h-full lg:h-[calc(100vh-10rem)] lg:col-span-2 block no-underline text-font-100"
                >
                    <h3 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Mini Map</h3>
                    <div
                        ref="mapContainer"
                        class="w-full h-80 lg:h-[calc(100vh-257px)] bg-secondary-50 rounded-lg overflow-hidden"
                        style="z-index: 1;"
                    ></div>
                </Link>

                <div class="bg-background-100 shadow rounded-lg p-3 sm:p-8 h-full lg:h-[calc(100vh-10rem)] lg:col-span-1">
                    <h4 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Most Humid Weather Stations</h4>
                    <ol class="space-y-1.5 p-1 sm:space-y-2">
                        <li v-for="(station, index) in topStations" :key="station.name" class="flex justify-between items-center">
                            <Link :href="route('getGraph', { stationName: station.name })" class="flex justify-between w-full no-underline text-font-100 hover:underline">
                                <div class="flex items-center gap-2">
                                    <span class="text-secondary-100 min-w-[1.5rem]">{{ index + 1 }}.</span>
                                    <div class="flex flex-col">
                                        <span>{{ station.location }}</span>
                                        <span class="text-sm text-gray-500">Station: {{ station.name }}</span>
                                    </div>
                                </div>
                                <span class="text-secondary-100">{{ station.average }}%</span>
                            </Link>
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
:deep(.leaflet-container) {
    font-family: inherit;
    border-radius: 8px;
    overflow: hidden;
}

:deep(.leaflet-popup-content-wrapper) {
    border-radius: 8px;
}

:deep(.leaflet-popup-tip) {
    background: white;
}

:deep(.custom-temp-marker .temp-marker) {
    background: #2b394E;
    color: white;
    font-weight: bold;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    font-size: 0.9rem;
}

@media (max-width: 640px) {
  :deep(.custom-temp-marker .temp-marker) {
    width: 28px;
    height: 28px;
    font-size: 0.7rem;
  }
}
</style>

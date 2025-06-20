<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    stations: {
        type: Array,
        required: true,
    }
});

const map = ref(null);
const mapContainer = ref(null);

const stationsArray = Object.entries(props.stations);

onMounted(() => {
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

    map.value = L.map(mapContainer.value).setView([-34.6118, -58.3960], zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map.value);
}

function setUpMapMarkers(){
    for (const station of stationsArray) {
        const data = station[1];
        const stationName = data['name'];
        const stationLocation = data['location'];
        const temperature = data['temperature'];
        const time = data['time'];
        const message = `<a href="/graph/${stationName}"><p> Location: ${stationLocation} <br> Station: ${stationName} <br> Temp: ${temperature}°C <br> Time: ${time}</p></a>`
        addMapMarker(data['longitude'], data['latitude'], message, temperature);
    }
}

function addMapMarker(longitude, latitude, message, temperature){
    const tempIcon = L.divIcon({
        className: 'custom-temp-marker',
        html: `<div class="temp-marker">${temperature}°C</div>`,
        iconSize: [30, 30], // adjust as needed
        iconAnchor: [20, 40], // adjust as needed
        popupAnchor: [0, -40]
    });

    L.marker([latitude, longitude], { icon: tempIcon })
        .addTo(map.value)
        .bindPopup(message);
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

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Map" />

    <AuthenticatedLayout>
        <template #header>
                Map
        </template>

        <div class="pt-3">
            <div class="space-y-4 px-2 sm:px-0 md:px-0 lg:px-0">
                <div class="bg-background-100 shadow rounded-lg">
                    <div
                        ref="mapContainer"
                        class="w-full h-[calc(100vh-230px)] lg:h-[calc(100vh-150px)] min-h-[500px] rounded-lg overflow-hidden"
                        style="z-index: 1;"
                    ></div>
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

:deep(.leaflet-popup-content a) {
    text-decoration: none;
    color: inherit;
    font-weight: 500;
    transition: color 0.2s;
}
:deep(.leaflet-popup-content a:hover) {
    color: #CF1F25; /* Tailwind's red-600 */
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

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

defineProps({
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
});

const map = ref(null);
const mapContainer = ref(null);

onMounted(() => {
    // Fix for default markers in Leaflet with Webpack
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    });

    // Initialize the map
    map.value = L.map(mapContainer.value).setView([-34.6118, -58.3960], 6); // Centered on Argentina (Buenos Aires) :)

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map.value);

    // Example: Add a marker
    L.marker([-34.6118, -58.3960])
        .addTo(map.value)
        .bindPopup('¡Hola desde Buenos Aires, Argentina!')
        .openPopup();

    // Resize map when container changes
    setTimeout(() => {
        map.value.invalidateSize();
    }, 100);
});

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
/* Ensure Leaflet controls are properly styled */
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
</style>

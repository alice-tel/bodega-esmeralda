<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { Link } from '@inertiajs/vue3';

const showWelcome = ref(false);
const map = ref(null);
const mapContainer = ref(null);

onMounted(() => {
    if (!localStorage.getItem('welcomeShown')) {
        showWelcome.value = true;
        localStorage.setItem('welcomeShown', 'true');
        
        setTimeout(() => {
            showWelcome.value = false;
        }, 3000);
    }

    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    });

    map.value = L.map(mapContainer.value).setView([-34.6118, -58.3960], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map.value);

    L.marker([-34.6118, -58.3960])
        .addTo(map.value)
        .bindPopup('¡Hola desde Buenos Aires, Argentina!')
        .openPopup();

    setTimeout(() => {
        map.value.invalidateSize();
    }, 100);
});

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
                <button class="bg-details-100 hover:from-details-100 hover:to-red-800 text-white font-s py-1.5 px-3 rounded-lg text-sm shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                    Export
                </button>
            </div>
        </template>
        
        <div class="space-y-4 px-2 py-3 sm:px-2 md:px-2 lg:px-2">
            <template v-if="showWelcome">
                <div class="mb-4">
                    <div class="bg-secondary-100 shadow rounded-lg p-4 sm:p-8 text-background-100">
                        You're logged in!
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 ">
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
                    <h4 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">Top 10</h4>
                    <ul class="space-y-1.5 sm:space-y-2">
                        <li class="flex justify-between items-center">
                            <span>Manaus, Brazil</span>
                            <span class="text-primary-100">98%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Iquitos, Peru</span>
                            <span class="text-primary-100">96%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Belém, Brazil</span>
                            <span class="text-primary-100">94%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Leticia, Colombia</span>
                            <span class="text-primary-100">92%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Puerto Maldonado, Peru</span>
                            <span class="text-primary-100">90%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Macapá, Brazil</span>
                            <span class="text-primary-100">88%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Santa Cruz, Bolivia</span>
                            <span class="text-primary-100">86%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Cayenne, French Guiana</span>
                            <span class="text-primary-100">84%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Paramaribo, Suriname</span>
                            <span class="text-primary-100">82%</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Georgetown, Guyana</span>
                            <span class="text-primary-100">80%</span>
                        </li>
                    </ul>
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
</style>
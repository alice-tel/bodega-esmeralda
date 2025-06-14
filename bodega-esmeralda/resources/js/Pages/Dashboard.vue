<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const showWelcome = ref(false);

onMounted(() => {
    if (!localStorage.getItem('welcomeShown')) {
        showWelcome.value = true;
        localStorage.setItem('welcomeShown', 'true');
        
        setTimeout(() => {
            showWelcome.value = false;
        }, 3000);
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
        
        <div class="mx-auto max-w-7xl px-2 py-3 sm:px-6 lg:px-8">
            <template v-if="showWelcome">
                <div class="mb-4">
                    <div class="bg-secondary-100 shadow rounded-lg p-4 sm:p-8 text-background-100">
                        You're logged in!
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-background-100 shadow rounded-lg p-4 sm:p-8 h-full lg:h-[calc(100vh-16rem)]">
                    <h3 class="text-xs lg:text-xl font-semibold mb-4">Mini Map</h3>
                    <div class="relative w-full h-80 lg:h-[calc(100%-3rem)] bg-secondary-50 rounded-lg overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15983658.45513576!2d-60.0!3d-3.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus"
                            class="absolute inset-0 w-full h-full border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <div class="bg-background-100 shadow rounded-lg p-4 sm:p-8 h-full lg:h-[calc(100vh-16rem)]">
                    <h4 class="text-xs lg:text-xl font-semibold mb-4">Top 10</h4>
                    <ul class="space-y-2">
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
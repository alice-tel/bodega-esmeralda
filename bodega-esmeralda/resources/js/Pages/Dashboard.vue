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
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <template v-if="showWelcome">
            <div class="py-3">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-primary-100 shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            You're logged in!
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    Hier komt dashboard dingen :)         
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

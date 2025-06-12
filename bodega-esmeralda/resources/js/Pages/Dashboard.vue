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
            <h2 class="text-xl font-semibold leading-tight text-font-800">
                Dashboard
            </h2>
        </template>
        
        <template v-if="showWelcome">
            <div class="py-4">
                <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                    <div class="bg-secondary-100 shadow rounded-lg p-4 sm:p-8 text-background-100">
                        You're logged in!
                    </div>
                </div>
            </div>
        </template>

        <div class="py-4">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <div class="bg-background-100 shadow rounded-lg p-4 sm:p-8">
                    Hier komt dashboard dingen :)         
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
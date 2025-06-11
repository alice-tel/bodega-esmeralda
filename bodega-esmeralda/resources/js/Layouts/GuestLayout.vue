<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <div class="flex min-h-screen flex-col items-center bg-primary-100 justify-center">

        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500 mb-3" />
            </Link>
        </div>

        <div class="max-w-xs mx-auto overflow-hidden bg-background-100 px-6 py-4 shadow-md rounded-lg">
            <slot/>
        </div>

    </div>
    
</template>
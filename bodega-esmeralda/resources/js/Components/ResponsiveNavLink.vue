<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-details-100 text-start text-base font-medium text-font-100 bg-primary-100 focus:outline-none focus:text-details-100 focus:bg-primary-100 focus:border-details-100 transition duration-150 ease-in-out no-underline'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-font-100 hover:text-details-100 hover:bg-primary-100 hover:border-details-100 focus:outline-none focus:text-details-100 focus:bg-primary-100 focus:border-details-100 transition duration-150 ease-in-out no-underline',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

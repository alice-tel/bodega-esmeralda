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
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-details-100 text-sm font-medium leading-5 text-font-100 focus:outline-none focus:border-details-100 transition duration-150 ease-in-out no-underline'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-font-100 hover:text-details-100 hover:border-details-100 focus:outline-none focus:text-details-100 focus:border-details-100 transition duration-150 ease-in-out no-underline',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

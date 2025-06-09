<script setup>
// import {ref } from "vue";
// let input = ref("");

const props = defineProps({
    stations: Array
});
</script>

<template>
    <div>
        <h1>Station Data</h1>

        <pre>{{ props.stations }}</pre>

        <!-- pak elke measurements los-->
        <div
            v-for="(eachHours, hours) in stations"
            :key="hours"
            style="border: 1px solid #ccc; margin-bottom: 1rem; padding: 1rem; border-radius: 8px;"
        >
            <pre> {{ eachHours.temperature }} </pre>

        </div>
    </div>
</template>



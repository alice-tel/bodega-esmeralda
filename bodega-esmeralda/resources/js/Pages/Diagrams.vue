<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const stations = ref([])
const selectedStation = ref(null)
const chart = ref(null)

const fetchStations = async () => {
    const response = await axios.get('/api/stations')
    stations.value = response.data
    selectedStation.value = stations.value[0] // standaard eerste
    renderChart()
}

const renderChart = () => {
    if (!selectedStation.value) return

    const ctx = document.getElementById('chart').getContext('2d')
    if (chart.value) chart.value.destroy()

    chart.value = new Chart(ctx, {
        type: 'line',
        data: {
            labels: selectedStation.value.data.map(d => d.time),
            datasets: [
                {
                    label: 'Temperature (°C)',
                    data: selectedStation.value.data.map(d => d.temperature),
                    borderColor: 'red',
                    fill: false,
                },
                {
                    label: 'Humidity (%)',
                    data: selectedStation.value.data.map(d => d.humidity),
                    borderColor: 'blue',
                    fill: false,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: `Data voor station ${selectedStation.value.name}`
                }
            }
        }
    })
}

onMounted(fetchStations)
</script>

<template>
    <div>
        <select v-model="selectedStation" @change="renderChart">
            <option v-for="station in stations" :key="station.name" :value="station">
                {{ station.name }}
            </option>
        </select>

        <canvas id="chart" width="800" height="400"></canvas>
    </div>
</template>

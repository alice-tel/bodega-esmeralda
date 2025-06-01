<template>
    <div>
        <h1>Station Data</h1>

        <!-- Zoekbalk poging 2 -->
        <input
            v-model="searchQuery"
            type="text"
            placeholder="Search station id..."
            style="margin-bottom: 1rem; padding: 0.5rem; width: 100%; max-width: 400px; border: 1px solid #ccc; border-radius: 4px;"
        />

        <!-- Station blokken om ze te splitten vann elkaar-->
        <div
            v-for="(entries, name) in filteredStations"
            :key="name"
            style="border: 1px solid #ccc; margin-bottom: 2rem; padding: 1rem; border-radius: 8px;"
        >
            <h2>Station: {{ name }}</h2>

            <div style="display: flex; gap: 2rem; overflow-x: auto;">
                <canvas :id="`temp-${name}`" width="400" height="200"></canvas>
                <canvas :id="`hum-${name}`" width="400" height="200"></canvas>
            </div>

<!--            <h3>Raw Data:</h3>-->
<!--            <pre>{{ JSON.stringify(entries, null, 2) }}</pre>-->
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed, nextTick, watch } from 'vue'
import axios from 'axios'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const stationsRaw = ref([])
const searchQuery = ref('')

onMounted(async () => {
    try {
        const response = await axios.get('/api/stations')

        const text = typeof response.data === 'string' ? response.data : JSON.stringify(response.data)
        const cleaned = text.replace(/^<!--[\s\S]*?-->\n?/, '')

            stationsRaw.value = JSON.parse(cleaned)

        await nextTick()
        renderAllCharts()
    } catch (error) {
        stationsRaw.value = [{ error: error.message }]
    }
})

// Group raw stations by name
const groupedStations = computed(() => {
    const groups = {}
    for (const station of stationsRaw.value) {
        if (!groups[station.name]) {
            groups[station.name] = []
        }
        groups[station.name].push(station)
    }
    return groups
})

// Filter stations based on search query
const filteredStations = computed(() => {
    const query = searchQuery.value.toLowerCase()
    return Object.fromEntries(
        Object.entries(groupedStations.value).filter(([name]) =>
            name.toLowerCase().includes(query)
        )
    )
})

// dit zorgt ervoor dat t niet telkens wachten tot search knop is maar t actief mee veranderd (zoekbar)
watch(filteredStations, async () => {
    await nextTick()
    renderAllCharts()
})

// Draw charts
const renderAllCharts = () => {
    Object.entries(filteredStations.value).forEach(([name, entries]) => {
        const hourlyData = Array.from({ length: 24 }, (_, h) => {
            const hourStr = h.toString().padStart(2, '0')
            const entry = entries.find(e => e.time.startsWith(hourStr))
            return {
                hour: hourStr,
                temperature: entry ? entry.tempurture : null,
                humidity: entry ? entry.humidity : null
            }
        })
//grafieken gejat van t internet
        const tempCtx = document.getElementById(`temp-${name}`)
        if (tempCtx) {
            new Chart(tempCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: hourlyData.map(d => d.hour),
                    datasets: [
                        {
                            label: 'Temperature (°C)',
                            data: hourlyData.map(d => d.temperature),
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: false,
                    scales: {
                        y: { min: -50, max: 50 }
                    },
                    plugins: {
                        title: { display: true, text: `Temperature (°C) by Hour - Station ${name}` }
                    }
                }
            })
        }

        const humCtx = document.getElementById(`hum-${name}`)
        if (humCtx) {
            new Chart(humCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: hourlyData.map(d => d.hour),
                    datasets: [
                        {
                            label: 'Humidity (%)',
                            data: hourlyData.map(d => d.humidity),
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: false,
                    scales: {
                        y: { min: 0, max: 100 }
                    },
                    plugins: {
                        title: { display: true, text: `Humidity (%) by Hour - Station ${name}` }
                    }
                }
            })
        }
    })
}
</script>

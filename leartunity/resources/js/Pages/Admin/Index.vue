<template>
<Layout>
    <main>
        <AdminNavbar></AdminNavbar>
        <section class="statistics container mx-auto mt-3">
            <div class="stats-cards flex justify-between">
                <div class="stats-card rounded flex mb-4">
                    <div class="icon p-2" style="width: 30%;">
                        <i class="fa-solid fa-user" style="font-size:70px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-detail text-center" style="width: 50%;">
                        <h1 style="font-weight: bold; font-size: 21px;">Total Users</h1>
                        <p style="font-size: 25px;">{{ counts.users }}</p>
                    </div>
                </div>
                <div class="stats-card rounded flex mb-4">
                    <div class="icon p-2" style="width: 30%;">
                        <i class="fa-solid fa-list" style="font-size:70px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-detail text-center" style="width: 50%;">
                        <h1 style="font-weight: bold; font-size: 21px;">Total Categories</h1>
                        <p style="font-size: 25px;">{{ counts.categories }}</p>
                    </div>
                </div>
                <div class="stats-card rounded flex mb-4">
                    <div class="icon p-2" style="width: 30%;">
                        <i class="fa-solid fa-person-chalkboard" style="font-size:70px; opacity: 0.8;"></i>
                    </div>
                    <div class="card-detail text-center" style="width: 50%;">
                        <h1 style="font-weight: bold; font-size: 21px;">Total Courses</h1>
                        <p style="font-size: 25px;">{{ counts.courses }}</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="charts" class="container mx-auto mt-3 mb-3">
            <div class="main-charts flex justify-between">
                <div class="chart" style="width: 28%;">
                    <h1 class="font-bold">Most Categories Used</h1>
                    <canvas class="pie-chart" id="pie_chart"></canvas>
                </div>
                <div class="chart" style="width: 68%;">
                    <h1 class="font-bold">Most Purchased Courses</h1>
                    <canvas class="pie-chart" id="pie_chart2"></canvas>
                </div>
            </div>
        </section>
    </main>
</Layout>
</template>
<script setup>
import { Chart, registerables } from 'chart.js';
import Layout from "../../Shared/Layout.vue"
import {ref, onMounted} from "vue";
import CreateChart from '../../Classes/Chart';
import AdminNavbar from '../../Components/AdminNavbar.vue';

let props = defineProps({
    'counts': Array,
    "pie_chart": Array,
    "bar_graph": Array
})

onMounted(() => {
    CreateChart(pie_chart, "pie", props.pie_chart.labels, props.pie_chart.data, "Total Courses");
    CreateChart(pie_chart2, "bar", props.bar_graph.labels, props.bar_graph.data, "Most Purchases Courses");
})

</script>

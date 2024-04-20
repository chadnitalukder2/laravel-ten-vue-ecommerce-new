<template>
    <BarChart :chartData="monthly_order_report" :width="40" />
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import { BarChart } from 'vue-chart-3';
  import { Chart, registerables } from "chart.js";
  
  Chart.register(...registerables);
  
  export default defineComponent({
    name: 'Home',
    components: { BarChart },
    props: ["monthly_order_report"],
  });
  </script>
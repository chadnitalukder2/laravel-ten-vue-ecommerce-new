<template>
    <BarChart :chartData="testData" />
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  import { BarChart } from 'vue-chart-3';
  import { Chart, registerables } from "chart.js";
  
  Chart.register(...registerables);
  
  export default defineComponent({
    name: 'Home',
    components: { BarChart },
    setup() {
      const testData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [
          {
            data: [65, 59, 80, 81, 56, 55, 40, 60, 70, 80, 90, 100],
            backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
          },
        ],
      };
  
      return { testData };
    },
  });
  </script>
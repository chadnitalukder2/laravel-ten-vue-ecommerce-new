<template>
    <main style="display: flex; width: 100%;">
        <sidebar />
        <router-view></router-view>
    </main>
</template>
<script setup>
import sidebar from '../../components/sidebar.vue';
</script>
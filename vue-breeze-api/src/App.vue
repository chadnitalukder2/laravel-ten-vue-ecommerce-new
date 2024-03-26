<script setup>
import Nav from './components/Nav.vue';

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();

const user = ref([]);

onMounted(async () => {
  getUser();
});

const getUser = async () => {
  try {
    const res = await axios.get("/api/user");
    if (res.status === 200) {
      user.value = res.data; // Assuming user data is stored in res.data
    } else {
      router.push('/login');
    }
  } catch (error) {
    console.error('Error fetching user data:', error);
    router.push('/login'); // Redirect to login page if an error occurs
  }
}

</script>

<template>
  
<div>

  <Nav :user="user"></Nav>
  <main style=" width: 100%;">
      <notifications />
      <router-view></router-view>
  </main>
</div>

</template>

<style scoped>

</style>

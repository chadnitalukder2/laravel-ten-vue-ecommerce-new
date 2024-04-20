<script setup>
import productTable from "./product_table.vue";

</script>
<template>
  <div class="container">
    <div class="table-box">
      <div class="btn">
        <button>
          <router-link :to="{ name: 'add-product' }"> Add Product </router-link>
        </button>
      </div>
      <h1>All Product</h1>
     <productTable/>
    </div>
  </div>
</template>

<style lang="scss" scoped>

h1 {
  margin-top: 0px;
  font-size: 24px;
  color: #444;
}
.container {
  width: 100%;
}

</style>

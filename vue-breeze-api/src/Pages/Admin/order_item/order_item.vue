<script setup>
import '@fortawesome/fontawesome-free/css/all.css';
import orderTable from "./order_table.vue";
</script>

<template>
<div class="container">
    <div class="table-box">
        <h1>Order Items</h1>
       <orderTable/>
    </div>
</div>
</template>

<style lang="scss" scoped>
h1 {
   margin-top:0px ;
    font-size: 25px;
    color: #444;
}
.container {
    width: 100%;
}
.table-box {
    padding: 50px;
    border-radius: 8px;
}

</style>
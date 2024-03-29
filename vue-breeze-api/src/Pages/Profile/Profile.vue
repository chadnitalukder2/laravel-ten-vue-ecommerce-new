<script setup>
import '@fortawesome/fontawesome-free/css/all.css';

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
import { useRoute } from "vue-router";
const route = useRoute();
//-------------------------------------------------
const orderItems = ref([]);
//--------------------------------------------------
onMounted(async () => {
  getOrders();
});
//--------------------------------------
const getOrders = async () => {
    let response = await axios.get("/api/get_orders");
    orderItems.value = response.data.orderItem ;
console.log('responsedd', orderItems.value );
};
</script>

<template>
  <div class="container">
    <div class="table-box">
      <div >
        <h1 style="text-align: left;">Order Items</h1>
      </div>
      
      <table id="customers">
        <tr>
          <th># ID</th>
          <th>Image</th>
          <th>Name</th>
          <th>Color</th>
          <th>Size</th>
          <th>Quantity</th>
          <th>Price</th>
  
        </tr>
        <tbody v-for="item in orderItems" :key="item.id">
          <tr>
            <td style="color: blue"># {{ item.id }}</td>
            <td style="width: 120px; height: 100px">
              <img
                :src="item.product.product_img"
                style="width: 100%; height: 100%"
              />
            </td>
            <td>{{ item.product.product_name }}</td>
            <td>{{ item.color }}</td>
            <td>{{ item.size }}</td>
            <td>{{ item.quantity }}</td>
            <td>{{ item.product.product_price }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.container {
  padding: 80px 100px;
  text-align: center;
}


table {
  border-collapse: collapse;
  width: 100%;
}
th {
  background: #d1eae4;
  padding: 20px 10px !important;
  border: 1px solid transparent;
  font-size: 22px;
}
th,
td {
  padding: 15px;
  text-align: center;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
td{
  input{
    width: 40%;
    padding: 15px 10px;
    text-align: center;
    border: 1px solid rgba(0, 0, 0, 0.05);
    &:focus-visible{
      outline: none;
      border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }
  }
}


</style>
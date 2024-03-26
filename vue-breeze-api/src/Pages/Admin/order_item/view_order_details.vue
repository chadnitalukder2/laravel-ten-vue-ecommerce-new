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
  getOrderItemByOrderId();
});
//--------------------------------------
const getOrderItemByOrderId = async () => {
  const id = route.params.id;
  // console.log('routhiuhuunje', id);
  let response = await axios.get(`/api/getOrderItemByOrderId/${id}`);
  orderItems.value = response.data.orderItem;
  console.log("responseydyhfb", orderItems.value);
};
</script>

<template>
  <div class="container">
    <div class="table-box">
      <div style="display: flex; gap: 10px;align-items: baseline;">
        <span>
          <router-link :to="{ name: 'all-order' }">
            <i style="color:#444 ;" class="fa-solid fa-arrow-left"></i>
          </router-link>
          
        </span>
        <h1>Order Details</h1>
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
h1 {
  margin-top: 0px;
  font-size: 24px;
  color: #444;
}
td {
  button {
    cursor: pointer;
    border: 1px solid #ddd;
    background: transparent;
    a {
      text-decoration: none;
    }
  }
}

.container {
  width: 100%;
}
.table-box {
  padding: 50px;
}
table {
  border-radius: 6px;
  overflow: hidden;
}

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td,
#customers th {
  border: 1px solid #f3ededad;
  padding: 15px 15px;
  text-align: left;
}

#customers tr:nth-child(even) {
  background-color: #f2f2f2;
}

#customers th {
  padding-top: 20px;
  padding-bottom: 20px;
  text-align: left;
  background-color: rgb(237 236 236 / 68%);
  color: #444;
}
</style>

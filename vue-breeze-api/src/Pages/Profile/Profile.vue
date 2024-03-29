<script setup>
import '@fortawesome/fontawesome-free/css/all.css';
import { useNotification } from "@kyvg/vue3-notification";
const { notify }  = useNotification();

import Modal from "../../components/global/Modal.vue";

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
import { useRoute } from "vue-router";
const route = useRoute();
//-------------------------------------------------
const orderItems = ref([]);
const deleteVisibleId = ref(null);
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
//-------------------------------------------
const deleteOrder = (id) => {
    axios.get(`/api/delete_Order/${id}`).then( () => {
      notify({
        title: "Order Item Deleted",
        type: "success",
      });
      getOrders();
    })
}
//---------------------------------------------------
const openModalDelete = (id) => {
    deleteVisibleId.value = id;
};
const closeModalDelete = () => {
    deleteVisibleId.value =null;
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
          <th>Action</th>
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
            <td @click="openModalDelete(item.id)" style="    font-size: 20px;font-weight: 600;color: #cb0505;cursor: pointer;">Cancel</td>
          </tr>
          <Modal :show="deleteVisibleId === item.id" @close="closeModalDelete">
                    <div id="myModal" style="text-align: center;">
                        <h4 style="margin-top: 20px; font-size: 26px; color: #636363; font-weight: 500;">Are you sure?</h4>
                        <div class="modal-body">
                            <p style="font-size: 14px; color: #999999;">Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal_footer" style="padding: 20px;" >
                            <!-- <button @close="closeModalDelete" type="button" class="secondary" >Cancel</button> -->
                            <button @click="deleteOrder(item.id)" type="button" style="background: #f15e5e;">Delete</button>
                        </div>   
                    </div>  
           </Modal>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style lang="scss" scoped>

#myModal{
.modal_footer{
  button{
  
  cursor: pointer;
  background: #c1c1c1;
  color: #fff;
  border-radius: 4px;
  text-decoration: none;
  transition: all 0.4s;
  line-height: normal;
  min-width: 120px;
  border: none;
  min-height: 40px;
  border-radius: 3px;
  margin: 0 5px;
  }
 
}
 
}
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
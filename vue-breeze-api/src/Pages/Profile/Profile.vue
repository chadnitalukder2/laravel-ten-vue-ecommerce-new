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
const orderDetails = ref([]);
const VisibleId = ref(null);
//--------------------------------------------------
onMounted(async () => {
  getOrders();
  getOrderDetails();
});
//--------------------------------------
const getOrders = async () => {
  console.log('item', id)
    let response = await axios.get("/api/get_orders");
    orderItems.value = response.data.orderItem ;
console.log('responsedd', response );
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
const openModalView = (id) => {
  VisibleId.value = id;
};
const closeModalView = () => {
  VisibleId.value =null;
};
//----------------------------------------------
const getOrderDetails = async () => {
  let response = await axios.get("/api/get_order_details");
  orderDetails.value = response.data.orderDetails ;
  //  console.log('responsedd', orderDetails.value );
}
//----------------------------------------------
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { month: 'short', day: '2-digit', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
};
//-------------------------------------------------------

</script>

<template>
  <div class="container" style="display: flex; justify-content: space-between; gap: 40px;">
    <div class="left_content" >
        <div class="profile_section">
          <div class="profile_img">
            <div class="image">
              <img src="../../../8d52c5c35382908832ffedb21c1e63b0.jpg"  style="width: 100%; height: 100%">
            </div>
          </div>
          <div class="profile_info">
            <h4>NItesh Dash</h4>
            <p style="margin: 0px;">nitesh@gmail.com</p>
            <p style=" margin-top: 10px;">01753507283</p>
          </div>
          <button>Logout</button>
        </div>
    </div>
      <div class="right_content">

           <div class="table-box" >
          <div >
            <h1 style="text-align: left; margin: 0px; margin-bottom: 20px;">Order Items</h1>
          </div>
          
          <table id="customers">
            <tr>
              <th></th>
              <th>Total Amount</th>
              <th>Order Status</th>
              <th>Payment Status</th>
              <th>Date</th>
              <th></th>
              <!-- <th></th> -->
            </tr>
            <tbody v-for="item in orderDetails" :key="item.id">
              <tr>
                <td style="color: blue"># {{ item.id }}</td>
                <td>{{ item.total_amount }}</td>
                <td>{{ item.order_status }}</td>
                <td>{{ item.payment_status }}</td>
                <td>{{ formatDate(item.created_at) }}</td>
                <!-- <td @click="openModalDelete(item.id)" style="    font-size: 20px;font-weight: 600;color: #cb0505;cursor: pointer;">Cancel</td> -->
                <td > 
                  <button @click="openModalView(item.id)" class="view"> View</button>
                </td>
              </tr>
              <Modal :show="VisibleId === item.id" @close="closeModalView">
                {{ item.id }}
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
                      <tbody v-for="item in orderItemsh" :key="item.id">
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
              </Modal>
            </tbody>
          </table>
           </div>

           <div class="info" v-for="item in orderDetails" :key="item.id">
              <h1>Shipping Address</h1>

              <p>Name : {{ item.name }}</p>
              <p>Email :  {{ item.email }}</p>
              <p>Address : {{ item.address }} </p>
              <p>Phone : {{ item.phone }} </p>
           </div>
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
  padding: 50px ;
  text-align: center;
  background: #d7d1d130;

  .left_content{
    flex-basis: 25%;
    height: 100%;
    background: #fff;
    box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    .profile_section{
      position: relative;
      .profile_img{
        background: rgba(215, 209, 209, 0.1882352941);
        height: 175px;
       
        .image{
          border-radius: 50%;
          overflow: hidden;
          position: absolute;
          bottom: 170px;
          right: 70px;
          text-align: center;
          width: 160px;
          height: 160px
        }
      }
      .profile_info{
        margin-top: 40px;
        h4{
          font-size: 20px;
          font-weight: 600;
          margin-bottom: 8px;
        }
        p{
          color: #363636;
          font-size: 16px;
        }
      }
      button{
        width: 70%;
        font-size: 15px;
        padding: 8px;
        border-radius: 5px;
        background: #179f83;
        color: white;
        border: 1px solid #179f83;
        cursor: pointer;
        margin-bottom: 30px
      }
    }
  }

  .right_content{
    flex-basis: 75%;
    .info{
      background: #fff;
      padding: 20px 30px;
      text-align: left;
      margin: 20px 0px;
      box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      h1{
        margin: 0px;
        font-size: 24px;
      }
      p{
        font-size: 18px;
        font-weight: 500;
        text-transform: capitalize;
      }
    }
  }
}


table {
  border-collapse: collapse;
  width: 100%;
  box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1);
  border-radius: 6px;
  overflow: hidden;
}
th {
  background: #fff;
  padding: 20px 10px !important;
  border: 1px solid transparent;
  font-size: 20px;
}
th,
td {
  padding: 15px;
  text-align: center;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  background: #fff;
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
  button{
    border-radius: 5px;
    font-size: 16px;
    padding: 5px 10px;
    border: none;
    font-weight: 600;
    color: rgb(61, 66, 66);
    cursor: pointer;
    &:hover{
      color: rgb(14 159 159);
    }
  }
}


</style>
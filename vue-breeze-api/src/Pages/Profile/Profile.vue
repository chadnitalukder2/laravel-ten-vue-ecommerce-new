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
const orderDetails = ref([]);
const userInfo = ref([]);
const VisibleId = ref(null);
const deleteVisibleId = ref(null);
//--------------------------------------------------
onMounted(async () => {
  getOrderDetails();
  user();
});
//-------------------------------------------
//---------------------------------------------------
const openModalDelete = (id) => {
    deleteVisibleId.value = id;
};
const closeModalDelete = () => {
    deleteVisibleId.value =null;
};

//--------------------------------------------
const deleteOrder = (id) => {
    axios.get(`/api/delete_order_item/${id}`).then(() => {
        notify({
            title: "Order Item Deleted",
            type: "success",
        });
        getOrderDetails();
    });
};
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
  console.log('responsedd', orderDetails.value );
}
//----------------------------------------------
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { month: 'short', day: '2-digit', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
};
//-------------------------------------------------------
const handleLogout = async () => {
    localStorage.removeItem('email');
    localStorage.removeItem('password');
    await axios.post('/logout');
    state.loggedIn = false;
    router.push({ name: 'Login' });
    // window.location.reload();
};
//---------------------------------------------------------

const user = async () =>{
  let response = await axios.get('/api/user');
  userInfo.value = response.data;
  // console.log('response', userInfo.value);
}
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
            <h4>{{ userInfo.name }}</h4>
            <p style="margin: 0px;">{{ userInfo.email }}</p>
            <p style=" margin-top: 10px;"> Role : {{ userInfo.role }}</p>
          </div>
          <button @click="handleLogout">
                        Logout
                    </button>
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
                    <th></th> 
                  </tr>
                  <tbody v-for="item in orderDetails" :key="item.id">
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
                    <tr>
                      <td style="color: blue"># {{ item.id }}</td>
                      <td>{{ item.total_amount }}</td>
                      <td>{{ item.order_status }}</td>
                      <td>{{ item.payment_status }}</td>
                      <td>{{ formatDate(item.created_at) }}</td>
                      <td> 
                        <p   v-if="item.order_status == 'Pending'" @click="openModalDelete(item.id)" style="color: rgb(191 42 42);cursor: pointer;">Cancel</p>
                        <p  v-else  > Delivered</p>
                      </td>
                      <td > 
                        <button @click="openModalView(item.id)" class="view"> View</button>
                      </td>
                    </tr>
                    <Modal  :show="VisibleId === item.id" @close="closeModalView">
                      <div >
                            <h1 style="text-align: left; font-size: 22px; margin-top: 10px;">Order Details</h1>
                          </div>
                      <div class="container" style="padding: 5px; background: transparent; display: flex; gap: 10px;">
                          
                          
                          <table id="customers" style="flex-basis: 80%;">
                            <tr>
                              <th style="font-size: 18px;padding: 15px 0px"></th>
                              <th style="font-size: 18px; padding: 15px 0px">Image</th>
                              <th style="font-size: 18px; padding: 15px 0px">Name</th>
                              <th style="font-size: 18px; padding: 15px 0px">Color</th>
                              <th style="font-size: 18px; padding: 15px 0px">Size</th>
                              <th style="font-size: 18px; padding: 15px 0px">Quantity</th>
                              <th style="font-size: 18px; padding: 15px 0px">Price</th>
                            </tr>
                            <tbody v-for="orderItem in item.order_item" :key="orderItem.id">
                          
                              <tr >
                                

                                <td style="color: blue; padding: 5px"># {{ orderItem.id }}</td>
                                <td style="width: 90px; height: 70px;padding: 5px">
                                  <img
                                    :src="orderItem.product.product_img"
                                    style="width: 100%; height: 100%"
                                  />
                                </td>
                                <td style="padding: 5px">{{ orderItem.product.product_name }}</td>
                                <td style="padding: 5px">{{ orderItem.color }}</td>
                                <td style="padding: 5px">{{ orderItem.size }}</td>
                                <td style="padding: 5px">{{ orderItem.quantity }}</td>
                                <td style="padding: 5px">{{ orderItem.product.product_price }}</td>
                              
                              </tr>
                            </tbody>
                          </table>

                          <div class="info" style="flex-basis: 20%;" >
                              <h1>Shipping Address</h1>

                              <p> <span style="font-weight: 600;">Name </span> : {{ item.name }}</p>
                              <p> <span style="font-weight: 600;">Email </span> :  {{ item.email }}</p>
                              <p> <span style="font-weight: 600;">Address </span> : {{ item.address }} </p>
                              <p> <span style="font-weight: 600;">Phone </span> : {{ item.phone }} </p>
                          </div>
                    
                      </div>
                    </Modal>
                  </tbody>
                </table>
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
          right: 25%;
          text-align: center;
          width: 170px;
          height: 170px
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
        border: 1px solid #179f83;
        cursor: pointer;
        margin-bottom: 30px;
          color: white;
      }
    }
  }

  .right_content{
    flex-basis: 75%;
    .info{
      background: #fff;
      padding: 10px 10px;
      text-align: left;
      box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      h1{
        margin: 0px;
        font-size: 18px;
      }
      p{
        font-size: 14px;
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
td{
  p{
    font-size: 18px;
    font-weight: 600;
    color: rgb(61, 66, 66);
    border-radius: 5px;
    padding: 3px 5px;
    background: rgba(215, 209, 209, 0.1882352941);
  }
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
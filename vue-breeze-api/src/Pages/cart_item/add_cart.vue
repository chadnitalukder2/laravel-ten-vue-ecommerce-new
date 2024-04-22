<script setup>
import { useNotification } from "@kyvg/vue3-notification";
const { notify }  = useNotification();

import Modal from "../../components/global/Modal.vue";

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
import { useRoute } from 'vue-router'
const route = useRoute()

//----------------------------------------------------
const orderItem = ref([]);
const order = ref({
  selectedItems: [],
  sub_total: 0,
  total: 0
})
const deleteVisibleId = ref(null);
//---------------------------------------------------
onMounted(async () => {
    getOrderItem();
});
//----------------------------

const getOrderItem = async () => {
    let response = await axios.get("/api/get_OrderItem");
    orderItem.value = response.data.orderItem;
    subTotal();
    // total();
};
//------------------------------------------
const updateLineTotal = (item) => {
  item.line_total = item.quantity * item.product.product_price;
  subTotal();
  // total();
}
//------------------------------------------
const subTotal = () =>{
  let result = 0;
  for (let i = 0; i < orderItem.value.length; i++) {
    if(order.value.selectedItems.includes(orderItem.value[i].id)){
     result += orderItem.value[i].line_total;
    }
  }
  // console.log({order}, result)
  order.value.sub_total = result;
  // console.log({order}, order.value.sub_total)
  let totalValue = order.value.sub_total + 50 - 5;
 
  order.value.total = totalValue;
}
//------------------------------------------
// const total = () => {
//   console.log('total', order.value.sub_total);
//   let totalValue = order.value.sub_total + 50 - 5;
 
//   order.value.total = totalValue;
// }
//------------------------------------------
const deleteOrderItem = (id) => {
    axios.get(`/api/delete_OrderItem/${id}`).then( () => {
      notify({
        title: "Order Item Deleted",
        type: "success",
      });
      getOrderItem();
    })
}
//---------------------------------------------------
const openModalDelete = (id) => {
    deleteVisibleId.value = id;
};
const closeModalDelete = () => {
    deleteVisibleId.value =null;
};

//-------------------------------------
const addOrders = async () => {
  let data = {
    name: order.value.name,
    email: order.value.email,
    address: order.value.address,
    phone: order.value.phone, 
    total_amount: order.value.total,
    order_items_id: order.value.selectedItems
  }

  await axios.post("/api/add_orders", data).then( (res) => {
    if(res.status == 201){
      notify({
        title: "Order Placed Successfully",
        type: "success",
      });
      let parse_url = JSON.parse(res.data.payment_redirect_url);
      if (parse_url.status == "success") {
        window.location.replace(parse_url.data);
      }
    } else {
      notify({
        title: "Order Placed Failed",
        text: res.data.message,
        type: "error",
      });
    }
  }).catch( (err) => {
    notify({
      title: "Order Placed Failed",
      text: err.response.data.message,
      type: "error",
    });
  })
  order.value = [];
}
</script>

<template>
  <div class="container"> 
    <div class="table" style="padding-bottom: 85px">
      <table>
        <tr>
          <th></th>
          <th>Image</th>
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Line Total</th>
          <th>Action</th>
        </tr>
                
        <tr v-for="item in orderItem" :key="item.id">
          <Modal :show="deleteVisibleId === item.id" @close="closeModalDelete">
                    <div id="myModal" style="text-align: center;">
                        <h4 style="margin-top: 20px; font-size: 26px; color: #636363; font-weight: 500;">Are you sure?</h4>
                        <div class="modal-body">
                            <p style="font-size: 14px; color: #999999;">Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal_footer" style="padding: 20px;" >
                            <!-- <button @close="closeModalDelete" type="button" class="secondary" >Cancel</button> -->
                            <button @click="deleteOrderItem(item.id)" type="button" style="background: #f15e5e;">Delete</button>
                        </div>   
                    </div>  
           </Modal>
          <td>
            <input @change="subTotal()" type="checkbox" :name="`order-item-${item.id}`" :id="item.id" v-model="order.selectedItems" :value="item.id">
          </td>
          <td style="width: 120px; height: 100px"> 
            <img :src="item.product.product_img" style="width: 100%; height: 100%" >
          </td>
          <td>{{ item.product.product_name }}</td>
          <td>{{ item.product.product_price }}</td>
          <td>
            <input type="number" v-model="item.quantity" @change="updateLineTotal(item)">
                    
          </td>
          <td>${{ item.line_total }}</td>
          <td @click="openModalDelete(item.id)"><i class="fa-solid fa-xmark" style="    background: #D1EAE4; padding: 5px 8px;"></i></td>
        </tr>

    
      </table>
    </div>
    <!-- ============================= -->
    <div class="order-wrapper" style="display: flex;">
      <div class="cart">
        <div class="cart_total">
          <h3>Cart Totals</h3>
          <p class="d-flex">
            <span>Subtotal</span>
            <span>${{ order.sub_total }}</span>
          </p>
          <p class="d-flex">
            <span>Delivery</span>
            <span>$50.00</span>
          </p>
          <p>
            <span>Discount</span>
            <span>$5.00</span>
          </p>
          <hr style="background: rgba(255, 255, 255, 0.1)" />
          <p>
            <span>TOTAL</span>
            <span style="color: #000000; font-weight: 600">${{ order.total }}</span>
          </p>
        </div>
      </div>
      <div class="order-form">
        <h2>Shipping Address</h2>
        <form @submit.prevent="addOrders">
          <div class="input_box" >
            <label ><b>Write your name : </b></label><br>
            <input v-model="order.name" type="text" name="name" placeholder="name" >
          </div>

          <div class="input_box" >
            <label ><b>Write your email : </b></label><br>
            <input v-model="order.email"  type="email" name="message" placeholder="email" >
          </div>

          <div class="input_box" >
            <label for="message"><b>Write your phone number : </b></label><br>
            <input v-model="order.phone"  type="number" name="phone" placeholder="number" >
          </div>
            
          <div class="input_box" >
            <label ><b> Write your  address : </b></label><br>
            <input v-model="order.address"  type="text" name="message" placeholder="address" >
          </div>
          
            <input type="submit" class="check_out" value="Proceed to Checkout">
        </form>
      </div>
    </div>
   
    <!-- ================================= -->

  
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
.order-wrapper{
  gap: 20px;
  justify-content: space-between;
  .cart{
  flex-basis: 35%;
  

  .cart_total {
  padding: 20px;
  text-align: center;
  border: 1px solid rgba(0, 0, 0, 0.05);
  border-radius: 8px;
  h3 {
    font-size: 18px;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
    font-weight: 700;
  }
  p {
    display: flex;
    justify-content: space-between;
    span {
      font-family: "Open Sans", Arial, sans-serif;
      font-size: 15px;
      line-height: 1.8;
      font-weight: 400;
      color: gray;
    }
  }
  hr {
    background: rgba(255, 255, 255, 0.1);
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
  }
}
}
.order-form{
        flex-basis: 50%;
        padding: 20px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        .input_box{
          text-align: left;
          padding-top: 20px;
        }
        label{
          text-align: left;
        }
        input{
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
          &:focus-visible{
            outline: none;
            border: 1px solid #4ed7b7;
          }
        }
        .check_out{
          border-radius: 8px;
          cursor: pointer;
          background: #a4ddcf;
          font-size: 16px;
          margin-top: 20px;
          padding: 14px;
          border: 1px solid #D1EAE4;
          &:hover{
                  transition: all 0.2s ease;
                  background: white;
                  border: 1px solid #a4ddcf;
              }
}
}
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

.review-template {
        // border-right: 1px solid gray;
        width: 50%;
        min-width: 400px;

        .adrm_review_temp_one {
            display: flex;
            gap: 30px;
            width: calc(100% - 40px);
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgb(240, 236, 236);
            background: #9e9e9e1a;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;

            @media screen and (max-width: 768px) {
                padding: 4px;
                gap: 10px;
            }

            .adrm_review_temp_one_avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                overflow: hidden;

                img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            }

            .adrm_review_temp_one_content {
                width: calc(100% - 100px);

                .adrm_review_temp_one_content_header {
                    display: flex;
                    gap: 10px;
                    justify-content: space-between;

                    .date {
                        font-size: 14px;
                        font-weight: 600;
                        color: black;
                    }

                    h3, p {
                        margin: 0px;
                    }

                    .adrm_review_temp_one_content_header_name {
                        font-size: 20px;
                        font-weight: 600;
                        color: black;
                    }

                    .adrm_review_temp_one_content_header_rating {
                        display: flex;
                        gap: 5px;
                    }
                    .adrm-star-rating {
                        span {
                            color: gray;
                            font-size: 18px;
                        }
                        .active {
                            color: #f1c40f;
                        }
                    }

                    @media screen and (max-width: 768px) {
                        display: block;

                        .date {
                            margin: 0;
                        }

                        .adrm_review_temp_one_content_header_name {
                            margin: 0;
                        }
                    }
                }

                .adrm_review_temp_one_content_body {
                    .review {
                        color: black;
                        margin-bottom: 10px;
                    }

                    @media screen and (max-width: 768px) {
                        .review {
                            margin-top: 0px;
                        }
                    }
                }
            }
        }
    }

</style>

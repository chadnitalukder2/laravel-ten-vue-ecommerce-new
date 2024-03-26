<script setup>
import '@fortawesome/fontawesome-free/css/all.css';
import {
    useNotification
} from "@kyvg/vue3-notification";
const {
    notify
} = useNotification();
import Modal from "../../../components/global/Modal.vue";

import {
    useRouter
} from "vue-router";
const router = useRouter();
import {
    ref,
    onMounted
} from "vue";
import axios from "axios";
import {
    useRoute
} from "vue-router";
const route = useRoute();
//---------------------------------------------------
const orderItems = ref([]);
const modalVisibleId = ref(null);
const deleteVisibleId = ref(null);
//---------------------------------------------------
onMounted(async () => {
    getOrderItems();
});
//---------------------------------------------------
const getOrderItems = async () => {
    let response = await axios.get("/api/get_all_Order");
    orderItems.value = response.data.orderItems;
    // console.log("response", response.data);
};
//---------------------------------------------------
const deleteOrder = (id) => {
    axios.get(`/api/delete_order_item/${id}`).then(() => {
        notify({
            title: "Order Item Deleted",
            type: "success",
        });
        getOrderItems();
    });
};

//---------------------------------------------------
const openModal = (id) => {
    modalVisibleId.value = id;
};
const closeModal = () => {
    modalVisibleId.value = null;
};
const openModalDelete = (id) => {
    deleteVisibleId.value = id;
};
const closeModalDelete = () => {
    deleteVisibleId.value =null;
};


//---------------------------------------------------
const updateStatus = async (item) => {

    let data = {
        'order_status': item.order_status,
        'payment_status': item.payment_status,
    }

    await axios.post(`/api/update_order_status/${item.id}`, data).then(() => {
        closeModal();
    });
}
//---------------------------------
</script>

<template>
<div class="container">
    <div class="table-box">
        <h1>Order Items</h1>
        <table id="customers">
            <tr>
                <th># ID</th>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
            <tbody v-for="item in orderItems" :key="item.id">
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
                    <td style=""># {{ item.id }}</td>
                    <td>{{ item.user_id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.address }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.total_amount }}</td>
                    <td>{{ item.order_status }}</td>
                    <td>{{ item.payment_status }}</td>
                    <td>
                        <span @click="openModalDelete(item.id)" class="delete">
                            <i class="fa-solid fa-trash"></i>
                        </span>
                        <span class="view">
                            <router-link :to="{ name: 'view_order_details', params: { id: item.id } }"><i class="fa-solid fa-eye"></i></router-link>
                        </span>
                        <span @click="openModal(item.id)" class="edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                    </td>

                    <Modal :show="modalVisibleId === item.id" @close="closeModal">
                        <h2 style="text-align: center; font-size: 22px; color: #444;">Upadte Status</h2>
                        <form @submit.prevent="updateStatus(item)">

                            <div class="container">
                                <div>
                                    <label><b>Order Status</b></label>
                                    <select v-model="item.order_status">
                                        <option disabled>orders Status </option>
                                        <option>Pending</option>
                                        <option>Processing</option>
                                        <option>Received</option>
                                        <option>Delivery</option>
                                    </select>
                                </div>

                                <div>
                                    <label><b>Payment Status</b></label>
                                    <select v-model="item.payment_status">
                                        <option disabled>payment status </option>
                                        <option>Unpaid</option>
                                        <option>Paid</option>
                                        <option>Refund</option>
                                    </select>
                                </div>
                                <br />
                                <button type="submit" style="cursor: pointer;">Update Status</button>
                            </div>
                        </form>
                    </Modal>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>

<style lang="scss" scoped>
h1 {
   margin-top:0px ;
    font-size: 25px;
    color: #444;
}
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

form {
    border: 1px solid #f1f1f1;
    margin: 0 auto;
    width: 60%;
    margin-top: 15px;
    border-radius: 8px;
    padding: 20px;

    button {
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #f1f1f1;
        background: #189877;
        color: white;
    }
}

select {
    width: 100%;
    padding: 12px 20px;
    margin: 12px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    border-radius: 8px;
}



td {
    span{
        cursor: pointer;
        color: #444;

        a {
            text-decoration: none;
            color: #444;
        }
    }
    .delete{
        padding-right: 8px;
        i{
           &:hover{
            color: red;
           }
        }
    }
    .view{
        padding-right: 8px;
        a{
           &:hover{
            color: rgb(53, 53, 239);
           }
        }
    }
    .edit{
        i{
           &:hover{
            color: #13c3c3;
           }
        }
    }
}

.container {
    width: 100%;
}

table {
    border-radius: 6px;
    overflow: hidden;
}

.table-box {
    padding: 50px;
    border-radius: 8px;

    .btn {
        text-align: right;
        padding-bottom: 25px;

        button {
            padding: 10px 20px;
            border: 1px solid #ddd;
            background: #189877;
            border-radius: 6px;
            cursor: pointer;

            a {
                text-decoration: none;
                font-size: 16px;
                font-weight: 500;
                color: #fff;
            }
        }
    }
}

#customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td,
#customers th {
    border: 1px solid #f3ededad;
    padding: 15px 10px;
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

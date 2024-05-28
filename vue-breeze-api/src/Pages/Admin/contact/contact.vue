<script setup>
import Modal from "../../../components/global/Modal.vue";

import { useNotification } from "@kyvg/vue3-notification";
const { notify } = useNotification();

import axios from "axios";
import { ref , onMounted} from "vue";
import { useRouter } from "vue-router";
const router = useRouter();

const contacts = ref([]);
const deleteVisibleId = ref(null);

onMounted(async () => {
  getContact();
});

const getContact = async () => {
  let response = await axios.get("/api/get_contact");
    contacts.value = response.data.contacts;
};

const deleteContact = (id) => {
  axios.get(`/api/delete_contact/${id}`).then(() => {
     notify({
      title: "Message Item Deleted",
      type: "success",
    });
    getContact();
  });
};
//---------------------------------------------------
const openModalDelete = (id) => {
    deleteVisibleId.value = id;
};
const closeModalDelete = () => {
    deleteVisibleId.value =null;
};
</script>

<template>
  <div class="container" style="flex: auto;">
    <div class="table-box" >
      <h1>All Contact Data</h1>
      <table id="customers">
        <tr>
          <th>#ID</th>
          <th>Name </th>
          <th>Email </th>
          <th>Phone </th>
          <th>Address</th>
          <th>Message </th>
          <th>Action</th>
        </tr>
        <tbody  v-for="item in contacts" :key="item.id">
           <Modal :show="deleteVisibleId === item.id" @close="closeModalDelete">
                    <div id="myModal" style="text-align: center;">
                        <h4 style="margin-top: 20px; font-size: 26px; color: #636363; font-weight: 500;">Are you sure?</h4>
                        <div class="modal-body">
                            <p style="font-size: 14px; color: #999999;">Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal_footer" style="padding: 20px;" >
                            <!-- <button @close="closeModalDelete" type="button" class="secondary" >Cancel</button> -->
                            <button @click="deleteContact(item.id)" type="button" style="background: #f15e5e;">Delete</button>
                        </div>   
                    </div>  
           </Modal>
          <tr>
            <td>{{ item.id }}</td>
            <td> {{ item.name }}</td>
            <td> {{ item.email }}</td>
            <td> {{ item.phone }}</td>
            <td> {{ item.address }}</td>
            <td> {{ item.message }}</td>
            <td>
            <span  @click="openModalDelete(item.id)" style="background: red; margin-right: 5px; cursor: pointer;">Delete</span>
            </td>
          </tr>
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
h1 {
  margin-top: 0px;
  margin-bottom: 20px;
  font-size: 24px;
  color: #444;
}
table {
  border-radius: 6px;
  overflow: hidden;
}

.container {
  width: 100%;
  background: #f5f5f780;
}
.table-box {
  padding: 50px;
  border-radius: 8px;

  .btn {
    text-align: right;
    padding-bottom: 10px;
  
      a {
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        border: 1px solid #ff6b00;
        background: #ff6b00;
        transition: all .3s;
      }
      a:hover{
         color: #ff6b00;
         background: #fff;
         border: 1px solid #ff6b00;
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
  border: 1px solid rgba(0, 0, 0, 0.085);
  padding: 10px 10px;
  text-align: left;
}

#customers tr:nth-child(even) {
  background-color: #f2f2f2;
}

#customers th {
  padding-top: 8px;
  padding-bottom: 8px;
  text-align: left;
  background-color: rgb(237 236 236 / 68%);
  color: #444;
}
td{
span, a{
        text-decoration: none;
        background: skyblue;
        padding: 6px 12px;
        border-radius: 6px;
        color: #0e0d0d;
        font-weight: 600;
    }
}
</style>

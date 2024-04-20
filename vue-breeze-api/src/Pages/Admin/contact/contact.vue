<script setup>
import { useNotification } from "@kyvg/vue3-notification";
const { notify } = useNotification();
import Modal from "../../../components/global/Modal.vue";

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
//---------------------------------------------------
const user = ref([]);
const deleteVisibleId = ref(null);
//---------------------------------------------------
onMounted(async () => {
  getUser();
});
//---------------------------------------------------
const getUser = async () => {
  let response = await axios.get("/api/get_user");
  user.value = response.data.user;
  // console.log("response", response.data.user);
};
//---------------------------------------------------
const deleteUser = (id) => {
  axios.get(`/api/delete_user/${id}`).then(() => {
    notify({
      title: "User Deleted",
      type: "success",
    });
    getUser();
  });
};
//---------------------------------------------------
const openModalDelete = (id) => {
    deleteVisibleId.value = id;
};
const closeModalDelete = () => {
    deleteVisibleId.value =null;
};
//--------------------------------------------
</script>

<template>
  <div class="container">
    <div class="table-box">
      <h1>All User</h1>
      <table id="customers">
        <tr>
          <th># ID</th>
          <th>User Name</th>
          <th>User Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
        <tbody v-for="item in user" :key="item.id">
          <Modal :show="deleteVisibleId === item.id" @close="closeModalDelete">
                    <div id="myModal" style="text-align: center;">
                        <h4 style="margin-top: 20px; font-size: 26px; color: #636363; font-weight: 500;">Are you sure?</h4>
                        <div class="modal-body">
                            <p style="font-size: 14px; color: #999999;">Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal_footer" style="padding: 20px;" >
                            <!-- <button @close="closeModalDelete" type="button" class="secondary" >Cancel</button> -->
                            <button @click="deleteUser(item.id)" type="button" style="background: #f15e5e;">Delete</button>
                        </div>   
                    </div>  
           </Modal>
          <tr>
            <td style="color: blue">
              <router-link :to="{ name: 'edit-user', params: { id: item.id } }"
                ># {{ item.id }}
              </router-link>
            </td>
            <td>{{ item.name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.role }}</td>
            <td
            @click="openModalDelete(item.id)"
              style="color: red; cursor: pointer"
            >
              <span>Delete</span>
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
    font-size: 25px;
    color: #444;
}
table {
  border-radius: 6px;
  overflow: hidden;
}

.container {
  margin: auto;
  width: 100%;
}
.table-box {
  padding: 50px;
  border-radius: 8px;
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

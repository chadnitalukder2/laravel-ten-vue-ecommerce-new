<script setup>
import { useNotification } from "@kyvg/vue3-notification";
const { notify } = useNotification();

import Modal from "../../../components/global/Modal.vue";

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
//---------------------------------------------------
const brand = ref([]);
const deleteVisibleId = ref(null);
//---------------------------------------------------
onMounted(async () => {
  getBrand();
});
//---------------------------------------------------
const getBrand = async () => {
  let response = await axios.get("/api/get_brand");
  brand.value = response.data.brand;
};
//---------------------------------------------------
const deleteBrand = (id) => {
  axios.get(`/api/delete_brand/${id}`).then(() => {
    notify({
      title: "Brand Item Deleted",
      type: "success",
    });
    getBrand();
  });
};
//---------------------------------------------------
const getToken = async () => {
  await axios.get("sanctum/csrf-cookie");
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
      <div class="btn">
        <button>
          <router-link :to="{ name: 'add-brand' }"> Add brand </router-link>
        </button>
      </div>
      <h1>All Brand</h1>
      <table id="customers">
        <tr>
          <th># ID</th>
          <th>Brand Name</th>
          <th>Brand Image</th>
          <th>Action</th>
        </tr>
        <tbody v-for="item in brand" :key="item.id">
          <Modal :show="deleteVisibleId === item.id" @close="closeModalDelete">
                    <div id="myModal" style="text-align: center;">
                        <h4 style="margin-top: 20px; font-size: 26px; color: #636363; font-weight: 500;">Are you sure?</h4>
                        <div class="modal-body">
                            <p style="font-size: 14px; color: #999999;">Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal_footer" style="padding: 20px;" >
                            <!-- <button @close="closeModalDelete" type="button" class="secondary" >Cancel</button> -->
                            <button @click="deleteBrand(item.id)" type="button" style="background: #f15e5e;">Delete</button>
                        </div>   
                    </div>  
           </Modal>
          <tr>
            <td># {{ item.id }}</td>
            <td>{{ item.brand_name }}</td>
            <td style="width: 120px; height: 100px">
              <img :src="item.brand_img" style="width: 100%; height: 100%" />
            </td>
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
  font-size: 24px;
  color: #444;
}
table {
  border-radius: 6px;
  overflow: hidden;
}

.container {
  width: 100%;
}
.table-box {
  padding: 50px;
  border-radius: 8px;

  .btn {
    text-align: right;
    padding-bottom: 10px;
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

<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
import { useRoute } from "vue-router";
const route = useRoute();
//---------------------------------------------------
const form = ref({});
//---------------------------------------------------
onMounted(async () => {
  editUser();
});

watch(() => route.params.id, () => {
  editUser();
});

//---------------------------------------------------
const editUser = async () => {
  const id = route.params.id;
  console.log("route id:", id);
  let response = await axios.get(`/api/edit_user/${id}`);
  form.value = response.data.user;
};

//---------------------------------------------------
const updateUser = async () => {
  let id = route.params.id;
  let data = {
    name: form.value.name,
    email: form.value.email,
    role: form.value.role,
  };

  let response = await axios.post(`/api/update_user/${id}`, data);
  console.log('Response:', response);
  router.push("/all-user");
};
</script>

<template>
  <form @submit.prevent="updateUser" method="post">
    <h1>Edit User Details</h1>

    <div class="container">
      <label for="uname"><b>User Name</b></label>
      <input
        v-model="form.name"
        type="text"
        placeholder="user name"
        name="uname"
        required
      />

      <label for="psw"><b>User Name</b></label>
      <input
        v-model="form.email"
        type="email"
        placeholder="user email"
        name="psw"
        required
      />
      <label for="psw"><b>User Role</b></label>
      <input
        v-model="form.role"
        type="text"
        placeholder="user role"
        name="role" 
        required
      />
      

      <button type="submit">Update User</button>
    </div>
  </form>
</template>

<style lang="scss" scoped>
h1 {
  text-align: center;
  font-size: 25px;
  color: #444;
}
form {
  border: 1px solid #f1f1f1;
  margin: 0 auto;
  height: 100%; 
  width: 50%;
  margin-top: 100px;
  border-radius: 8px;
  padding: 20px;
}

.form-footer {
  background-color: rgb(241, 241, 241);
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-radius: 8px;
  padding: 4px 16px;
  margin: 0px 12px;
}

input[type="text"],
input[type="password"],
input[type="email"] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  border-radius: 8px;
}

button {
  background-color: #04aa6d;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  border-radius: 8px;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }

  .cancelbtn {
    width: 100%;
  }
}
</style>

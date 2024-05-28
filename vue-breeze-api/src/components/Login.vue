<script setup>
import { useNotification } from "@kyvg/vue3-notification";
const { notify } = useNotification();

import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();
const errors = ref(null);
//---------------------------------
const form = ref({
  email: "",
  password: "",
});

const validation = ref({});
//---------------------------------------
const clearValidationMessage = (field) => {
  setTimeout(() => {
    validation.value[field] = '';
  }, 5000); // Set the timeout duration in milliseconds (e.g., 5000 for 5 seconds)
}
//----------------------------------------------
const getToken = async () => {
  await axios.get("sanctum/csrf-cookie");
}
//-------------------------------------------------
const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
//----------------------------------------------
const handleLogin = async () => {

  if (form.value.email === "" || !validateEmail(form.value.email)) {
    validation.value.email = "Email is required and must be a valid email address";
    clearValidationMessage('email');
  }
  if (form.value.password === "" || form.value.password.length < 8) {
    validation.value.password = "Password is required and must be at least 8 characters long";
    clearValidationMessage('password');
  } else {
    await getToken();
    await handleApiRequest();
  }
 
};
//---------------------------------------------
const handleApiRequest = async () => {
 
  try {
    let response = await axios.post("/login", {
    email: form.value.email,
    password: form.value.password,
  }).then((res) => {
    notify({
      title: "Login Successful ",
      type: "success",
    });
    localStorage.setItem("password", form.value.password);
    localStorage.setItem("email", form.value.email);
    localStorage.setItem("", form.value.email);

     router.push('/').then(() => {
    // Force a full page reload
      location.reload();
    });
  })
  } catch (error) {
    console.error(error.response.data);
    // Handle login error
    errors.value = error.response.data.message || 'An error occurred during login.';
    // Clear previous validation messages
    validation.value.email = ''; 
    validation.value.password = '';
  }
};
</script>


<template>
 
  <form @submit.prevent="handleLogin" method="post" style="width: 50%;">
  
    <div class="container">
      <label for="uname"><b>User Email</b></label>
      <input  v-model="form.email"  type="text" placeholder="Enter User Email" name="uname" >
      <p style="margin: 0px; color: red; font-size: 14px;">{{ validation.email }}</p><br>

    
      <label for="psw"><b>Password</b></label>
      <input v-model="form.password" type="password" placeholder="Enter Password" name="psw" >
      <p style="margin: 0px; color: red; font-size: 14px;" >{{ validation.password }}</p><br>

      <label style="margin: 0px; color: red; font-size: 14px;" >{{ errors }}</label>
      <button type="submit">Login</button>

    </div>

    <div class="form-footer" style="background-color:#f1f1f1">
      <router-link to="/forgot-password" class="">Forgot Password?</router-link>
      <p class="text-base text-[#adadad]"> Not a member yet?
          <router-link to="/register" class=""> register </router-link>
      </p>
    </div>
  </form>

</template>

<style lang="scss" scoped>
form {
  border: 1px solid #f1f1f1;
  margin: 0 auto;
  /* height: 100vh; */
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

input[type=text],
input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  border-radius: 8px;
}

button {
  background-color: #04AA6D;
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

<script setup>
import { useNotification } from "@kyvg/vue3-notification";
const { notify } = useNotification();

  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  const router = useRouter();
  //-----------------------------------
  const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
  });
  const validation = ref({});
  //---------------------------------------------
  const clearValidationMessage = (field) => {
  setTimeout(() => {
    validation.value[field] = '';
  }, 5000); // Set the timeout duration in milliseconds (e.g., 5000 for 5 seconds)
}
  //---------------------------------------------------
  const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
  //---------------------------------------
  const handleRegister = async () => {
if(form.value.name === ''){
  validation.value.name = "Name is required";
  clearValidationMessage('name');
}
if (form.value.email === "" || !validateEmail(form.value.email)) {
  validation.value.email = "Email is required and must be a valid email address";
  clearValidationMessage('email');
}
if (form.value.password === "" || form.value.password.length < 6) {
  validation.value.password = "Password is required and must be at least 6 characters long";
  clearValidationMessage('password');
} 
if(form.value.password_confirmation === ""){
      validation.value.password_confirmation = "Password confirmation is required";
      clearValidationMessage('password_confirmation');
    }
    if (form.value.password_confirmation !== form.value.password) {
      validation.value.password_confirmation = "The password confirmation does not match.";
      clearValidationMessage('password_confirmation')
    } 
else {
  await handleApiRequest();
}

};
  //------------------------------------------
  const handleApiRequest = async () => {
    await axios.post('/register', {
      name:form.value.name,
      email:form.value.email,
      password:form.value.password,
      password_confirmation:form.value.password_confirmation
    }).then(() => {
      notify({
      title: "Ragistation Successful ",
      type: "success",
    });
    })
    router.push("/login");
  }
  //-----------------------------------------
</script>

<template>
 
<div>
  
  <form @submit.prevent="handleRegister" method="post">
   
    <div class="container">

      <label for="uname"><b>Username</b></label>
      <input  v-model="form.name"  type="text" placeholder="Enter Username" name="uname" >
      <p style="margin: 0px; color: red; font-size: 14px;" >{{ validation.name }}</p><br>

      <label for="uname"><b>Email</b></label>
      <input  v-model="form.email"  type="text" placeholder="Enter Email" name="uname" >
      <p style="margin: 0px; color: red; font-size: 14px;">{{ validation.email }}</p><br>

      <label for="uname"><b>Password</b></label>
      <input  v-model="form.password"  type="password" placeholder="Enter Password" name="uname" >
      <p style="margin: 0px; color: red; font-size: 14px;">{{ validation.password }}</p><br>


      <label for="psw"><b> Password Confirmation</b></label>
      <input v-model="form.password_confirmation" type="password" placeholder="Enter Password Confirmation" name="psw" >
      <p style="margin: 0px; color: red; font-size: 14px;">{{ validation.password_confirmation }}</p><br>

      <button type="submit">Register</button>

    </div>
    <p class="sign">
      <router-link to="/login">
        Login
      </router-link>
    </p>
  </form>
   

 </div>
</template>



<style lang="scss" scoped>
form {
  border: 1px solid #f1f1f1;
  margin: 0 auto;
  /* height: 100vh; */
  margin-top: 50px;
  margin-bottom: 50px;
  border-radius: 8px;
  padding: 20px;
  width: 50%;
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

.sign{
  width: 93%;
    background: #297e7e;
    padding: 10px;
    text-align: center;
    font-size: 18px;
    margin: 0px 0px 0px 13px;
    border-radius: 6px;
    a{
      text-decoration: none;
      color: #fff
    }
}
</style>


<script setup>
import axios from 'axios';
import { ref } from "vue";

const email = ref("");
const validation = ref({
  email : ''
});

const clearValidationMessage = (field) => {
  setTimeout(() => {
    validation.value[field] = '';
  }, 5000);
}

const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

const handleForgotPassword = async () => {
  if (email.value === "" || !validateEmail(email.value)) {
    validation.value.email = "Email is required and must be a valid email address";
    clearValidationMessage('email');
  } else {
    await handleApiRequest();
  }
};

const handleApiRequest = async () => {
  try {
    await axios.post("/forgot-password", {
      email: email.value,
    }).then((res) => {
        if(res.status == 200){
          email.value = '';
        }
    })
  
  } catch (error) {
    // Handle error if necessary
    console.error(error);
  }
}
</script>

<template>
  <form @submit.prevent="handleForgotPassword" method="post" style="width: 50%;">
    <div class="container">
      <label for="email"><b>Enter Your Email</b></label>
      <input v-model="email" type="email" placeholder="Enter email">
      <p style="margin: 0px; color: red; font-size: 14px;">{{ validation.email }}</p><br>
      <button type="submit">Submit</button>
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
  
  input[type=email] {
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
  

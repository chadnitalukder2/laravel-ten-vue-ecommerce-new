<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();

let showError = ref();
const brandInput = ref([]);
const image = [];

//---------------------------------------------------
const handleFileChange = async (event) => {
  image.value = event.target.files[0];
};
//-------------------------------------------------

//---------------------------------------------------
const addBrand = async () => {
  if (!brandInput.value.brand_name) {
    showError.value = true;
    showError.value = "Brand name is required";
    console.log("hi");
    return;
  }

  const formData = new FormData();
  formData.append("brand_name", brandInput.value.brand_name);
  formData.append("brand_img", image.value);

  await axios.post("/api/add_brand", formData).then(() => {
    router.push("/all-brand");
    brandInput.value = [];
    image.value = [];
  });
  //   console.log('response', response.data);
};
</script>

<template>
  <div style="width: 100%">
    <form @submit.prevent="addBrand" enctype="multipart/form-data">
      <h1>Add Brand Item</h1>
      <div class="container">
        <label for="uname"><b>Brand Name</b></label>
        <input
          v-model="brandInput.brand_name"
          type="text"
          placeholder="Enter User Email"
          name="uname"
        />
        <p style="margin: 0px; color: red; font-size: 14px">{{ showError }}</p>
        <br />

        <label for="psw"><b>Brand Image</b></label>
        <input
          @change="handleFileChange"
          type="file"
          placeholder="Product Image"
          name="psw"
        />

        <button type="submit">Add Brand</button>
      </div>
    </form>
  </div>
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
  width: 60%;
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
input[type="file"] {
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

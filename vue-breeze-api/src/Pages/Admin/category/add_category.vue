<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();

let showError = ref();
const categoryInput = ref([]);
const image = [];

const handleFileChange = async (event) => {
  image.value = event.target.files[0];
};

//---------------------------------------------------
const addCategory = async () => {

  if (!categoryInput.value.category_name ) {

    showError.value = 'Category name is required';
    console.log("hi");
    return;
  }

  // let data = {
  //     category_name: categoryInput.value.category_name,
  // };
  const formData = new FormData();
  formData.append("category_name", categoryInput.value.category_name);
  formData.append("category_img", image.value);

  await axios.post("/api/add_category", formData).then((response) => {
    if (response.status == 200) {
      router.push("/all-category");
      categoryInput.value = [];
      image.value = [];
    }
  });
};
</script>

<template>
  <div style="width: 100%">
    <form @submit.prevent="addCategory" enctype="multipart/form-data">
      <h1>Add Category Item</h1>
      <div class="container">
        <label for="uname"><b>Category Name</b></label>
        <input
          v-model="categoryInput.category_name"
          type="text"
          placeholder="category name "
          name="uname"
        />
        <p style="margin: 0px; color: red; font-size: 14px;" >{{ showError }}</p><br>

        <label for="psw"><b>Category Image</b></label>
        <input
          @change="handleFileChange"
          type="file"
          placeholder="category Image"
          name="psw"
          
        />

        <button type="submit">Add Category</button>
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

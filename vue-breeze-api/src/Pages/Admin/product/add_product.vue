<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
//---------------------------------------------------
const category = ref([]);
const brand = ref([]);
const form = ref([]);
const image = [];

const product_colors = ["Red", "Blue", "Green", "Yellow", "Black", "White"];
const product_sizes = ["Small", "Medium", "Large", "XL"];

const selectedSizes = ref([]);
const selectedColors = ref([]);
//---------------------------------------------------
onMounted(async () => {
  getCategory();
  getBrand();
});
//---------------------------------------------------
const getCategory = async () => {
  let response = await axios.get("/api/get_category");
  category.value = response.data.category;
  // console.log("response", category.value);
};
//---------------------------------------------------
const getBrand = async () => {
  let response = await axios.get("/api/get_brand");
  brand.value = response.data.brand;
  // console.log("response", category.value);
};
//---------------------------------------------------
const handleFileChange = async (event) => {
  image.value = event.target.files[0];
};
//---------------------------------------------------
const addProduct = async () => {
  const formData = new FormData();
  formData.append("product_name", form.value.product_name);
  formData.append("product_price", form.value.product_price);
  formData.append("product_quantity", form.value.product_quantity);
  formData.append("category_id", form.value.category_id);
  formData.append("brand_id", form.value.brand_id);
  formData.append("short_description", form.value.short_description);
  formData.append("product_details", form.value.product_details);
  formData.append("product_colors", JSON.stringify(selectedColors.value));
  formData.append("product_sizes", JSON.stringify(selectedSizes.value));
  formData.append("product_img", image.value);

  console.log({ formData });
  let response = await axios.post("/api/add_products", formData);
  router.push("/Admin/all-product");
};
</script>

<template>
  <div>
    <form @submit.prevent="addProduct" enctype="multipart/form-data">
      <h1>Add Product Item</h1>
      <div class="container">
        <label for="uname"><b>Product Name</b></label>
        <input
          v-model="form.product_name"
          type="text"
          placeholder="Product Name"
          name="uname"
          required
        />

        <label for="uname"><b>Product Price</b></label>
        <input
          v-model="form.product_price"
          type="number"
          placeholder="Product Price"
          name="uname"
          required
        />

        <label for="uname"><b>Product Quantity</b></label>
        <input
          v-model="form.product_quantity"
          type="number"
          placeholder="Product Quantity"
          name="uname"
          required
        />

        <div>
          <label for="uname"><b>Catagory Name</b></label>
          <select v-model="form.category_id">
            <option disabled>Select category</option>
            <option v-for="item in category" :key="item.id" :value="item.id">
              {{ item.category_name }}
            </option>
          </select>
        </div>

        <div>
          <label for="uname"><b>Brand Name</b></label>
          <select v-model="form.brand_id">
            <option disabled>Select brand</option>
            <option v-for="item in brand" :key="item.id" :value="item.id">
              {{ item.brand_name }}
            </option>
          </select>
        </div>
        <div class="input_wrapper">
          <label for="uname"><b>Product Sizes</b></label>
          <div v-for="size in product_sizes" :key="size">
            <input
              type="checkbox"
              :name="size"
              :value="size"
              v-model="selectedSizes"
            />
            {{ size }}
          </div>
        </div>
        <div class="input_wrapper">
          <label for="uname"><b>Product Colors</b></label>
          <div v-for="color in product_colors" :key="color">
            <input
              type="checkbox"
              :name="color"
              :value="color"
              v-model="selectedColors"
            />
            {{ color }}
          </div>
        </div>

        <label for="psw"><b>Product Image</b></label>
        <input
          @change="handleFileChange"
          type="file"
          placeholder="Product Image"
          name="psw"
          required
        />

        <label for="uname"><b>Product Short Description</b></label>
        <textarea v-model="form.short_description" type="text" placeholder="">
                        bccnjn hbdnund
        </textarea>

        <label for="uname"><b>Product Details</b></label>
        <textarea v-model="form.product_details" type="text" placeholder="">
                        bccnjn hbdnund
        </textarea
        ><br /><br />
        <button type="submit">Add Product</button>
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
input[type="file"],
input[type="number"],
select,
textarea,
.input_wrapper {
  width: 100%;
  padding: 12px 20px;
  margin: 12px 0;
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

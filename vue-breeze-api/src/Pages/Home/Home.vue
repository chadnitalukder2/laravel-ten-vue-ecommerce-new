
<script setup>
import Hero from './Hero.vue'
import Card from "./Product_card.vue";
import Brand_card from './Brand_card.vue';
import Category_card from './Category_card.vue';

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();

//============================================
const products = ref([]);
const user_id = ref([]);

onMounted(async () => {
  getProduct();
});

const getProduct = async () => {
  let response = await axios.get("/api/get_product");
  products.value = response.data.products;
  user_id.value = response.data
  // console.log("responseID", user_id.value);
};
//=====================================
const category = ref([]);
//---------------------------------------------------
onMounted(async () => {
  getCategory();
});
//---------------------------------------------------

//---------------------------------------------------
const getCategory = async () => {
  let response = await axios.get("/api/get_category");
  category.value = response.data.category;
  // console.log("response", category.value);
};
//======================================================
const brand = ref([]);
//---------------------------------------------------
onMounted(async () => {
  getBrand();
});
//---------------------------------------------------
const getBrand = async () => {
  let response = await axios.get("/api/get_brand");
  brand.value = response.data.brand;
  // console.log("response", brand.value);
};
//=====================================
</script>

<template>
 <!-- #fdebcb -->
 <div class="container" >
    <Hero />
    <div style="  background: #f0f8fc;  padding-top: 15px;">
        <h4 class="product-title">CATEGORY </h4>
        <hr style="width: 12%;   border: 1px solid #009688;">
        <div class="product-wrapper">
            <Category_card v-for="category in category.slice(0, 5)" :key="category.id" :category="category"/>
        </div>
    </div>

    <div>
        <h4 class="product-title" >TRENDING PRODUCTS</h4>
        <hr style="width: 22%;   border: 1px solid #009688;">
        <div class="product-wrapper">

            <Card  v-for="product in products.slice(0, 8)" :key="product.id" :product="product" :user_id="user_id"/>
        
            <button class="card_button">
              <a href="/Shop">
                View All Product
              </a></button>
        </div>
    </div>
    
    <div style="  background: #f0f8fc;  padding-top: 1px;">
        <h4 class="product-title"> BRAND </h4>
        <hr style="width: 10%;   border: 1px solid #009688;">
        <div class="product-wrapper">
            <Brand_card v-for="brand in brand.slice(0, 6) " :key="brand.id" :brand="brand"/>
        </div>
    </div>

  

 </div>
    
 
</template>

<style lang="scss" scoped>
.container{
    width: 100%;
}
.card_button{
  padding: 10px 25px;
    font-size: 15px;
    margin-top: 15px;
    border-radius: 8px;
    border: 1px solid #d1eae4;
    background: white;
    transition: all .3s;
    cursor: pointer;
    
    a{
      color: #009688;
      text-decoration: none;
      transition: all .3s;
    
    }
    &:hover{
        background:#d1eae4;
        a{
          color: #404144;
        }
      }
}
.product-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    margin-top: 28px;
    font-family: Poppins, sans-serif;
}

.product-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    padding: 50px;
    justify-content: center;
}

</style>
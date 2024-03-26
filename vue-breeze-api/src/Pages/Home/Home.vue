
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

onMounted(async () => {
  getProduct();
});

const getProduct = async () => {
  let response = await axios.get("/api/get_product");
  products.value = response.data.products;
  console.log("response", products.value);
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
  // console.log("response", category.value);
};
//=====================================
</script>

<template>
 <!-- #fdebcb -->
 <div class="container" >
    <Hero />
    <div style="  background: #f0f8fc;  padding-top: 15px;">
        <h4 class="product-title">CATEGORY </h4>
        <div class="product-wrapper">
            <Category_card v-for="category in category.slice(0, 5)" :key="category.id" :category="category"/>
        </div>
    </div>

    <div>
        <h4 class="product-title">All PRODUCTS</h4>
        <div class="product-wrapper">

            <Card  v-for="product in products.slice(0, 8)" :key="product.id" :product="product"/>
        
        </div>
    </div>
    
    <div style="  background: #f0f8fc;  padding-top: 1px;">
        <h4 class="product-title"> BRAND </h4>
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
.product-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    margin-top: 28px;
    border-bottom: 2px solid #009688;
    width: 170px;
}
.product-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    padding: 50px;
    justify-content: center;
}

</style>
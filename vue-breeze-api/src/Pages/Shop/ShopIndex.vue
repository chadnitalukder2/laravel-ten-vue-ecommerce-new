<script setup>
import Card from "../Home/Product_card.vue";

import {ref,onMounted, watch} from "vue";
import axios from "axios";
import { useRouter} from "vue-router";
const router = useRouter();

//============================================
const products = ref([]);
const category = ref([]);
const brand = ref([]);
const filter = ref({
    search: "",
    category_id: [],
    brand_id: [],
    sort: "",
});

onMounted(async () => {
    getProduct();
    getCategory();
    getBrand();
});

 // Define a watcher
 watch(filter, (newValue, oldValue) => {
      getProduct();
    }, { deep: true });

const getProduct = async () => {
    let response = await axios.get("/api/get_product", { params: { filter: filter.value } });
    products.value = response.data.products;
    // console.log("response", products.value);
};
//---------------------------------------------------
const getCategory = async () => {
  let response = await axios.get("/api/get_category");
  category.value = response.data.category;
  console.log("response", category.value);
};
//======================================================
const getBrand = async () => {
  let response = await axios.get("/api/get_brand");
  brand.value = response.data.brand;
  // console.log("response", brand.value);
};
//=====================================

//=====================================
</script>

<template>
<div>
    <div class="container">
        <div class="content" style="display: flex; justify-content: space-between; gap: 50px;">

            <div class="left_content" style="flex-basis: 20%;     padding-top: 20px;">
               <div style="display: flex; align-items: center; gap: 15px; padding-bottom: 40px;">
                <i class="fa-solid fa-bars" style="color: #0d2235; font-size: 14px;"></i>
                <h1 style="font-size: 18px; font-family: Poppins, sans-serif; font-weight: 800; color: #0d2235;">CATEGORIES</h1>
               </div>

               <div class="category_filter" v-for=" item in category" :key="item.id">
                    <div>
                        <p> {{ item.category_name }}</p>
                        <input type="checkbox" :value="item.id" v-model="filter.category_id">

                    </div>
               </div>

               <div style="display: flex; align-items: center; gap: 15px; padding-bottom: 8px; padding-top: 20px;">
                <i  class="fa-solid fa-arrow-down" style="color: #0d2235; font-size: 14px;"></i>
                <h1 style="font-size: 18px; font-family: Poppins, sans-serif; font-weight: 800; color: #0d2235;">BRAND</h1>
               </div>
               <div class="category_filter" v-for=" item in brand" :key="item.id">
                    <div>
                        <p>{{ item.brand_name }}</p>
                        <input type="checkbox" :value="item.id" v-model="filter.brand_id">
                    </div>
               </div>
            </div>
            <div class="righ_content" style="flex-basis: 80%;">

                <div class="heading">
                        
                        <div class="search_box" style="flex-basis: 100%;">
                            <input  v-model="filter.search" type="text" placeholder="Search.." name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="sort" style="flex-basis: 33%; text-align: end;">
                        <div class="sort_option" >
                            <label>Sort by:</label>
                            <select v-model="filter.sort">
                                <option value="price_low_to_high">Price, low to high</option>
                                <option value="price_high_to_low">Price, high to low</option>
                                <option value="oldest_first">Date, old to new</option>
                                <option value="newest_first">Date, new to old</option>
                                <option value="A_Z">Alphabetically, A-Z</option>
                                <option value="Z_A">Alphabetically, Z-A </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="product_card">
                <div>
                    <div class="product-wrapper">
                        <Card  v-for="product in products" :key="product.id" :product="product" />
                    </div>
                </div>
            </div>

            </div>

        </div>
      
        <div class="pagination">
            <a href="#">&laquo;</a>
            <a href="#">1</a>
            <a href="#" class="active">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
            <a href="#">6</a>
            <a href="#">&raquo;</a>
        </div>
    </div>
</div>
</template>

<style lang="scss" scoped>

.category_filter{
    div{
        display: flex;
        justify-content: space-between;
        line-height: 44px;
        background-color: #efefef;
        border-radius: 5px;
        margin: 0px;
        margin-bottom: 5px;
        padding: 0 30px;

        p{
            margin: 0px;
            font-weight: 500;
            color:#505157;
               
        }
    }
}
.container {
    width: 92% ;
    padding: 50px 50px;

    .heading {
        display: flex;
        justify-content: space-between;
         .filter_option {
                select {
                    background: #000000;
                    border-radius: 4px;
                    font-weight: 700;
                    font-size: 13px;
                    text-align: center;
                    padding: 10px;
                    text-transform: uppercase;
                    color: white;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    margin: 20px 0px;

                    &:focus-visible {
                        outline: 1px solid rgba(9, 5, 5, 0.509);
                        background: #fff;
                        color: #000000;
                    }
            }
        }

        .search_box{
            width: 100%;
            padding-top: 20px;
            input{
                padding: 10px;
                width: 80%;
                font-size: 16px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                &:focus-visible{
                    border: 1px solid #62c7af;
                    outline: none;
                }
            }
            button{
                cursor: pointer;
                font-size: 16px;
                padding: 10px;
                background: transparent;
                border: 1px solid rgba(0, 0, 0, 0.1);
            }
        }

        .sort {
          
            .sort_option {
                label {
                    font-size: 18px;
                }

                select {
                    border-radius: 4px;
                    font-weight: 400;
                    font-size: 16px;
                    text-align: center;
                    padding: 10px;
                    color: #000;
                    border: none;
                    margin: 20px 0px;

                    &:focus-visible {
                        outline: none;
                        border: none;
                    }
                }
            }
        }
    }
}

.product-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    padding-top: 30px;
    padding-bottom: 50px;
    justify-content: center;
}
.pagination {
  display: inline-block;
  margin-left: 38%;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;

}

.pagination a.active {
  background-color: #62c7af;
  color: white;
  border: 1px solid #62c7af;
}
.pagination a:hover:not(.active) {background-color: #ddd;}
</style>

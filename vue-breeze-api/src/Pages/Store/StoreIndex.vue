<script setup>
import Card from "../Home/Product_card.vue";

import {ref,onMounted} from "vue";
import axios from "axios";
import { useRouter} from "vue-router";
const router = useRouter();

//============================================
const products = ref([]);

onMounted(async () => {
    getProduct();
});

const getProduct = async () => {
    let response = await axios.get("/api/get_product");
    products.value = response.data.products;
    // console.log("response", products.value);
};


//=====================================
</script>

<template>
<div>
    <div class="container">
        <div class="heading">
         
                <div class="filter_option" style="flex-basis: 33%;text-align: start;">
                    <select>
                        <option value="0">Filter</option>
                        <option value="1">Category</option>
                        <option value="2">Brand</option>
                    </select>
                </div>
                <div class="search_box" style="flex-basis: 33%;">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
                <div class="sort" style="flex-basis: 33%; text-align: end;">
                <div class="sort_option" >
                    <label>Sort by:</label>
                    <select>
                        <option value="0">Best selling </option>
                        <option value="1">Featured</option>
                        <option value="2">Price, low to high</option>
                        <option value="3">Price, high to low</option>
                        <option value="4">Date, old to new</option>
                        <option value="5">Date, new to old</option>
                        <option value="6">Alphabetically, A-Z</option>
                        <option value="7">Alphabetically, Z-A </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="content" style="display: flex; justify-content: space-between; gap: 30px;">

            <div class="left_content" style="flex-basis: 20%;">
                <h1>jhvdcgdsc</h1>
            </div>
            <div class="righ_content" style="flex-basis: 80%;">
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
.container {
    width: 88% !important;
    padding: 50px 80px;

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
    padding-top: 50px;
    padding-bottom: 50px;
    justify-content: center;
}
.pagination {
  display: inline-block;
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

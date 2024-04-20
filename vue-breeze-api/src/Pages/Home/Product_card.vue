<script setup>
import '@fortawesome/fontawesome-free/css/all.css';
import {
    defineProps
} from "vue";

import rating from '../product_details/rating.vue';

import axios from 'axios';

import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();


const props = defineProps(["product", "user_id"]);
//--------------------------------------------------
const CartItems = ref ([]);
//-------------------------------------------

const AddToCartItem = async () => {
    console.log('data',  props);
    let data = {
    quantity: '1',
    color: 'black',
    size: 'Medium',
    line_total: props.product.product_price, 
    product_id: props.product.id,
    user_id : 12,
  };

await axios.post('/api/add_OrderItem', data).then(()=> {
        router.push('/add-cart');
      
    });
}


</script>


<template>
   
    <div class="product-card">
        <!----<div class="badge" style="z-index: 1;">Hot</div>-->
        <!-- {{ props.user_id }} -->
       
        <div class="product-tumb">
            <router-link :to="{ name: 'product-details', params: { id: props.product.id }}" style=" width: 100%; height: 100%;" >
            <img :src=" props.product.product_img" alt="">
            </router-link>
        </div>
        <div class="product_cart">
            <p class="cart" @click="AddToCartItem()"><i class="fa-solid fa-cart-shopping"></i></p>
            <p class="view">
                <router-link :to="{ name: 'product-details', params: { id: props.product.id }}" >
                    <i class="fa-solid fa-eye"></i>
               </router-link>
            </p>
            <p class="wish_list"><i class="fa-solid fa-heart"></i></p>
        </div>
        <div class="product-details">
            <span class="product-catagory">{{ props.product.brand.brand_name  }}, {{ props.product.category.category_name }}</span>
            <h4><router-link :to="{ name: 'product-details', params: { id: props.product.id }}" >{{ props.product.product_name }} </router-link></h4>
            <div class="product-bottom-details">
                <div class="product-price"> ${{ props.product.product_price }}</div>
                <p style=" margin-bottom: 8px;">
                     <rating :rating="props.product.average_rating"></rating>
                </p>
               
            </div>
            <!-- <p><router-link :to="{ name: 'product-details', params: { id: props.product.id }}" style="text-decoration: none;">{{ props.product.short_description }}{!! Str::limit($item->blog_description, 200) !!} </router-link> </p>
           -->
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700');

* {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}


body {
    font-family: 'Poppins', sans-serif;
}

a {
    text-decoration: none;
}

.product-card {
    width: calc(25% - 25px);
    position: relative;
    border-radius: 8px;
    border: 1px solid #e4e4e4 ;
    transition: all 0.5s;
    &:hover{
        box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1);
        .product-tumb img{
            background: transparent;
            transform: scale(1.25);
        }
        .product_cart{
            right: 0;
            visibility: visible;
            opacity: 9;
        }

    }
}

.badge {
    position: absolute;
    left: 0;
    top: 20px;
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 700;
    background: red;
    color: #fff;
    padding: 3px 10px;
}

.product-tumb {
    display: flex;
    justify-content: center;
    height: 330px;
    width: 100%;
    overflow: hidden;
    border-radius: 5px 5px 0px 0px;
    background: #f0f0f0;
    position: relative;
}

.product-tumb img {
    width: 100%;
    height: 100%;
    transition: all 0.5s;
}
.product_cart{
    position: absolute;
    top: 0px;
    right: -50px;
    padding: 15px;
    transition: all 0.5s;
    visibility: hidden;
    opacity: 0;
    p{
        cursor: pointer;
        width: 42px;
        height: 42px;
        border-radius: 100%;
        font-size: 18px;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        color: #727272;
        transition: all .3s;
    }
    .cart{
        margin-bottom: 10px;
        &:hover{
            background: #0d2235;
            color: #fff;
        }
       
    }
    .view{
        margin-bottom: 10px;
        a{
            color: #727272;
        }
        &:hover{
            background: #0d2235;
            a{
                color: #fff;
            }
        }
    }
    .wish_list{
        &:hover{
            background: #0d2235;
            color: #fff;
        }

    }
}
.product-details {
    padding: 20px ;
    padding-bottom: 10px;

}

.product-catagory {
    display: block;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    color: #ccc;
    margin-bottom: 14px;
}

.product-details h4 a {
    display: block;
    margin-bottom: 10px;
    font-size: 15px;
    font-weight: 600;
    text-transform: capitalize;
    color: #0d2235;
    text-decoration: none;
    transition: 0.3s;
    font-family: 'Poppins', sans-serif;
}
.product-details p a{
    font-weight: 500;
    display: block;
    margin-bottom: 20px;
    color: #7c7878cc;
    text-decoration: none;
    transition: 0.3s;
}

.product-details h4 a:hover {
    color: #009688;
}

.product-details p {
    font-size: 15px;
    line-height: 22px;
    margin-bottom: 18px;
    color: #999;
}

.product-bottom-details {
   
}

.product-bottom-details div {
    margin-bottom: 8px;
}

.product-price {
    font-size: 15px;
    color: #232630;
    font-weight: 800;
    font-family: Poppins, sans-serif;
}

.product-price small {
    font-size: 80%;
    font-weight: 400;
    text-decoration: line-through;
    display: inline-block;
    margin-right: 5px;
}

.product-links {
    text-align: right;
}

.product-links a {
    display: inline-block;
    margin-left: 5px;
    color: #e1e1e1;
    transition: 0.3s;
    font-size: 17px;
}

.product-links a:hover {
    color: #fbb72c;
}
</style>
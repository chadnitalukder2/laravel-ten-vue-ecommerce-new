<script setup>
import '@fortawesome/fontawesome-free/css/all.css';
import rating from './rating.vue';

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
import { useRoute } from 'vue-router'
const route = useRoute()

//---------------------------------------------------
const count = ref(1);

const decrementCount = () => {
    if (count.value > 1) {
        count.value--;
    }
};

const incrementCount = () => {
    if (count.value < 100) {
        count.value++;
    }
};
//====================================
const user_id = ref('');
const category = ref({
    category_name: ''
});
const brand = ref({
    brand_name: ''
});
const product = ref([]);
const image = ref(null);
//---------------------------------------------------
onMounted(async () => {
    getCategory();
    getBrand();
    getProduct();
});


//---------------------------------------------------
const getProduct = async () => {
    const id = route.params.id;
    // console.log('routhiuhuunje', id);
    let response = await axios.get(`/api/edit_product/${id}`);
    product.value = response.data.product
    user_id.value = response.data
    // console.log('responseydyhfb', product.value);
}
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

const reviews = ref([]);

const addReview = async () =>{
    const formData = new FormData();
    formData.append('review', reviews.value.review);
    formData.append('rating', reviews.value.rating);
    formData.append('product_id', product.value.id );
    formData.append('user_id', user_id.value.user_id);
    // console.log({data});
    await axios.post('/api/add_review', formData).then(()=> {
        getProduct();
        reviews.value =  [];
    });
    
}


const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = { month: 'short', day: '2-digit', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
};
//--------------------------------------------------
const orderItem = ref({});

const addOrderItem = async () => {
  let total = product.value.product_price * count.value;
  
  let data = {
    quantity: count.value,
    color: orderItem.value.color,
    size: orderItem.value.size,
    line_total: total, 
    product_id: product.value.id,
    user_id: user_id.value.user_id
  };

//   console.log({data});
  await axios.post('/api/add_OrderItem', data).then(()=> {
        router.push('/add-cart');
      
    });
};
//---------------------------------------------------
</script>

<template>
    <div>
        <div class="container">
            <div class="row">
             
                    <div class="product_img">
                        <a href=""><img :src="product.product_img" /></a>
                    </div>
                
                    <div class="product_details">
                       
                  
                        <h3 >{{ product.product_name }}</h3>
                        <div class="rating ">
                            <p class="text_left" style="display: flex;">
                                <a href="#"> {{ product.average_rating }} </a>
                                <span>
                                    <rating :rating="product?.average_rating"></rating>
                                </span>
                            </p>
                            <p class="text_middle ">
                                <a href="#" style=" font-size: 12px; color: #a8a8a8; text-decoration: none; font-weight: 600;">{{ product?.reviews?.length}} <span
                                        style="color: #bbb">RATING</span></a>
                            </p>
                            <p class="text_right">
                                <a href="#" style="color: #000;text-decoration: none; font-weight: 700;">500 <span
                                        style="color: #bbb">Sold</span></a>
                            </p>
                        </div>
                        <p   class="price" ><span>${{ product.product_price }}</span></p>
                        <p style="color:#505157 ; font-size: 18px; line-height: 22px;">
                            {{ product.short_description }}
                        </p>
                        <p style="color:#505157 ;    font-size: 18px; line-height: 22px;">
                            {{ product.product_details }}
                        </p>
                        <form @submit.prevent="addOrderItem">
                        <div class=" mt-4">
                            <div class="select-size">
                                <label  style="color: rgb(8 13 16); font-weight: 800; font-size: 16px;" >Sizes : </label>
                                <select v-model="orderItem.size" class="product-control">
                                    <option disabled selected="">Select Size</option>
                                    <option v-for="product_size in product.product_sizes" :key="product_size.id">
                                        {{product_size }}
                                    </option>
                                </select>
                            </div>
                            <div class="select-size">
                                <label style="color: rgb(8 13 16); font-weight: 800; font-size: 16px;">Colors : </label>
                                <select v-model="orderItem.color"  class="product-control">
                                    <option disabled selected >Select Color</option>
                                    <option v-for="product_color in product.product_colors" :key="product_color.id">
                                        {{ product_color }}
                                    </option>
                                </select>
                            </div>

                            <div class="input_group">
                                <button type="button" @click="decrementCount"> <i class="fa-solid fa-minus"></i> </button>
                                <input type="text" :value='count' min="1" max="100" />
                                <button type="button" @click="incrementCount" style="margin-left: 10px;"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>

                            <div class="col-md-12">
                                <p style="color: #000;font-size: 18px;">{{ product.product_quantity }} piece available</p>
                            </div>
                        </div>
                        <p style="margin-top: 35px;">
                           <button type="submit" class="cart_btn"> Add to Cart</button>
                            <a class="buy_btn">Buy now</a>
                        </p>
                    </form>
                    </div>
                
            </div>
            
            <div class="details">
                <h3 class="mb-4">Description</h3>
                <p>
                    On her way she met a copy. The copy warned the Little Blind
                    Text, that where it came from it would have been rewritten a
                    thousand times and everything that was left from its origin
                    would be the word "and" and the Little Blind Text should
                    turn around and return to its own, safe country. But nothing
                    the copy said could convince her and so it didn’t take long
                    until a few insidious Copy Writers ambushed her, made her
                    drunk with Longe and Parole and dragged her into their
                    agency, where they abused her for their.
                </p>
            </div>
            <div class="details" >
                <h3 class="mb-4">({{ product?.reviews?.length  }})Reviews</h3>
                <div class="review-wrapper">
                    <div class="review-template">
                        <div v-for="item in product?.reviews" :key="item.id" class="adrm_review_temp_one">
                            <div class="adrm_review_temp_one_avatar"><img src="https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/3431298/original/Onixus1flat/make-your-profile-picture--looks-flat-designed.jpg"
                                    alt="Avatar"></div>
                            <div class="adrm_review_temp_one_content">
                                <div class="adrm_review_temp_one_content_header">
                                    <div class="left">
                                        <p class="date">{{ formatDate(item.created_at) }}</p>
                                        <h3 class="adrm_review_temp_one_content_header_name">{{item.user.name }}</h3>
                                    </div>
                                    <div class="adrm_rating">
                                        <div class="adrm-star-rating">
                                            <span>
                                                <rating :rating="item.rating"></rating>
                                               
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="adrm_review_temp_one_content_body">
                                    <p class="review"> {{item.review}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-form">
                        <form @submit.prevent="addReview"> 
                        <h1>Write your reviews</h1>
                        <label for="uname"><b>Provide your rating</b></label>
                        <select name="rating" v-model="reviews.rating">
                            <option>Select your rating</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>

                        <label for="message"><b>Write your review</b></label>
                        <textarea name="message" v-model="reviews.review"></textarea>

                        <input type="submit" value="Submit">
                        </form>
                    </div>           
                </div>
            </div>
        </div>
    </div>

</template>

<style lang="scss" scoped>
input[type=text],
select,
textarea {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.container {
    padding: 60px;
}

.row {
    display: flex;
    gap: 80px;

    .product_img {
        flex-basis: 60%;

        img {
            width: 100%;
            height: 100%;
        }
    }

    h3 {
        font-size: 2.3rem;
        font-weight: 700;
        margin: 0px;
        text-transform: capitalize;
    }

    .product_details {
        flex-basis: 60%;
        flex-wrap: wrap;
        padding: 10px;

        .rating {
            display: flex;
            gap: 12px ;
            text-align: center;
            align-items: center;
            .text_left {
                a {
                    color: #eeab00;
                    text-decoration: none;
                    padding-right: 10px;
                    font-size: 20px;
                    padding-top: 2px;
                    font-weight: 700;
                }
                span{
                    label{
                        font-size: 18px;
                        color:  gray;
                    }
                    .active{
                        color: #eeab00;
                    }
                }
                
                
                    
            }
        }

        .price {
            font-size: 25px;
            color: #000000;
            margin: 0px;
            padding: 10px 0px;
            font-weight: 800;
            color: #232630;
            font-family: Poppins, sans-serif;
        }
    }

}

.select-size {
    select {
        font-size: 13px;
        width: 25%;
        text-align: center;
        padding: 10px;
        letter-spacing: 2px;
        color: #000000;
        text-transproduct: uppercase;
        border: 1px solid rgba(0, 0, 0, 0.1);
        margin: 20px 0px;
    }
}

.input_group {
    button {
        padding: 8px 10px;
        font-size: 13px;
        background: transparent;
        border: 1px solid rgba(0, 0, 0, 0.1);
        margin-right: 10px;
        padding: 10px;
        cursor: pointer;
        color: #000000;
    }

    input {
        font-size: 16px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.1);
        width: 20%;
        color: #000000;
        padding: 8px;
    }
}

.cart_btn {
    background: #000000;
    border: 1px solid #000000;
    color: #fff;
    padding: 15px 40px;
    font-size: 16px;
    border-radius: 31px;
    text-decoration: none;
    margin-right: 15px;
    cursor: pointer;

    &:hover {
        transition: all 0.2s ease;
        background: #D1EAE4;
        border: 1px solid #D1EAE4;
        color: #000000;
        transproduct: 0.3;
    }
}

.buy_btn {
    cursor: pointer;
    background: #D1EAE4;
    border: 1px solid #D1EAE4;
    color: #000000;
    padding: 15px 50px;
    font-size: 16px;
    border-radius: 31px;
    text-decoration: none;

    &:hover {
        background: #fff;
        color: #000000;
        transition: all 0.2s ease;
    }
}

.heading {
    display: flex;
    justify-content: space-between;
    padding-top: 50px;
    gap: 20px;

    h3 {
        background: #ede3e3;
        padding: 35px;
        text-align: center;
        font-size: 28px;
        border: 1px solid transparent;
        background: rgba(0, 0, 0, 0.05);

        &:hover {
            background: #D1EAE4;
            transition: all 0.2s ease;
        }
    }
}

.details {
    padding: 20px;
    // background: #ededed4f;
    margin-bottom: 20px;

    h3 {
        font-size: 1.75rem;
        line-height: 1.5;
        font-weight: 600;
        color: #000000;
        margin-bottom: 1.5rem;
        font-family: Poppins, sans-serif;
    }

    p {
        font-size: 18px;
        line-height: 1.8;
        font-weight: 400;
        color: rgb(80, 81, 87);
    }
}

.review-wrapper {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    padding: 20px;
    border: 1px solid #80808036;
    border-radius: 8px;

    .review-template {
        // border-right: 1px solid gray;
        width: 50%;
        min-width: 400px;

        .adrm_review_temp_one {
            display: flex;
            gap: 30px;
            width: calc(100% - 40px);
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgb(240, 236, 236);
            background: #9e9e9e1a;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 10px;

            @media screen and (max-width: 768px) {
                padding: 4px;
                gap: 10px;
            }

            .adrm_review_temp_one_avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                overflow: hidden;

                img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            }

            .adrm_review_temp_one_content {
                width: calc(100% - 100px);

                .adrm_review_temp_one_content_header {
                    display: flex;
                    gap: 10px;
                    justify-content: space-between;

                    .date {
                        font-size: 14px;
                        font-weight: 600;
                        color: black;
                    }

                    h3, p {
                        margin: 0px;
                    }

                    .adrm_review_temp_one_content_header_name {
                        font-size: 20px;
                        font-weight: 600;
                        color: black;
                    }

                    .adrm_review_temp_one_content_header_rating {
                        display: flex;
                        gap: 5px;
                    }
                    .adrm-star-rating {
                        span {
                            font-size: 18px;
                            color: gray;
                            padding-right: 2px;
                            font-weight: 700;
                        }
                        .active {
                            color: #f1c40f;
                        }
                    }

                    @media screen and (max-width: 768px) {
                        display: block;

                        .date {
                            margin: 0;
                        }

                        .adrm_review_temp_one_content_header_name {
                            margin: 0;
                        }
                    }
                }

                .adrm_review_temp_one_content_body {
                    .review {
                        color: black;
                        margin-bottom: 10px;
                    }

                    @media screen and (max-width: 768px) {
                        .review {
                            margin-top: 0px;
                        }
                    }
                }
            }
        }
    }

    .review-form {
        width: calc(50% - 40px);
        width: calc(50% - 62px);
        padding: 20px;
        background: #2196f312;
        border-radius: 8px;
    }
}
</style>
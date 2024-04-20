<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();




</script>

<template>
    <div class="container" >
        <h1>Contact Page</h1>
        <hr style="border: 1px solid rgb(0, 150, 136); width: 25%; margin-bottom: 40px;">
        <div style="background:#fff ; width: 70%; margin: 0 auto; padding: 35px; box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1); border-radius: 5px;">
            <form @submit.prevent="addMsg">
            <div class="contact_page" >
                <div class="contact_page_left" style="flex-basis: 50%;">
                    <div class="contact_info" >
                        <label style="font-weight: bold;">Name : </label>
                        <input type="text" placeholder="enter your name" v-model="name">
                    </div>
                    <div class="contact_info">
                        <label style="font-weight: bold;">Phone : </label>
                        <input type="number" placeholder="enter your name">
                    </div>
                </div>
                <div class="contact_page_right" style="flex-basis: 50%;">
                    <div class="contact_info">
                    <label style="font-weight: bold;">Email : </label>
                    <input type="email" placeholder="enter your name">
                </div>
                <div class="contact_info">
                    <label style="font-weight: bold;">Address : </label>
                    <textarea type="text" placeholder="enter your address"></textarea>
                </div>
                </div>

            </div>
            
            <div class="contact_info" style="text-align: left; padding-bottom: 0px;">
                <label style="font-weight: bold;">Message : </label>
                <textarea type="text" placeholder="enter your massage" rows="5"></textarea>
            </div>

            <div style="text-align: left; padding-top: 25px;">
                <button type="submit">Submit</button>
            </div>
        </form>
        </div>
    </div>
</template>


<style lang="scss" scoped>
.container{
  padding: 50px ;
  text-align: center;
  background: #d7d1d130;

  h1{
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 20px;
    margin: 0 auto;
    text-align: center;
    padding: 10px;
    margin-top: 28px;
    font-family: Poppins, sans-serif;
  }
  button{
    padding: 8px 22px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 5px;
    border: 1px solid #ccc;
    background: #117964;
    color: #fff;
    cursor: pointer;
    transition: all .3s ;
    &:hover{
        background: #fff;
        color: #117964;
        box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1);
        border: 1px solid #117964;
    }
  }

  .contact_page{
    display: flex;
    justify-content: space-between;
    margin: 0 auto;
    gap: 50px;
    text-align: left;

  }
  .contact_info{
        padding-bottom: 15px;
        input, textarea{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 8px;
            font-size: 15px;

            &:focus-visible{
                border: 1px solid #62c7af;
                outline: none;
            }

        }
    }
}


</style>
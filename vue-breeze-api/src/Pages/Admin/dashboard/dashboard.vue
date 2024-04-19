<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
//-----------------------------------------
const products = ref([]);

//--------------------------------------
onMounted(async () => {
  allProduct();
});
//-----------------------------
const allProduct =  async () =>{
  let response = await axios.get("/api/all_product");
  products.value = response.data.products;
}

</script>

<template>
    <div class="container">
      <div class="overView">
        <h1>OverView</h1>
        <div style="width: 100%; border-bottom: 1px solid #857f7f30;"  ></div>
        <div style="display: flex; gap: 20px; justify-content: space-between;">
          <div class="describ">
            <div class="details">
              <h1>{{ products.length }}</h1>
              <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-business-time"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>33</h1>
              <p>Total Selling Product</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-truck"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>33</h1>
              <p>Total Amount</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-money-bill"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>33</h1>
              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-user"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>



<style lang="scss" scoped>
.container{
  padding: 50px ;
  width: 100%;
  text-align: center;
  background: #d7d1d130;

  .overView{
    background: #fff;
    border-radius: 6px;
    padding: 20px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px 0px;

    h1{
      margin: 0px;
      text-align: left;
      font-size: 20px;
      color: #343232;
      margin-bottom: 10px;
    }

    .describ{
      width: 25%;
      display: flex;
      justify-content: space-between;
      border: 1px solid #857f7f30;
      margin-top: 15px;
      border-radius: 5px;
      padding: 10px;
      .details{
        h1{
          margin-bottom: 6px;
        }
        p{
          margin: 0px;
          font-size: 12px;
          color: #5e5c5c;
          font-weight: 600;
        }
      }
      .icon{
        padding-top: 14px;
        i{
          color: #767575;
          font-size: 18px;
        }
      }
    }
  }
}
</style>
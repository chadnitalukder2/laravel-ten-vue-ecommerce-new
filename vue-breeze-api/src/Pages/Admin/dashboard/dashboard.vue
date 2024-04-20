<script setup>
import Chart from './Chart.vue';
import productTable from "../product/product_table.vue";
import orderTable from "../order_item/order_table.vue";

import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
//-----------------------------------------
const products = ref(0);
const totalSelling = ref(0)
const user = ref(0);
const total_amount = ref(0);
const monthly_order_report= ref([]);
//--------------------------------------
onMounted(async () => {
  getReports();
});

const getReports =  async () =>{
  let response = await axios.get("/api/reports");
  total_amount.value = response.data.total_paid_amount;
  products.value = response.data.products;
  totalSelling.value = response.data.total_order_items;
  user.value = response.data.total_users;
  
  prepareReport(response.data.monthly_order_report);

  console.log(response.data);
}

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const prepareReport = (data) => {
  let labels = [];
  let amount = [];
  let backgroundColor = ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'];
  
  for (let i = 0; i < data.length; i++) {
    labels.push(months[data[i].month  -1]);
    amount.push(data[i].total_amount);
  }
  
  monthly_order_report.value = {
    labels: labels,
    datasets: [
      {
        data: amount,
        backgroundColor: backgroundColor,
      },
    ],
  };
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
              <h1>{{ products }}</h1>
              <p>Total Product</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-business-time"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>{{ totalSelling }}</h1>
              <p>Total Selling Product</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-truck"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>{{ total_amount }}</h1>
              <p>Total Amount</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-money-bill"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>{{ user }}</h1>
              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-user"></i>
            </div>
          </div>
        </div>
      </div>

      <Chart :monthly_order_report="monthly_order_report" />

      <div class="overView">
        <h1>Latest Products</h1>
        <div style="width: 100%; border-bottom: 1px solid #857f7f30;"  ></div>
       <productTable/>
      </div>

      <div class="overView">
        <h1>Latest Orders</h1>
        <div style="width: 100%; border-bottom: 1px solid #857f7f30;"  ></div>
       <orderTable/>
      </div>

    </div>
</template>


<style lang="scss" scoped>
.container{
  width: 100%;
  text-align: center;
  background: #d7d1d130;

  .overView{
    margin: 30px;
    background: #fff;
    border-radius: 6px;
    padding: 20px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px 0px;

    h1{
      margin: 0px;
      text-align: left;
      font-size: 22px;
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
      padding: 12px;
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
          font-size: 20px;
        }
      }
    }
  }
}



</style>
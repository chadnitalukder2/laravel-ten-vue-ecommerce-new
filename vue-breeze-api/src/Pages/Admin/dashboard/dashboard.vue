<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();
//-----------------------------------------
const products = ref([]);
const totalSelling = ref([])
const user = ref([]);
const total_amount = ref([]);
//--------------------------------------
onMounted(async () => {
  allProduct();
  sellingProducts();
  getUser();
  totalAmount()
});
//-----------------------------
const allProduct =  async () =>{
  let response = await axios.get("/api/all_product");
  products.value = response.data.products;
  console.log('product', products.value)
}

const totalAmount = async () => {
  let response = await axios.get("/api/total_amount");
  total_amount.value = response.data.orders
};

const total = () => {
  let result = 0;
  for (let i = 0; i < total_amount.value.length; i++) {
    result += total_amount.value[i].total_amount;
  }
  return result;
}

const sellingProducts = async () =>{
  let response = await axios.get("/api/selling_product");
  totalSelling.value = response.data.orderItems;
}

const getUser = async () => {
  let response = await axios.get("/api/get_user");
  user.value = response.data.user;
};
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
              <h1>{{ totalSelling.length }}</h1>
              <p>Total Selling Product</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-truck"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>{{ total() }}</h1>
              <p>Total Amount</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-money-bill"></i>
            </div>
          </div>
          <div class="describ">
            <div class="details">
              <h1>{{ user.length }}</h1>
              <p>Total Customers</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-user"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="overView">
        <h1>Latest Products</h1>
        <div style="width: 100%; border-bottom: 1px solid #857f7f30;"  ></div>
        <table id="customers">
        <tr>
          <th># ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Category Name</th>
          <th>Brand Name</th>
          <th>Image</th>
        </tr>
        <tbody v-for="item in products" :key="item.id">
          <tr>
            <td style="color: blue">
              <router-link
                :to="{ name: 'edit-product', params: { id: item.id } }"
                ># {{ item.id }}
              </router-link>
            </td>
            <td>{{ item.product_name }}</td>
            <td>{{ item.product_price }}</td>
            <td>{{ item.product_quantity }}</td>
            <td>{{ item.category.category_name }}</td>
            <td>{{ item.brand.brand_name }}</td>
            <td style="width: 70px; height: 60px">
              <img :src="item.product_img" style="width: 100%; height: 100%" />
            </td>

          </tr>
        </tbody>
      </table>
      </div>

      <div class="overView">
        <h1>Latest Orders</h1>
        <div style="width: 100%; border-bottom: 1px solid #857f7f30;"  ></div>
        <table id="customers">
          <tr>
                <th># ID</th>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Total Amount</th>
                <th>Order Status</th>
                <th>Payment Status</th>
            </tr>
            <tbody v-for="item in total_amount" :key="item.id">
                <tr>
                    <td style=""># {{ item.id }}</td>
                    <td>{{ item.user_id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.address }}</td>
                    <td>{{ item.phone }}</td>
                    <td>{{ item.total_amount }}</td>
                    <td>{{ item.order_status }}</td>
                    <td>{{ item.payment_status }}</td>
                </tr>
            </tbody>
      </table>
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

table {
  border-radius: 6px;
  overflow: hidden;
  margin-top: 20px;
}

.table-box {
  padding: 50px;
  border-radius: 8px;

  .btn {
    text-align: right;
    padding-bottom: 10px;
    button {
      padding: 10px 20px;
      border: 1px solid #ddd;
      background: #189877;
      border-radius: 6px;
      cursor: pointer;
      a {
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        color: #fff;
      }
    }
  }
}

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td,
#customers th {
  border: 1px solid #f3ededad;
  padding: 15px 15px;
  text-align: left;
}

#customers tr:nth-child(even) {
  background-color: #f2f2f2;
}

#customers th {
  padding-top: 20px;
  padding-bottom: 20px;
  text-align: left;
  background-color: rgb(237 236 236 / 68%);
  color: #444;
}

</style>
import { createRouter, createWebHistory } from "vue-router";
import axios from "axios";

import Home from "../Pages/Home/Home.vue";
import Shop from "../Pages/Shop/ShopIndex.vue";
import Admin from "../Pages/Admin/Index.vue"

const routes = [
  { path: "/", name: "Home", component: Home },
  { path: "/Shop", name: "Shop", component: Shop },
  {
     path: "/Profile", 
     name: "Profile",
     meta: { requiresAuth: true },
      component: () =>import("../Pages/Profile/Profile.vue")
  },
  {
    path: "/Contact", 
    name: "Contact",
     component: () =>import("../Pages/Contact_page/Contact.vue")
 },
  {
    path: "/product-details/:id",
    name: "product-details",
    component: () => import("../Pages/product_details/product_details.vue"),
  },
  {
    path: "/add-cart",
    name: "add-cart",
    meta: { requiresAuth: true },
    component: () => import("../Pages/cart_item/add_cart.vue"),
  },
  {
    path: "/login",
    name: "Login",
    component: () => import("../components/Login.vue"),
  },
  {
    path: "/register",
    name: "Register",
    component: () => import("../components/Register.vue"),
  },
  {
    path: "/forgot-password",
    name: "ForgotPassword",
    component: () => import("../components/ForgotPassword.vue"),
  },
  {
    path: "/password-reset/:token",
    name: "ResetPassword",
    component: () => import("../components/ResetPassword.vue"),
  },
  
  {
    path: '/admin/',
    component: Admin,
    name: 'admin',
    meta: { requiresAuth: true, adminAuthRequired: true },
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: () => import("../Pages/Admin/dashboard/dashboard.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "add-product",
        name: "add-product",
        component: () => import("../Pages/Admin/product/add_product.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "all-product",
        name: "all-product",
        component: () => import("../Pages/Admin/product/all_product.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: 'edit-product/:id',
        name : 'edit-product',
        component: () => import("../Pages/Admin/product/edit_product.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/all-category",
        name: "all-category",
        component: () => import("../Pages/Admin/category/all_category.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/add-category",
        name: "add-category",
        component: () => import("../Pages/Admin/category/add_category.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/all-brand",
        name: "all-brand",
        component: () => import("../Pages/Admin/brand/all_brand.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/add-brand",
        name: "add-brand",
        component: () => import("../Pages/Admin/brand/add_brand.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/contact",
        name: "contact",
        component: () => import("../Pages/Admin/contact/contact.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/all-user",
        name: "all-user",
        component: () => import("../Pages/Admin/user/all_user.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/edit-user/:id",
        name: "edit-user",
        component: () => import("../Pages/Admin//user/edit_user.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/all-order",
        name: "all-order",
        component: () => import("../Pages/Admin/order_item/order_item.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
      {
        path: "/view_order_details/:id",
        name: "view_order_details",
        component: () => import("../Pages/Admin/order_item/view_order_details.vue"),
        meta: { requiresAuth: true, adminAuthRequired: true },
      },
    ],
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


router.beforeEach(async (to, from, next) => {
  console.log(to);
  if (to.meta.requiresAuth) {
    await axios.get('/api/user').then(response => {
      if (response.status == 200) {
        if(to.meta.adminAuthRequired && response.data.role != 'admin'){
          next('/');
        } else {
          next();
        }
      } else {
        next('/login');
      }
    }
    ).catch(error => {
      next('/login');
    });

  } else {
    // No authentication required, proceed to the route
    next();
  }
});


export default router;
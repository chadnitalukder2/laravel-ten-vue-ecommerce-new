<script setup>

import '@fortawesome/fontawesome-free/css/all.css';
import { computed, onMounted, reactive } from 'vue';
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();

import {
    defineProps
} from "vue";

const state = reactive({
    loggedIn: false,
    is_admin: false
});

const handleLogout = async () => {
    localStorage.removeItem('email');
    localStorage.removeItem('password');
    await axios.post('/logout');
    state.loggedIn = false;
    router.push({ name: 'Login' });
    // window.location.reload();
};

const getUser = async () => {
    await axios.get('/api/user').then(response => {
      if (response.status == 200) {
        state.loggedIn = true;
        if (response.data.role == 'admin') {
          state.is_admin = true;
          router.push({ name: 'dashboard' });
        }
      } else {
        state.loggedIn = false;
      }
    }
    ).catch(error => {
        state.loggedIn = false;
    });
}

onMounted(async () => {
    getUser();
});
</script>



<template>
    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>

            <ul class="menu-items">

                <li><router-link :to="{ name: 'Home' }" active-class="active">Home</router-link></li>
                <li><router-link :to="{ name: 'Shop' }" active-class="active">Shop</router-link></li>
                <li><router-link :to="{ name: 'Contact' }" active-class="active">Contact</router-link></li>
                <li v-if="!state.loggedIn"><router-link active-class="active" :to="{ name: 'Login' }">Login</router-link></li>
                <li v-if="!state.loggedIn"><router-link active-class="active" :to="{ name: 'Register' }">Register</router-link></li>
                <li v-if="state.loggedIn">
                    <button @click="handleLogout">
                        Logout
                    </button>
                </li>
                <li><router-link v-if="state.is_admin" active-class="active" :to="{ name: 'dashboard' }">Admin</router-link></li>
                <li><router-link active-class="active" :to="{ name: 'add-cart' }"><i class="fa-solid fa-cart-plus"></i></router-link></li>
                <li><router-link :to="{ name: 'Profile' }" active-class="active"><i class="fa-solid fa-user"></i></router-link></li>
            </ul>
            <div class="logo">
                <router-link :to="{ name: 'Home' }">
                    <img style="max-height: 52px;" src="https://similux-vinovatheme.myshopify.com/cdn/shop/files/Logo-retina.png?v=1667462956&width=300" alt="logo" />
                </router-link>
            </div>
        </div>
    </nav>

</template>




<style lang="scss" scoped>
.navbar {

    input[type="checkbox"],
    .hamburger-lines {
        display: none;
    }

    box-shadow: 0px 2px 7px 0px #EAECF0;
    /* border-bottom: 1px solid #aaaaaaa1; */
    background: #fff;
    color: #000;

    a {
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 800;
        text-transform: uppercase;
        transition: all .3s ease;
        color: #232630;
        &.active {
            color: #117964;
        }
        &:hover {
            color: #117964;
        }
    }

    .navbar-container {
        display: flex;
        justify-content: space-between;
        height: 64px;
        align-items: center;

        .menu-items {
            order: 2;
            display: flex;
        }

        .logo {
            order: 1;
            font-size: 2.3rem;
        }
    }

    .menu-items {
        // background: #fff;

        li {
            list-style: none;
            margin-left: 1.5rem;
        }

        button {
            padding: 8px 16px;
            border: 1px solid #8080803b;
            border-radius: 4px;
            cursor: pointer;
            height: 36px;
            font-size: 16px;
            font-weight: 600;
            color: #444;
            margin-top: -10px;
        }

        button:hover {
            background-color: #4CAF50;
            /* Green */
            color: white;
        }
    }
}

.container {
    width: 90%;
    margin: auto;
}

@media (max-width: 768px) {
    .navbar {
        opacity: 0.95;

        .navbar-container {

            input[type="checkbox"],
            .hamburger-lines {
                display: block;
            }

            display: block;
            position: relative;
            height: 64px;

            input[type="checkbox"] {
                position: absolute;
                display: block;
                height: 32px;
                width: 30px;
                top: 20px;
                left: 20px;
                z-index: 5;
                opacity: 0;
                cursor: pointer;
            }

            .hamburger-lines {
                display: block;
                height: 28px;
                width: 35px;
                position: absolute;
                top: 20px;
                left: 20px;
                z-index: 2;
                display: flex;
                flex-direction: column;
                justify-content: space-between;

                .line {
                    display: block;
                    height: 4px;
                    width: 100%;
                    border-radius: 10px;
                    background: #333;
                }

                .line1 {
                    transform-origin: 0% 0%;
                    transition: transform 0.3s ease-in-out;
                }

                .line2 {
                    transition: transform 0.2s ease-in-out;
                }

                .line3 {
                    transform-origin: 0% 100%;
                    transition: transform 0.3s ease-in-out;
                }
            }

            .menu-items {
                background: #D1EAE4;
                padding-top: 100px;
                margin-top: 0px;
                height: 100vh;
                max-width: 300px;
                transform: translate(-150%);
                display: flex;
                flex-direction: column;
                margin-left: -40px;
                padding-left: 40px;
                transition: transform 0.5s ease-in-out;
                box-shadow: 5px 0px 10px 0px #aaa;
                overflow: scroll;

                li {
                    margin-bottom: 1.8rem;
                    font-size: 1.1rem;
                    font-weight: 500;
                }
            }

            .logo {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 2.5rem;
                margin: 0;
            }

            input[type="checkbox"]:checked {
                ~.menu-items {
                    transform: translateX(0);
                }

                ~.hamburger-lines {
                    .line1 {
                        transform: rotate(45deg);
                    }

                    .line2 {
                        transform: scaleY(0);
                    }

                    .line3 {
                        transform: rotate(-45deg);
                    }
                }
            }
        }
    }
}

@media (max-width: 500px) {
    .navbar-container {
        input[type="checkbox"]:checked {
            ~.logo {
                display: none;
            }
        }
    }
}
</style>
<script>
export default {
    name: "Hero",
}
</script>

<template>
    <!-- Main Section -->
<main class="main" style="width: 100%;">
   <section class="section banner banner-section">
      <div class="container banner-column">
         <img class="banner-image" src="https://i.ibb.co/vB5LTFG/Headphone.png" alt="banner">
         <div class="banner-inner">
            <h1 class="heading-xl">ECOMERCE PROJECT</h1>
            <p class="paragraph">
               This is a simple e-commerce project built with Laravel and Vue.js. It is a full-stack project that includes authentication, product management, and shopping cart functionality. The project is built with Laravel Breeze and Vue 3.
            </p>
            <button class="btn btn-darken btn-inline">
               <router-link :to="{ name: 'Shop' }" active-class="active">
                  Our Products<i class="bx bx-right-arrow-alt"></i>
               </router-link>
            </button>
         </div>
         <div class="banner-links">
            <a href="#" title=""><i class="bx bxl-facebook"></i></a>
            <a href="#" title=""><i class="bx bxl-instagram"></i></a>
            <a href="#" title=""><i class="bx bxl-twitter"></i></a>
            <a href="#" title=""><i class="bx bxl-youtube"></i></a>
         </div>
      </div>
   </section>
</main>
</template>

<style scoped lang="scss">

a,
button {
   cursor: pointer;
   border: none;
   outline: none;
   user-select: none;
   background: none;
   box-shadow: none;
   text-decoration: none;
   a{
      text-decoration: none;
      color: white;
   }
}

.section {
    background:#159f83;;
}

img,
video {
   display: block;
   max-width: 100%;
   height: auto;
   object-fit: cover;
}

.section {
   margin: 0 auto;
}

.container {
   max-width: 75rem;
   height: auto;
   margin: 0 auto;
   padding: 0 1.25rem;
}

.centered {
   text-align: center;
   vertical-align: middle;
   margin-bottom: 1rem;
}

.heading {
   &-xl {
    line-height: 1.0;
    letter-spacing: -1px;
    color: #fff;
    font-size: 62px;
    margin: 0;
   }
}

.paragraph {
   font-family: inherit;
   font-size: clamp(1rem, 2vw, 1.125rem);
   text-wrap: balance;
   color: #fff
}

.btn {
   display: inline-block;
   font-family: inherit;
   font-size: 1rem;
   font-weight: 500;
   line-height: 1.5;
   text-align: center;
   vertical-align: middle;
   white-space: nowrap;
   user-select: none;
   outline: none;
   border: none;
   border-radius: 0.25rem;
   text-transform: unset;
   transition: all 0.3s ease-in-out;

   &-inline {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      column-gap: 0.5rem;
   }

   &-darken {
      padding: 0.75rem 2rem;
      padding: 0.75rem 2rem;
      color: #fff;
      background-color: #117964;
   }
}

.banner {
   &-column {
      display: grid;
      align-items: center;
      row-gap: 3rem;


      @media only screen and (min-width: 48rem) {
         grid-template-columns: repeat(2, minmax(0, 1fr));
         justify-content: center;
      }

      @media only screen and (min-width: 64rem) {
         grid-template-columns: 1fr max-content;
         column-gap: 4rem;
         padding-top: 3rem;
         padding-bottom: 3rem;
      }
   }

   &-image {
      display: block;
      max-width: 18rem;
      height: auto;
      margin-top: 2rem;
      object-fit: cover;
      justify-self: center;

    
      @media only screen and (min-width: 48rem) {
         order: 1;
         max-width: 20rem;
         height: auto;
      }

      @media only screen and (min-width: 64rem) {
         max-width: 28rem;
         height: auto;
      }
   }

   &-inner {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      row-gap: 1.75rem;
   }

   &-links {
      position: absolute;
      top: 30%;
      right: 1.5rem;
      display: grid;
      justify-items: center;
      row-gap: 0.5rem;
      opacity: 0;
      visibility: hidden;

      @media only screen and (min-width: 64rem) {
         opacity: 1;
         visibility: visible;
      }

      & > * {
         font-size: 1.25rem;
         line-height: 1.25;
         color: var(--color-white-100);
      }

      &::before {
         position: absolute;
         content: "";
         top: -3rem;
         width: 4rem;
         height: 1.5px;
         transform: rotate(90deg);
         background: var(--color-white-100);
      }

      &::after {
         position: absolute;
         content: "";
         bottom: -3rem;
         width: 4rem;
         height: 2px;
         transform: rotate(90deg);
         background: var(--color-white-100);
      }
   }

}


</style>
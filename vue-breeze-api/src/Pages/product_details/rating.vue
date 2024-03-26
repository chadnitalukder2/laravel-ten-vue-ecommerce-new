<template>
    <div>
        <span>
            <label v-for="rating in 5" name="rating" :key="rating.id" :class=" props.rating >= rating ? 'active' : ''" value="1">★</label>
        </span>
    </div>
</template>

<script setup>
import {
    defineProps
} from "vue";
const props = defineProps(["rating"]);
</script>

<style lang="scss" scoped>
  span{
        label{
           
            color:  #d4d4d4;
            text-decoration: none;
            font-size: 20px;
            font-weight: 700;
            font-size: 18px;
        }
        .active{
            color: #ffcd04;
        }
    }

</style>
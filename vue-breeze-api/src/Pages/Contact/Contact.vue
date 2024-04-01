<script setup>

</script>

<template>
    <div class="container" >
        <div style="background:#fff ; width: 70%; margin: 0 auto; padding: 35px; box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.1); border-radius: 5px;">

            <div class="contact_page" >
                <div class="contact_page_left" style="flex-basis: 50%;">
                    <div class="contact_info" >
                        <label style="font-weight: bold;">Name : </label>
                        <input type="text" placeholder="enter your name">
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

        </div>
    </div>
</template>


<style lang="scss" scoped>
.container{
  padding: 50px ;
  text-align: center;
  background: #d7d1d130;

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

        }
    }
}


</style>
<script setup>

</script>

<template>
    <div class="container" >
        <div class="contact_page" style="display: flex; justify-content: space-between;">
            <div class="contact_page_left">
                <div>
                    <label>Name</label>
                    <input type="text" placeholder="enter your name">
                </div>
                <div>
                    <label>Phone</label>
                    <input type="number" placeholder="enter your name">
                </div>
            </div>
            <div class="contact_page_right">
                <div>
                <label>Email</label>
                <input type="email" placeholder="enter your name">
            </div>
            <div>
                <label>Address</label>
                <textarea type="text" placeholder="enter your name"></textarea>
            </div>
            </div>

        </div>
        
        <div>
                <label>Message</label>
                <textarea type="text" placeholder="enter your name"></textarea>
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
    width: 65%;
    margin: 0 auto;
    padding: 20px 30px;
    background: #fff;
  }
}


</style>
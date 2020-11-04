<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 ">
                
               <chat-app ></chat-app>
               
            </div> 
        </div>
    </div>
</template>

<script>
import ChatApp from './ChatApp';

    export default {
        mounted() {
            console.log('Component mounted.')
        },
         components: {ChatApp}
    }
</script>

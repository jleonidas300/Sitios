<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    //llamo el archivo index.js de la carpeta store
     import store from '../store'

     export default
     {
         store
         
     }
</script>
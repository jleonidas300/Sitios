<template>
    <div class="container my-5">
        <h2> {{establecimiento.nombre}}</h2>
    </div>
</template>

<script>
export default 
{
    mounted()
    {
        //console.log(this.$route.params);
        const {id} = this.$route.params;
        axios.get('/api/establecimientos/' + id )
            .then(respuesta => {
                this.$store.commit('Agregar_Establecimiento', respuesta.data);
                //console.log(respuesta.data)
            })
    },
    computed: 
    {
        establecimiento(){
            return this.$store.getters.obtenerEstablecimiento;
        }
    }
}
</script>
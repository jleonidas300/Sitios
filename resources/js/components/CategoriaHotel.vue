<template>
    <div class="container my-5">
        <h2>Hoteles</h2>
        <div class="row">
            <div class="col-md-4 mt-4" v-for="hotel in this.hoteles" v-bind:key="hotel.id">
                
                <div class="card">
                    <img :src="`storage/${hotel.imagen_principal}`" alt="Card del café" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title text-primary font-weight-bold">
                            {{ hotel.nombre }}
                        </h3>
                    </div>
                        <p class="card-text">{{ hotel.direccion }}</p>
                        <p class="card-text">
                            <span class="font-weight-bold">Horario:</span>
                            {{ hotel.apertura }} - {{ hotel.cierre }}
                        </p>
                    <a href="" class="d-block btn btn-primary">Ver lugar</a>
                </div>

            </div>
        </div>
    </div>
    
</template>

<script>
export default 
{
    data: function(){
        return{
            hoteles: []
        }
    },
    mounted()
    {
        axios.get('/api/categorias/hotel')
            .then(respuesta => {
                this.hoteles = respuesta.data;
                //console.log(respuesta.data)
            })
    }
}
</script>
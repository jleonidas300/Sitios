<template>
    <div class="container my-5">
        <h2>Cafés</h2>
        <div class="row">
            <div class="col-md-4 mt-4" v-for="cafe in this.cafes" v-bind:key="cafe.id">
                
                <div class="card">
                    <img :src="`storage/${cafe.imagen_principal}`" alt="Card del café" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title text-primary font-weight-bold">
                            {{ cafe.nombre }}
                        </h3>
                    </div>
                        <p class="card-text">{{ cafe.direccion }}</p>
                        <p class="card-text">
                            <span class="font-weight-bold">Horario:</span>
                            {{ cafe.apertura }} - {{ cafe.cierre }}
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
            cafes: []
        }
    },
    mounted()
    {
        axios.get('/api/categorias/cafe')
            .then(respuesta => {
                this.cafes = respuesta.data;
                //console.log(respuesta.data)
            })
    }
}
</script>
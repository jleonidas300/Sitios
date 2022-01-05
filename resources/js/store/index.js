import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cafes: [],
        restaurantes: [],
        hoteles: [],
        establecimiento: {}
    },
    mutations: 
    {
        Cafes(state, cafes){
            state.cafes = cafes;
        },
        Restaurantes(state, restaurantes){
            state.restaurantes = restaurantes;
        },
        Hoteles(state, hoteles){
            state.hoteles = hoteles;
        },
        Agregar_Establecimiento(state, establecimiento){
            state.establecimiento = establecimiento;
        }
    },
    getters: 
        {
            obtenerEstablecimiento: state => {
                return state.establecimiento
            }
        }
    
});

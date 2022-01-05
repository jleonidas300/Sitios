// import
import { OpenStreetMapProvider } from 'leaflet-geosearch';
// setup
const provider = new OpenStreetMapProvider();
//const provider = new GeoSearch.OpenStreetMapProvider();

document.addEventListener('DOMContentLoaded', () => 
{
    if(document.querySelector('#mapa')){
        const lat = document.querySelector('#lat').value === '' ? 13.6981787 : document.querySelector('#lat').value;
        const lng = document.querySelector('#lng').value === '' ? -89.1745726 : document.querySelector('#lng').value;

        const mapa = L.map('mapa').setView([lat, lng], 16);

        //eliminar pines previos del mapa
        let markers = new L.featureGroup().addTo(mapa);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
            {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mapa);

            let marker;

            //agregar el pin
            marker = new L.marker([lat, lng], 
            {
                draggable: true,
                autoPan: true
            }).addTo(mapa);
        
        //console.log(L.esri);
        //creando un geocode service
        const geocodeService = L.esri.Geocoding.geocodeService({
        apikey: "AAPKb49576d6dc244da38d6d4e3987f88b43Z2uXXAl_VTXU7QLJ95N-wQ__xDggZsuK37_26NTMryswRbHWNoIVSoSTa8UA7WPb"
         });

            //agregar el nuevo marker
            markers.addLayer(marker);

            //buscador de direcciones
            const buscador = document.querySelector('#formbuscador');
            buscador.addEventListener('blur', buscarDireccion);

        //detectar el movimiento del marker
        marker.on('moveend', function(e)
        {
            //console.log('soltaste el poin');
            //console.log(e.target);
            marker = e.target;
            const posicion = marker.getLatLng();
            //console.log(posicion);
            //centrando el mapa
            mapa.panTo( new L.LatLng(posicion.lat, posicion.lng));

            //crear un reverse geocoding cuando el usuario mueve el pin
            geocodeService.reverse().latlng(posicion, 16).run(function(error, resultado)
            {
                //console.log(error);
                //console.log(resultado.address);
                marker.bindPopup(resultado.address.LongLabel);
                marker.openPopup();

                //llenar inputs
                llenarInputs(resultado);
            })
        });

            reubicarPin(marker);

            function reubicarPin(marker)
            {
                //detectar el movimiento del marker
                    marker.on('moveend', function(e)
                    {
                        //console.log('soltaste el poin');
                        //console.log(e.target);
                        marker = e.target;
                        const posicion = marker.getLatLng();
                        //console.log(posicion);
                        //centrando el mapa
                        mapa.panTo( new L.LatLng(posicion.lat, posicion.lng));

                        //crear un reverse geocoding cuando el usuario mueve el pin
                        geocodeService.reverse().latlng(posicion, 16).run(function(error, resultado)
                        {
                            //console.log(error);
                            //console.log(resultado.address);
                            marker.bindPopup(resultado.address.LongLabel);
                            marker.openPopup();

                            //llenar inputs
                            llenarInputs(resultado);
                        })

                    });
            }

        //funcion para el buscador de direccion
        function buscarDireccion(e)
        {
            //alert('hola');
            //console.log(provider)
            if(e.target.value.length > 10)
            {
                provider.search({query: e.target.value })
                .then( resultado => {
                    if( resultado )
                    {
                        //limpiar los pines previos
                        markers.clearLayers();

                        geocodeService.reverse().latlng(resultado[0].bounds[0], 16).run(function(error, resultado)
                        { 
                            //llenar inputs
                            llenarInputs(resultado);

                            //centrar el mapa
                            mapa.setView(resultado.latlng)
                            
                            //Agregar el pin
                            marker = new L.marker(resultado.latlng, {
                                draggable: true,
                                autoPan: true
                            }).addTo(mapa);

                            //agregar el nuevo marker
                            markers.addLayer(marker);

                            //mover el pin
                            reubicarPin(marker);
                        })
                    }
                    //console.log(resultado[0].bounds[0]);
                })
            }
            
        }

        //funcion para llenar los inputs
        function llenarInputs(resultado)
        {
            //console.log(resultado);
            document.querySelector('#direccion').value = resultado.address.Address || '';
            document.querySelector('#colonia').value = resultado.address.Neighborhood || '';
            document.querySelector('#lat').value = resultado.latlng.lat || '';
            document.querySelector('#lng').value = resultado.latlng.lng || '';
        }
    }
});
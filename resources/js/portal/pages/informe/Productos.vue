<template>
       <div class="p-grid">
        <div class="p-col-12 p-xl-6 p-m-auto p-ac-center position-relative p-mb-5" v-for="(item, index) in datos" :key="index">
            <router-link :to="{name: 'servicios', params: { idProducto: item.CODIGO_PRODUCTO } }" >
                <div class="p-shadow-7 cursor-pointer">
                <img src="http://72.167.226.188/~oqmdev/portalcenpromype/wp-content/uploads/banner-informes.png" style="width:100%;height:auto;opacity:0.15">
                    <div  class="position-absolute position-absolute-center p-h-100">
                        <div  class="d-flex p-ai-center p-h-100">
                            <h2 class="p-m-auto">
                            {{ item.NOMBRE_PRODUCTO }}
                        </h2>
                        </div>
                        
                    </div>
                </div>
            </router-link>
            
        </div>
    </div>
</template>

<script>
import apiPortal from '../../components/apiPortal'; /** en api portal se define la base */
import card from 'primevue/card';
export default {
    data() {
        return { 
            datos: [],
            cantidadProductos: 100
        }
    },
      mounted() {
            this.cargarProductos(this.$route.params.idSector);
        },
    methods: {
        cargarProductos(sector) {
               const productoApi = `api/vista/productos/${sector}`;
                window.cargando();
                apiPortal.get(productoApi, { params: { rows: this.cantidadProductos } } )
                .then((result) => this.datos = result.data.data)
                .finally( _ => { window.swal.close() } );
        }
    },
    components: {
        card
    }
}
</script>

<style>

</style>
<template>
    <div class="p-grid">
        <div class="p-col-4 p-m-auto p-ac-center position-relative p-mb-5" v-for="(item, index) in datos" :key="index">
          
               <card class="informe">
                 <template #header>
                        <img style="width:100%;height:auto" :src="'http://72.167.226.188/~oqmdev/portalcenpromype/' + item.IMAGEN">
                    </template>
                    <template #title>
                        <h3 class="titulo"> {{ item.NOMBRE_DOCUMENTO }} </h3>
                     </template>
                       <template #content>
                        <p class="p-text-white"> {{ item.DESCRIPCION_DOCUMENTO }} </p>
                     </template>
               </card>
          
            
        </div>
    </div>
</template>

<script>
import card from 'primevue/card';
import apiPortal from '../../components/apiPortal'; /** en api portal se define la base */
export default {
    data() {
        return {
            datos: []
        }
    },
    methods: {
        cargarInformes(codigoProducto, codigoServicio) {
            window.cargando();
            const informesApi = `api/vista/informes/${codigoProducto}/${codigoServicio}`;
            apiPortal.get(informesApi).then((result) => this.datos = result.data).finally( _ => window.swal.close() )
        }
    },
    mounted() {
        const { idServicio, idProducto } = this.$route.params;
        this.cargarInformes( idServicio, idProducto );
    },
    components: {
        card
    }
}
</script>

<style lang="scss" scoped>
   @import  '../../../../sass/_variables.scss';
  .informe .titulo { color: $cenpromype-secondary }
  .informe { background-color: $cenpromype-primary }

</style>
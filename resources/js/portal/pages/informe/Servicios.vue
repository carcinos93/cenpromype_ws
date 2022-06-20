<template>
  <div class="p-grid">
        <div class="p-col-12 p-xl-6 p-m-auto p-ac-center position-relative p-mb-5" v-for="(item, index) in datos" :key="index">
            <router-link :to="{name: 'informes', params: { idServicio: item.CODIGO_SERVICIO, idProducto: idProducto  } }" >
                <div class="p-shadow-7 cursor-pointer">
                <img src="http://72.167.226.188/~oqmdev/portalcenpromype/wp-content/uploads/banner-informes.png" style="width:100%;height:auto;opacity:0.15">
                    <div  class="position-absolute position-absolute-center p-h-100">
                        <div class="d-flex p-ai-center p-h-100"> 
                            <h2 class="p-m-auto">
                            {{ item.NOMBRE_SERVICIO }}
                            <br/>
                            <small v-if="item.TOTAL_DOCUMENTOS == 0">

                                 (Próximamente)
                            </small>
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
export default {
  data() {
    return {
      datos: [],
      cargando: false,
      idProducto: null
    };
  },
  methods: {
      cargarServicios(producto) {
            window.cargando();
            const serviciosApi = `api/vista/servicios/${producto}`;
            apiPortal.get(serviciosApi).then((result) => this.datos = result.data ).finally( _ => { window.swal.close(); this.cargando = false } );
      }
  },
  mounted() {
    this.idProducto =  this.$route.params.idProducto;
    this.cargarServicios( this.idProducto )
  }

}
</script>

<style>

</style>
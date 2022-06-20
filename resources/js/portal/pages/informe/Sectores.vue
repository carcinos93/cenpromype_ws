<template>
    <div class="p-grid">
        <div class="p-col-12 p-xl-6 p-m-auto p-ac-center position-relative p-mb-5" v-for="(item, index) in datos" :key="index">
            <router-link :to="{name: 'productos', params: { idSector: item.CODIGO_SECTOR } }" >
                <div class="p-shadow-7 cursor-pointer">
                <img src="http://72.167.226.188/~oqmdev/portalcenpromype/wp-content/uploads/banner-informes.png" style="width:100%;height:auto;opacity:0.15">
                    <div  class="position-absolute position-absolute-center p-h-100">
                              <div class="d-flex p-ai-center p-h-100"> 
                                <h2  class="p-m-auto">
                                {{ item.SECTOR_ECONOMICO }}
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
            cargando: false
        }
    },
    methods: {
        /**
         * Carga de sector
         */
        cargarSectores() {
            const sectoresApi = `api/vista/sectores`;
            this.cargando = true;
            window.cargando();
            apiPortal.get(sectoresApi).then((result) => {
               this.datos = result.data.map((v, i) => {
                /*v['IMAGEN'] = false;
                if (v.BANNER) {
                    let imgs = v.BANNER.split(",");
                    if (imgs.length > 0) {
                        v['IMAGEN'] = "" + imgs[0];
                    }
     
                }*/

                return v;
            });
            }).finally(_ => { this.cargando = false; window.swal.close(); });
           /* .map((v, i) => {
                return {
                    label: v.SECTOR_ECONOMICO,
                    dataItem: v,
                    command: () => {
                        this.seleccionarSector(i, v.CODIGO_SECTOR);
                    },
                };
            });*/
        },
    },
    mounted() {
        this.cargarSectores();
    }
}
</script>

<style>

</style>
<template>
    <div class="p-grid" v-show="!mostrarInforme">
        <div :class="cssClassMenu">
            <panel-menu :model="menu">
                <!--<template  v-slot:item="{ item }">


                        <span> {{ item.label }}  </span>
                        <template v-if="item.dataItem.TOTAL_DOCUMENTOS != undefined">
                            <br/>
                            <span v-if="item.dataItem.TOTAL_DOCUMENTOS == 0"> (Próximamente) </span>
                        </template>    

                </template>-->
         
            </panel-menu>
            <template v-if="cargandoMenu">
               <skeleton class="mb-2"></skeleton>
                    <skeleton width="100%" class="p-mb-2"></skeleton>
                    <skeleton width="80%" class="p-mb-2"></skeleton>
                    <skeleton height="50%" class="p-mb-2"></skeleton>
                    <skeleton width="75%" class="p-mb-2"></skeleton>
                    <skeleton width="75%" ></skeleton>
            </template>
            
        </div>
        <div :class="cssClassInformes">
                <div class="p-grid p-jc-center p-mt-3 p-w-100 ">
                        <template v-for="(informe, index) in informes" :key="index">
                        <div :class="cssClassLista" >
                            <div class="p-shadow-3 bg-azul p-h-100">
                                <div style="background-color:transparent">
                                <div class="p-grid p-m-0 cursor-pointer"  @click="verInforme(informe)">
                                  
                                        <slot name="imagen" :informe="informe" :index="index"> </slot>
                                        <slot name="contenido" :informe="informe" :index="index"></slot>
                                   
                                </div>
                                </div>
                            </div>
                        </div>
                        </template>
                </div>
            </div>
    </div>
    <informe-contenedor :url-pdf="urlPdf" v-on:afterLoad="afterLoadInforme" v-on:regresar="regresarInforme" :url="urlInforme" elemento-to=".ast-container" />
    <!--<div class="bg-white contendor-iframe">
            <div class="p-d-block p-mt-5" v-if="mostrarInforme">
                <div class="p-grid p-jc-end pointer-click">
                    <div class="p-col-6 p-md-2">
                        <div class="p-grid">
                            <div class="p-col">
                                <i class="pi pi-file-pdf"></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-print "></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-envelope"></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-arrow-circle-left ejecutar-evento" v-on:click="regresar"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <iframe id="frameDocumento" frameborder="0" v-on:load="cargaDocumento" style="overflow:hidden !important;width:100%;" v-bind:height="alturaDocumento" width="" v-bind:src="urlInforme"></iframe>
        </div>-->
</template>
<script>
import PanelMenu from "primevue/panelmenu";
import skeleton from "primevue/skeleton";
import InformeContenedor from '../components/controls/InformeContenedor.vue';
import apiPortal from '../components/apiPortal'; /** en api portal se define la base */
export default {
    props: {
        urlapi: { required: true },
        urlbase: {  required: true },
        cantidadProductos: { required: false, default: 100 },
        cssClassMenu: { default: '' },
        cssClassInformes: { default: '' },
        cssClassLista: {defualt: ''}
    },
    data() {
        return {
            menu: [],
            informes: [],
            cargandoMenu: false,
            mostrarInforme: false,
            urlInforme: "",
            urlPdf: "",
            alturaDocumento: 0
            // urlapi: this.urlapi
        };
    },
    mounted() {
        (async () => {
            await this.cargarSectores();
        })();
    },
    methods: {
        afterLoadInforme() {
            if (window.jQuery) {
                window.jQuery("#content #primary").addClass("p-hidden");
            }
        },
        regresarInforme() {
            /*this.mostrarInforme = false;
            this.alturaDocumento = `0`;
            this.urlInforme = '';*/
            this.urlInforme = "";
            this.urlPdf = "";
            window.jQuery("#content #primary").removeClass("p-hidden");

        },
        verInforme(informe) {
                /** Este informe no usa Axios */
                
           
                this.urlInforme = `${this.urlapi}vistas/documento/${informe.CODIGO_DOCUMENTO}`;
                if (informe.RUTA_DOCUMENTO  && informe.RUTA_DOCUMENTO != '')
                {
                    this.urlPdf = `${this.urlbase + informe.RUTA_DOCUMENTO}`; /** el documento PDF es local en wordpress */
                } else {
                    this.urlPdf = '';
                }
                
               
                //window.cargando();

        },
        cargaDocumento(e) {
            if (this.urlInforme != '') {
                setTimeout(() => {
                    if (window.jQuery) {
                        window.jQuery("#content .elementor-section .elementor-container").addClass("max-w-100");
                    }                
                    const domDocumento = window.jQuery("#frameDocumento");
                    let altura = domDocumento.contents().height();
                    this.alturaDocumento = `${altura}px`;
                    this.mostrarInforme = true;
                    window.swal.close();
                }, 1500)
               
            }
        },
        /**
         * Carga de sector
         */
        async cargarSectores() {
            const sectoresApi = `api/vista/sectores`;
            this.cargandoMenu = true;
            window.cargando();
            this.menu = (await apiPortal.get(sectoresApi).finally(_ => { this.cargandoMenu = false; window.swal.close(); })).data.map((v, i) => {
                return {
                    label: v.SECTOR_ECONOMICO,
                    dataItem: v,
                    command: () => {
                        this.seleccionarSector(i, v.CODIGO_SECTOR);
                    },
                };
            });
        },
        /**
         * arr => this.menu
         */
        seleccionarSector(indiceSector, codigoSector) {
            (async () => {
                if ((this.menu[indiceSector].items ?? []).length == 0) {
                    this.menu[indiceSector].items = (
                        await this.cargarProductos(codigoSector, indiceSector)
                    ).map((v, indiceProducto) => {
                        return {
                            label: v.NOMBRE_PRODUCTO,
                            dataItem: v,
                            command: () => {
                                this.seleccionarProducto(
                                    indiceProducto,
                                    indiceSector,
                                    v.CODIGO_PRODUCTO,
                                    codigoSector
                                );
                            },
                        };
                    });
                }
            })();
        },
        /**
         * sector
         * arr => this.menu[indice].items
         */
        async cargarProductos(sector, indiceSector) {
            const productoApi = `api/vista/productos/${sector}`;
            window.cargando();
            return (await apiPortal.get(productoApi, { params: { rows: this.cantidadProductos } } )
            .finally( _ => window.swal.close() ))
            .data
            .data;
        },
        /**
         *  arr => this.menu[indice].items
         */
        seleccionarProducto(indiceProducto, indiceSector,codigoProducto,codigoSector) {
            (async () => {
                if ((this.menu[indiceSector].items[indiceProducto].items ?? []).length == 0) {
                    this.menu[indiceSector].items[indiceProducto].items = (
                        await this.cargarServicios(
                            codigoProducto,
                            codigoSector,
                            indiceSector,
                            indiceProducto
                        )
                    ).map((v, i) => {
                        return {
                            label: `${v.NOMBRE_SERVICIO} ${v.TOTAL_DOCUMENTOS == 0 ? "(Próximamente)" : ""} `,
                            dataItem: v,
                            escape: true,
                            command: () => {
                                this.cargarInformes(
                                    v.CODIGO_SERVICIO,
                                    codigoProducto
                                );
                            },
                        };
                    });
                }
            })();
        },

        async cargarInformes(codigoServicio, codigoProducto) {
            window.cargando();
            const informesApi = `api/vista/informes/${codigoProducto}/${codigoServicio}`;
            this.informes = (await apiPortal.get(informesApi).finally( _ => window.swal.close() )).data;
        },
        /**
         * producto
         * arr => this.menu[indice].items[indice].items
         */
        async cargarServicios(producto) {
            window.cargando();
            const serviciosApi = `api/vista/servicios/${producto}`;
            return (await apiPortal.get(serviciosApi).finally( _ => window.swal.close() )).data;
        },
    },
    components: {
        PanelMenu,
        skeleton,
        InformeContenedor
    },
};
</script>

<style>
      
        .cursor-pointer {  cursor:pointer }
        .informe .bg-azul > div:hover {  background-color: rgba(255, 255, 255, 0.35) !important;  }
</style>

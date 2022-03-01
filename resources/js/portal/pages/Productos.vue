<template>
    <div class="p-grid p-jc-end">
        <div class="p-col-9">
            <div class="p-fluid p-formgrid p-grid p-text-center">
                <div class="p-col-12 p-col-md p-field">
            
                        <div class="p-inputgroup">
                             <input-text placeholder="Buscar" />
                            <span
                                class="p-inputgroup-addon bg-azul p-text-white">
                                <i class="pi pi-search"></i>
                            </span>
                        </div>
                  
                </div>
                <div class="p-col-12 p-col-md p-field">
                        <select-control label="Selecciona una opción" />
                </div>
                <div class="p-col-12 p-col-md p-field">
                        <div class="btn-dinamico btn-2 p-d-flex p-text-center">
                            <span class="p-w-100"> Recursos gratuitos </span>
                        </div>
                </div>
            </div>
        </div>
        <div class="p-col-12">
            <div id="listaProductos"></div>
        </div>
        <div class="p-col-12">
            <h2>¿QUÉ DESEAS BUSCAR?</h2>
        </div>
        <div class="p-col-12">
            <div class="p-grid p-w-100 p-shadow-7 bg-white">
                <servicios
                    @onClick="onClickServicio(item, event)"
                    :url="servicioUrl"
                    css-class-lista="p-col-12 p-md-4 p-pt-0">
                    <template v-slot:default="slot">
                        <div class="p-text-center">
                            <a :class="[slot.isActive ? 'bg-naranja p-text-white': '', 'elementor-icon navegar-servicio p-border-2 p-shadow-7 p-pt-2 p-pt-lg-4']" href="javascript:void(0)">
                                <div class="p-mb-3 p-mr-5 p-ml-5 p-text-center">
                                    <img
                                        :src="urlBase + slot.item.LOGO"
                                        style="max-width: 100%; height: auto"
                                    />
                                </div>
                                <div class="p-d-block">
                                    <div style="
                                            font-size: 1.4rem;
                                            line-height: 1.5rem;
                                            display: inline-table;">
                                        <div style="display: table-caption">
                                            <span class="p-text-bold">
                                                {{ slot.item.NOMBRE_SERVICIO }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </template>
                </servicios>
            </div>
        </div>
        <div class="p-col-12">

             <servicios
                    @onClick="onClickInformes(item, event)"
                    :url="informesApiUrl"
                    css-class-lista="p-col-4">
                    <template v-slot:default="slot">
                         <div class="p-card documento-visor bg-azul"  style="height:100%; "  >
                            <div style="background-color: transparent;" class="p-h-100"> 
                            <div class="p-card-header p-text-center">
                            <img class="p-mt-4" :src="urlBase + slot.item.IMAGEN"/>
                        </div>
                        <div class="p-card-body">
                        <div class="p-card-title color-naranja">
                              {{ slot.item.CODIGO_DOCUMENTO }}
                           </div>
                        <div class="p-card-content p-text-white">

                            {{ slot.item.DESCRIPCION_DOCUMENTO }}
                       </div>
                       <div class="p-card-footer p-text-white">
                           <span class="p-p-2" style="background-color: #f38a1e">Ver mas</span>
                       </div>
                            </div>
                        </div>  
                    </div>
                    </template>
                </servicios>

                
        </div>
        <!--
            v-on:afterLoad="afterLoadInforme" 
                v-on:regresar="regresarInforme" 
         -->
        <div class="p-col-12">
            <informe-contenedor :url-pdf="informe.pdf"  v-on:regresar="regresarInforme"  :url="informe.html" elemento-to=".ast-container" />
        </div>
    </div>
</template>

<script>
import Servicios from "./Servicios.vue";
import InputText from "primevue/inputtext";
import SelectControl from "../components/controls/Select";
import InformeContenedor from '../components/controls/InformeContenedor.vue';
export default {
    components: { Servicios, InputText, SelectControl, InformeContenedor },
    props: {
        svg: { required: true },
        dataSource: { required: true },
        noSelectColor: { required: false, default: "#173051ff" },
        selectColor: { required: false, default: "#F8911A" },
        loading: { required: true },
        rows: { required: false, default: 5 },
        width: { default: 45 },
        height: { default: 45 },
        urlBase: { required: true },
        idsector: { required: true },
    },
    data() {
        return {
            servicioUrl: "",
            informesApiUrl: "",
            codigoProducto: 0,
            informe: { pdf: "", html: "" }
        };
    },
    methods: {
        onClickServicio(item) {
            this.informesApiUrl = `api/informes/${this.codigoProducto}/${item.CODIGO_SERVICIO}`;
        },

        onClickInformes(item) {
            this.informe = { html: `vistas/documento/${item.CODIGO_DOCUMENTO}`, pdf: `${this.urlBase}${item.RUTA_DOCUMENTO}`  };
            console.log(this.informe);
        },
        regresarInforme() {
            this.informe = {  pdf : "", html : "" };
        }
    },
    mounted() {
        /**
         * {
            svg:  $this.rutaSvg,
            dataSource: {
                url: window.url_laravel + "api/vista/productos/" + idSector
            },
            noSelectColor: "#173051ff",
            selectColor: "#F8911A",
			loading: '{{ Wordpress::uploads("js/load.gif") }}',
            rows: 5,
            width: 45,
            height:45,
            urlBase: "{{Wordpress::index()}}",
        }
         */
        let $this = this;
        let propiedades = {};

        propiedades = {
            dataSource: { url: $this.dataSource },
            svg: $this.svg,
            noSelectColor: $this.noSelectColor,
            selectColor: $this.selectColor,
            loading: $this.loading,
            rows: $this.rows,
            width: $this.width,
            height: $this.height,
            urlBase: $this.urlBase,
        };

        propiedades.onClickItem = function (event, data) {
            $this.servicioUrl = `api/vista/servicios/${data.CODIGO_PRODUCTO}`;
            $this.codigoProducto = data.CODIGO_PRODUCTO;
        };
        window.jQuery("#listaProductos").carusel(propiedades);
    },
};
</script>

<style>
.p-dropdown-trigger {
    background-color: #144a6d !important ;
}
</style>

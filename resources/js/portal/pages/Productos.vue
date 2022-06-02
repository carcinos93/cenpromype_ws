<template>

    <Dialog position="bottom" v-model:visible="display">
    <template #header>
		
	</template>
    <div>
         <p>
                {{ mensaje_dialogo }}
        </p>
    </div>

        <template #footer>
        <Button class="p-button-primary" label="ok" @click="display=false" icon="pi pi-check" />
	</template>
    </Dialog>
    <div class="p-grid p-jc-end">
        <div class="p-col-9 p-hidden">
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
            <div class="p-grid p-w-100 p-shadow-7 bg-white p-jc-center" id="servicios-lista">
                <servicios
                    @onclickitem="onClickServicio($event)"
                    :url="servicioUrl"
                    css-class-lista="p-col-6 p-md-4 p-pt-0">
                    <template v-slot:default="slot">
                        <div class="p-text-center">
                            <a style="text-decoration:none !important;width:60%;height:100%" :class="[slot.isActive ? 'bg-naranja p-text-white': '', 'elementor-icon navegar-servicio p-border-2 p-shadow-7 p-pt-2 p-pt-lg-1']" href="javascript:void(0)">
                                <div class="p-pl-5 p-pr-5 p-pb-3 p-pt-3 p-text-center">
                                    <img
                                        :src="urlBase + slot.item.LOGO"
                                        style="width: 100%; height: auto"
                                    />
                                </div>
                                <div class="p-d-block p-mr-2 p-ml-2">
                                    <div style="font-size: 1.4rem;
                                            line-height: 1.5rem;
                                            display: inline-table;">
                                        <!-- 
                                            -->
                                        <div style="display: table-caption" class="p-text-center">
                                            <!-- display: table-caption -->
                                            <span class="p-text-bold">
                                                {{ slot.item.NOMBRE_SERVICIO }}
                                            </span>
                                           <span v-if="slot.item.TOTAL_DOCUMENTOS == 0"> <small> (Próximamente) </small> </span>
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
            <div class="p-grid p-jc-center" id="informes-lista">
            <servicios
                    @onclickitem="onClickInformes($event)"
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
                              INFORME N°{{ slot.item.CODIGO_DOCUMENTO }}
                           </div>
                        <div class="p-card-content p-text-white">

                            <span>{{ slot.item.DESCRIPCION_DOCUMENTO }}</span> 
                          
                       </div>
                       <div class="p-card-footer p-text-white">
                           <span class="p-p-2" style="background-color: #f38a1e">Ver más</span>
                       </div>
                            </div>
                        </div>  
                    </div>
                    </template>
                </servicios>
            </div>
        
        </div>
        <!--
            v-on:afterLoad="afterLoadInforme" 
                v-on:regresar="regresarInforme" 
         -->
      
    </div>
      <div class="p-grid">
        <div class="p-col-12">
            <informe-contenedor :informe="informeItem" :url-pdf="informe.pdf"  v-on:regresar="regresarInforme"  :url="informe.html" elemento-to=".ast-container" />
        </div>
    </div>
</template>

<script>
import Servicios from "./Servicios.vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import SelectControl from "../components/controls/Select";
import InformeContenedor from '../components/controls/InformeContenedor.vue';
import Dialog from 'primevue/dialog';
export default {
    components: { Servicios, InputText, SelectControl, InformeContenedor, Dialog,Button },
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
        isLogged: { default: 0 },
        enlaceRegistro: {  },
        propiedadesSector: {  }
    },
    data() {
        return {
            display: false,
            servicioUrl: "",
            informesApiUrl: "",
            codigoProducto: 0,
            informe: { pdf: "", html: "" },
            informeActivo: false,
            mensaje_dialogo: "",
            acceso: { default: '00' },
            informeItem: { default: {} }
        };
    },
    methods: {
        onClickServicio(item) {
            //if (item.TOTAL_DOCUMENTOS == 0) { return; } 
            this.informesApiUrl = `api/vista/informes/${this.codigoProducto}/${item.CODIGO_SERVICIO}`;
            if (window.scrollLocal) {
                window.scrollLocal("#informes-lista");
            }
        },

        onClickInformes(item) {
                this.informeItem = item;
              if (!this.isLogged) {
                    this.mensaje_dialogo = `Para ver este informe lo invitamos a registrarse e iniciar sesión.`;
                    this.display = true;
                    return;
                }     
                 if ("05 10".includes(item.ACCESO) && this.acceso == "00") {
                    if (this.isLogged) {
                        this.mensaje_dialogo = `Para ver este informe lo invitamos a suscribirse al plan nivel ${item.ACCESO == "05" ? "1" : "2"}`;
                    } else {
                          this.mensaje_dialogo = `Para ver este informe lo invitamos registrarse y suscribirse a un plan`;
                    }
                    this.display = true;
                     return;
                } else if ( item.ACCESO == "10" && this.acceso != "2" ) {
                    this.mensaje_dialogo = `Para ver este informe suscribirse al plan nivel ${item.ACCESO == "05" ? "1" : "2"}`;
                    this.display = true;
                    return;
                }


            this.informe = { html: `${window['url_api']}vistas/documento/${item.CODIGO_DOCUMENTO}`, pdf: `${this.urlBase}${item.RUTA_DOCUMENTO}`  };
            this.informeActivo = true;

			if (window.jQuery) {
                     window.jQuery("#navegacion-ruta").data('breadcrumb').addItem({
                            label: `INFORME N° ${item.CODIGO_DOCUMENTO}`,
                            id: 'informe'
                    });
                    window.jQuery("#informe-ruta").prepend( window.jQuery("#navegacionRutaContenedor") );
			}

            this.ocultarContedor();
        },  
        regresarInforme() {
            this.informe = {  pdf : "", html : "" };
            this.informeActivo = false;

              if (window.jQuery) {
                window.jQuery("#primary").prepend( window.jQuery("#navegacionRutaContenedor") );
                window.jQuery("#navegacion-ruta").data('breadcrumb').remove("#informe");
            }

            this.ocultarContedor();
             if (window.scrollLocal) {
                window.scrollLocal("#informes-lista");
            }
           
        },
        ocultarContedor() {
            if (this.informeActivo) {
                window.jQuery("#primary").addClass("p-hidden");
            } else {
                 window.jQuery("#primary").removeClass("p-hidden");
            }
        }
    },
    mounted() {
        
        this.acceso = window.jQuery("#acceso").val();

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
            hoverColor: $this.selectColor,
            loading: $this.loading,
            rows: $this.rows,
            width: $this.width,
            height: $this.height,
            urlBase: $this.urlBase,
        };

        propiedades.onClickItem = function (event, data) {
            $this.servicioUrl = `api/vista/servicios/${data.CODIGO_PRODUCTO}`;
            $this.codigoProducto = data.CODIGO_PRODUCTO;
            if (window.scrollLocal) {
                window.scrollLocal("#servicios-lista");
            }
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

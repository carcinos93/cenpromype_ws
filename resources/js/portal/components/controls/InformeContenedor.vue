<template>

    <div id="informeContenedor" v-show="mostrarInforme">
        <div   class="bg-white contendor-iframe">
            <div class="p-d-block p-mt-5" >
                <div class="p-grid p-jc-end pointer-click">
                    <div id="informe-ruta" class="p-col-6 p-md-9 p-lg-10 p-pl-5"></div>
                    <div class="p-col-6 p-md-3 p-lg-2">
                        <div class="p-grid">
                            <div class="p-col">
                                <i  v-bind:class="[ 'pi', 'pi-file-pdf', { 'p-disabled' : urlPdf == '' }  ]"  @click="informePDF"></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-print" v-on:click="imprimir"></i>
                            </div>
                            <!--<div class="p-col">
                                <i class="pi pi-envelope"></i>
                            </div>-->
                            <div class="p-col">
                                <i class="pi pi-arrow-circle-left ejecutar-evento" id="regresarBtn" @click="regresar"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <iframe id="frameDocumento"  frameborder="0" v-on:load="cargarDocumento" v-bind:style="{ height: alturaDocumento }" v-bind:src="urlInforme"></iframe>
        </div>
    </div>
   
</template>

<script>
import axios from 'axios';
export default {
    props: {
        url: { required: true, default: '' },
        elementoTo: { required: false, default: '' },
        urlPdf: { required: false, default: '' },
        informe: { required: false, default: {} }
    },
    data() {
        return { 
            mostrarInforme: false,
            alturaDocumento: '0px',
            urlInforme: ''
         }
    },
    watch: {
        url(value) {
            if (value != '') {
                this.urlInforme = value;
                if (window.cargando) window.cargando();
                this.$emit("beforeLoad");
            }
            
        }
    },
    methods: {
        imprimir() {
            const iframe = document.getElementById("frameDocumento");
            if (iframe.contentWindow) {
                iframe.contentWindow.print();
            }
           
        },
        regresar() {
            this.alturaDocumento = '0px';
            this.urlInforme = '';
            this.$emit('regresar');
            this.mostrarInforme = false;
            /** se mueve la barra de navegación al contenedor principal */

        },
        informePDF() {
            if (this.urlPdf != '' && this.urlPdf)
            {
                this.urlInforme = this.urlPdf;
                this.alturaDocumento = '75vh';
            }

        },
        registrarDescarga() {
            if (this.informe) {
                if (window.wpApiSettings) {
                axios.post(`${window['local_url']}/wp-json/inteligenciabi/v1/usuario-descarga`, 
                    { "documento" : this.informe.DESCRIPCION_DOCUMENTO }, { headers: { "X-WP-Nonce": window.wpApiSettings.nonce } })
                .then().catch((error) => console.log(error));

                }
            }

        },
        cargarDocumento(elemen) {
            if (this.urlInforme.includes(".pdf") ) return;
            if (this.urlInforme != '') {
                this.mostrarInforme = true;
                this.registrarDescarga();
                this.$emit('afterLoad');
                setTimeout(_ => {
                    if (window.jQuery)  {
                        let domDocumento = window.jQuery("#frameDocumento");    
                        let altura = domDocumento.contents().height() + 35;
                         this.alturaDocumento = `75vh`;
                        /*if (this.urlInforme.includes(".htm")) {
                             this.alturaDocumento = `75vh`;
                        } else {
                                this.alturaDocumento = `${altura}px`;
                        }*/
                      
            
                        if (window.swal) { window.swal.close() };
                    } else {
                        console.warn("jQuery es requerido");
                    }  
                    
        
                   
                }, 1500);
               
            }
        }
    },
    mounted() {
        if (this.elementoTo ?? "" == "") {  return; }
        let elemento = this.elementoTo.replace(/[\.\#]/g, "");
        if ( this.elementoTo.indexOf(".") >= 0 ) {
           if( document.getElementsByClassName( elemento )) {
               document.getElementsByClassName(elemento)[0].appendChild( document.getElementById("informeContenedor") );
           }
        } 

        if (this.elementoTo.indexOf("#") >= 0) {
            if (document.getElementById( elemento )) {
            document.getElementById(elemento).appendChild( document.getElementById("informeContenedor"));
            }
        }


        
    },
    components: {
        
    }
}
</script>

<style scoped>
    #contendor-iframe { widows: 100%; height:100% }
    #frameDocumento  { overflow:hidden !important;width:100%; }
    #informeContenedor { width: 100%; }

    #informeContenedor .pi { font-size: 1.5rem; cursor: pointer; }
</style>
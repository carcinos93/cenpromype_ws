<template>
    <div id="informeContenedor" v-show="mostrarInforme">
        <div   class="bg-white contendor-iframe">
            <div class="p-d-block p-mt-5" >
                <div class="p-grid p-jc-end pointer-click">
                    <div class="p-col-6 p-md-2">
                        <div class="p-grid">
                            <div class="p-col">
                                <i  v-bind:class="[ 'pi', 'pi-file-pdf', { 'p-disabled' : urlPdf == '' }  ]"  @click="informePDF"></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-print"></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-envelope"></i>
                            </div>
                            <div class="p-col">
                                <i class="pi pi-arrow-circle-left ejecutar-evento" id="regresarBtn" @click="regresar"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <iframe id="frameDocumento" frameborder="0" v-on:load="cargarDocumento" v-bind:style="{ height: alturaDocumento }" v-bind:src="urlInforme"></iframe>
        </div>
    </div>
   
</template>

<script>
export default {
    props: {
        url: { required: true, default: '' },
        elementoTo: { required: false, default: '' },
        urlPdf: { required: false, default: '' }
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
        regresar() {
            this.alturaDocumento = '0px';
            this.urlInforme = '';
            this.$emit('regresar');
            this.mostrarInforme = false;
        },
        informePDF() {
            if (this.urlPdf != '' && this.urlPdf)
            {
                this.urlInforme = this.urlPdf;
                this.alturaDocumento = '75vh';
            }

        },
        cargarDocumento(elemen) {
            if (this.urlInforme.includes(".pdf") ) return;
            if (this.urlInforme != '') {
                this.mostrarInforme = true;
                this.$emit('afterLoad');
                setTimeout(_ => {
                    if (window.jQuery)  {
                        let domDocumento = window.jQuery("#frameDocumento");    
                        let altura = domDocumento.contents().height() + 35;
                        this.alturaDocumento = `${altura}px`;
            
                        if (window.swal) { window.swal.close() };
                    } else {
                        console.warn("jQuery es requerido");
                    }  
                    
        
                   
                }, 1500);
               
            }
        }
    },
    mounted() {
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
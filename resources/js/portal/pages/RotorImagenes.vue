<template>
    <div ref="contenedorRotor">
        <carousel v-bind:class="{ noBotones: deshabilitarBotones }" :autoplayInterval="tiempo" :value="imagenesArr" :numVisible="1" :numScroll="1" >
        <template #item="slotProps">
            <div style="width: 100%;position: relative">
                <slot name="texto" :data="slotProps.data">
                    <p>  {{ slotProps.data.texto }}</p>
                </slot>
                <img :src="urlbase + slotProps.data.imagen" style="max-width: 100%; width:100%; height: auto">
            </div>
        </template>
        </carousel>
    </div>
    
</template>

<script>
import Carousel from 'primevue/carousel';
import apiPortal from "../components/apiPortal";
export default {
    props: { imagenes: { default: null }, urlbase: { default: '' }, deshabilitarBotones: { default: false },
    tiempo: { default: 2000 },
    elementoTo: { default: '' }
    },
    data() {
        return  {
            imagenesArr: []
        }
    },
    created() {
          this.$nextTick(function() { // lazy
            if (this.$slots.imagenes) {
               let elementos =  this.$slots.imagenes()[0].children ?? [];
                this.imagenesArr = elementos.map((v, i) => {
                    return { imagen:  v.children.trim(), texto: ''  }
                });
                
            }

        });
    },
    methods: {
    moverElemento() {
         if (this.elementoTo) {
                let elemento = this.elementoTo.replace(/[\.\#]/g, "");
                if ( this.elementoTo.indexOf(".") >= 0 ) {
                if( document.getElementsByClassName( elemento )) {
                    document.getElementsByClassName(elemento)[0].prepend( this.$refs.contenedorRotor );
                }
                } 

                if (this.elementoTo.indexOf("#") >= 0) {
                    if (document.getElementById( elemento )) {
                    document.getElementById(elemento).prepend( this.$refs.contenedorRotor );
                    }
                }
         }
         
    },
    lookupData() {
        this.imagenesArr.forEach((v, i) => {
            if (v.lookup) {
                let lookup = v.lookup;
                let url = lookup.url;
                apiPortal.get( url, { params: lookup.params } ).then((response) => {
                    v['lookup']  = response.data;
                } ).catch((error) => console.log(error));
            }
          
            
        });
    }
    },
    
    mounted() {
        try {

            if (typeof this.imagenes == "object") {
                this.imagenesArr = this.imagenes;
            } else if (typeof this.imagenes == "string") {
                if (this.imagenes.includes(",") && this.imagenes.includes("[")) {
                     this.imagenesArr  = JSON.parse( this.imagenes );   
                } else {
                    this.imagenesArr = this.imagenes.split(",").map( (v, i) => { 
                                    return { imagen: v.trim(), texto: '' };
                        });
                }

            }
        } catch (error) {
            //en el caso que no sea un array string
            console.log("error en conversión de json: " , error);
        
        }
        this.lookupData();
        this.moverElemento();
    },
    components: {
        Carousel
    }
}
</script>

<style>
    .p-carousel.noBotones .p-carousel-next,   .p-carousel.noBotones .p-carousel-prev {
        display:none;
    }
</style>
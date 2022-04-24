<template>
    <carousel v-bind:class="{ noBotones: deshabilitarBotones }" :autoplayInterval="tiempo" :value="imagenesArr" :numVisible="1" :numScroll="1" >
        <template #item="slotProps">
            <div style="width: 100%" class="p-relative">
                <slot name="texto" :data="slotProps.data"></slot>
                <img :src="urlbase + slotProps.data.imagen" style="max-width: 100%; width:100%; height: auto">
            </div>
        </template>
    </carousel>
</template>

<script>
import Carousel from 'primevue/carousel';
export default {
    props: { imagenes: { default: '' }, urlbase: { default: '' }, deshabilitarBotones: { default: false },
    tiempo: { default: 2000 } },
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
                })
                
            }

        });
    },
    mounted() {
        try {
            this.imagenesArr  = JSON.parse( this.imagenes );   
        } catch (error) {
            //en el caso que no sea un array string
            this.imagenesArr = this.imagenes.split(",").map( (v, i) => { 
                return { imagen: v.trim(), texto: '' };
            } );
        }
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
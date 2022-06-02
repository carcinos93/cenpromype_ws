<template>
    <!---<div class="p-grid">-->
        <carousel :page="pagina" :circular="caruselopts.circular" :autoplayInterval="caruselopts.interval"
        :verticalViewPortHeight="caruselopts.height"
         style="width:100%" :value="items" orientation="vertical" 
         :numVisible="caruselopts.numVisible" :numScroll="caruselopts.numScroll">
            <template #item="slotProps">
                <slot :item="slotProps"></slot>
            </template>
            <template #footer>
                <paginator @page="onPage" v-model:first="offset" :rows="rows" :totalRecords="totalItems"></paginator>  
            </template>
        </carousel>
        <!-- p-col-12 p-md-6 p-mx-auto -->
        <!--<div :class="cssClass" v-for="(item, index) in items" :key="index" @click="clickNoticia(item)">
            <slot :item="item"></slot>
        </div>--->

    <!--</div>-->
  <!--<paginator @page="onPage" v-model:first="offset" :rows="rows" :totalRecords="totalItems"></paginator>-->
</template>

<script>
import Paginator from 'primevue/paginator';
import Carousel from 'primevue/carousel';
import apiPortal from '../components/apiPortal';
export default {
    props: {
        rows: { default: 5 }, 
        caruselopts:  { default: {numVisible: 2, numScroll: 1, interval: 5000, circular: true, height: '600px'} },
        urlbase: { default: ''  }, 
        cssClass: { default: '' },
        urlconfig: { default: { target: '_BLANK', urlkey: 'URL' } }
    },
    data() {
        return  {
        totalItems: 0,
        offset: 1,
        pagina: 1,
        items: []
        };
    },
    watch: {
        pagina(val) {
            console.log(val);
        }
    },
    mounted() {
        this.cargarDatos( {  first: this.offset,  rows: this.rows  })
    },
    methods: {
        clickNoticia(item) {
           if (item[this.urlconfig.urlkey]) {
               window.open( item[this.urlconfig.urlkey], this.urlconfig.target  );
           }

        },
        cargarDatos(event) {
            if (typeof window.loading == "function") {  window.loading();  }
            apiPortal.get(`${this.urlbase}`, { 
                params: { first: event.first , rows: event.rows }
            }).then((result) =>  {
                this.items = result.data.data,
                this.totalItems = result.data.total; 
            } )
            .catch((err) => { if (window.swal) window.swal.close(); console.log(err) })
            .finally(_ => { if (window.swal) window.swal.close() });
        },
        onPage(event) {
            this.cargarDatos(event);
          
        }
    },
    components: {
        Paginator,
        Carousel
    }
}
</script>

<style>

</style>
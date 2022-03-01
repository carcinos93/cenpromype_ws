<template>
    <div class="p-grid">
        <!-- p-col-12 p-md-6 p-mx-auto -->
        <div :class="cssClass" v-for="(item, index) in items" :key="index">
            <slot :item="item"></slot>
        </div>
    </div>
  <paginator @page="onPage" v-model:first="offset" :rows="rows" :totalRecords="totalItems"></paginator>
</template>

<script>
import Paginator from 'primevue/paginator';
import apiPortal from '../components/apiPortal';
export default {
    props: {
        rows: { default: 5 }, 
        urlbase: { default: ''  }, 
        cssClass: { default: '' } 
    },
    data() {
        return  {
        totalItems: 0,
        offset: 1,
        pagina: 1,
        items: []
        };
    },

    mounted() {
        this.cargarDatos( {  first: this.pagina,  rows: this.rows  })
    },
    methods: {
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
        Paginator
    }
}
</script>

<style>

</style>
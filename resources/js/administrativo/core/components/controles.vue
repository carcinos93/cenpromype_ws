<template>
        <label>
             {{ config.titulo }}
        </label>
        <template v-if="config.tipo == 'texto'">
               <p-inputtext @change="onchange($event)" v-model="value" @input="oninput" />
        </template>
          <template v-else-if="config.tipo == 'calendario'">
               <p-calendar @change="onchange($event)" v-model="value" @input="oninput" />
        </template>
           <template v-else-if="config.tipo == 'lista'">
               <p-dropdown :options="datosLista" option-label="DESCRIPCION" option-value="ID" @change="onchange($event)" v-model="value" />
        </template>
</template>

<script>
//import inputText from './controles/inputText.vue';
import inputtext from 'primevue/inputtext';
import calendar from 'primevue/calendar';
import dropdown from 'primevue/dropdown';
import apiLocal from '../../api/apiPortal';

export default {
    props:[ 'config', 'value' ],
  
    data() {
       return {
         datosLista : []
       }
    },
    mounted() {
        if (this.config.tipo == 'lista') {
            this.loadList();
        }
    },
    methods: {
        loadList() {
            let baseApi = '/cenpromype_ws/api';
            apiLocal.get(`${baseApi}/${this.config.origenDatos}`).then((result) => {
                this.datosLista = result.data;
            });
        },
        onchange(event) {
            this.$emit("onchange", event );
        },
        oninput(event) {
            this.$emit("oninput", event)
        }
    },
    components: {
        'p-inputtext' : inputtext,
        'p-calendar': calendar,
        'p-dropdown': dropdown
    }
}   
</script>

<style>

</style>
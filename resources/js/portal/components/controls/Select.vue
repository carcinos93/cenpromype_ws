<template>
  <Dropdown @input="handleInput" v-bind:class="cssclass" v-on:change="onChangeSelect" v-bind:loading="cargando" v-model="selectedItem" v-bind:options="itemsData" v-bind:optionLabel="descripcion" v-bind:placeholder="label" v-bind:optionValue="valor" />
</template>

<script>
import axios from 'axios';
import Dropdown from 'primevue/dropdown';
import { useI18n } from 'vue-i18n';
export default {
    props: { 
        label: { required: true }, 
        value: { default: 0 }, 
        inlineFunc: { default: ""  } , 
        cssclass: { default: "" }, 
        items: { default: [] }, 
        params: {  default: {} },
        datasource: { default: "" },
        descripcionCampo: { default: "descripcion" }, 
        valorCampo: {default: "id"},
        
     },
    data() {
        return  {
            itemsData: this.items,
            cargando: false,
            urlBase: '',
            selectedItem: null,
            descripcion: this.descripcionCampo,
            valor: this.valorCampo
        }
    },
   
    methods: {
        handleInput() {
             this.$emit('input', this.selectedItem);
        },
        cargarDatos(datasource, params) {
        this.cargando = true;
        if (datasource != "") {
            axios
                .get(this.urlBase + datasource, {  params: params })
                .then(response => {
                    let ob = {};
                        ob[ this.valor ] = 0;
                        ob[ this.descripcion ] = `(${this.$t("mensajes.seleccionar")})`;
                    this.itemsData = [ ob ];
                    this.itemsData.push( ...response.data);
                    this.cargando = false;
                    this.selectedItem = this.value;
                });
        } else {
            this.cargando = false;
            }
        },
        onChangeSelect: function(v) {

            if (this.inlineFunc != "") {
                if (typeof window[this.inlineFunc] == "function" ) {
                    window[this.inlineFunc]( this, v );
                }
            }
            this.$.emit('onchange', v); /** emite  una funcion de cambio */
        }
    },
    watch: {
        datasource(v) {
            this.cargarDatos(v, this.params);
            console.log(this.datasource);
        }, 
        params(v) {
            this.cargarDatos( this.datasource, v  );
        },
        items(v) {                
            this.itemsData = v ?? [];
        }
    },
    mounted() {
        this.cargarDatos(this.datasource, this.params);
        console.log(this.datasource);
    },
    setup() {
        return { $t: useI18n() }
    },
    components: {
        Dropdown
    }
}
</script>

<style>
 .p-dropdown-label { line-height: normal !important; }
</style>
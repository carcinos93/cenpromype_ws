
<template>

    <template v-if="multi">
        <!--  :optionGroupValue="isGroup ? groupValue : undefined"
              :optionValue="valor"
         -->
        <multi-select :class="cssclass" :filter="true" filter-placeholder="Buscar"
            @change="onChangeSelect($event)"
            @input="handleInput($event)"
            v-model="selectedItem"
            :options="itemsData"
            :optionLabel="descripcion"
            :loading="cargando"
            :optionGroupLabel="isGroup ? groupDesc ?? descripcion : undefined"
            :optionGroupChildren="isGroup ? 'items' : undefined">
            <template #option="{ option }">
                <span :data-especifique="option.HABILITAR_ENTRADA" :data-id="option.ID" class="p-item-custom"  >
                    {{ option.DESCRIPCION }}
                </span>
            </template>
          </multi-select>
    </template> 
    <template v-else>
          <dropdown :class="cssclass" :filter="true" filter-placeholder="Buscar"
                @change="onChangeSelect($event)"
                @input="handleInput($event)"
                v-model="selectedItem"
                :options="itemsData"
                :optionLabel="descripcion"
                :loading="cargando"
                :optionGroupLabel="isGroup ? groupDesc ?? descripcion : undefined"
                :optionGroupChildren="isGroup ? 'items' : undefined">
            <template #option="{ option }">
                <span :data-especifique="option.HABILITAR_ENTRADA" :data-id="option.ID" class="p-item-custom"  >
                    {{ option.DESCRIPCION }}
                </span>
            </template>
          </dropdown>
    </template> 
  <input-text @change="onchangeEspecifique($event)" class="p-mt-2" v-if="especifiqueVisible"  placeholder="Especifique" ref="entrada" />
</template>

<script>
import axios from 'axios';
import Dropdown from 'primevue/dropdown';
import MultiSelect from 'primevue/multiselect';
import InputText from 'primevue/inputtext';
import { h } from 'vue'
import { useI18n } from 'vue-i18n';
export default {
    props: { 
        label: { required: true }, 
        field: { required: false },
        value: { default: 0 }, 
        inlineFunc: { default: ""  } , 
        cssclass: { default: "" }, 
        items: { default: [] }, 
        params: {  default: {} },
        isGroup: { default: false },
        multi: { default: false },
        groupDesc: { },
        groupValue: { },
        datasource: { default: "" },
        descripcionCampo: { default: "descripcion" }, 
        valorCampo: {default: "id"}
     },
     data() {
        return  {
            itemsData: this.items,
            cargando: false,
            urlBase: '',
            selectedItem: null,
            descripcion: this.descripcionCampo,
            selectedValue: null,
            valor: this.valorCampo,
            selectedItems: [],
            especifiqueVisible: false
        }
    },
     /***
      * Se usa la función render, para facilitar el tipo de control a retornar
      */
  
   
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
                    //this.itemsData.push( ...response.data);
                    this.itemsData = response.data;
                    this.cargando = false;
                });
        } else {
            this.cargando = false;
            }
        },
        onchangeEspecifique(event) {
              
              const { target } = event;
               
              
              let value = target.value ?? "";
              if (this.selectedValue) {
                 if (!this.multi) {
                    this.selectedValue["extra"]  = value;
                 } else {
                    this.selectedValue.forEach((v, i) => {
                        if (v.extra != undefined) {
                            this.selectedValue[i]['extra'] = value;
                        }
                    })
                 }
              }
              this.$.emit('onchangeEspecifique', this.selectedValue ); /** emite  una funcion de cambio */
        },
        onChangeSelect: function(event) {
            event.originalEvent.stopPropagation();
            let target = event.originalEvent.target;
            let valor = null;
            
            if (this.multi) {
                valor = ( event.value ?? [] ).map(( v ) => { 
                        let r = { value:  v[ this.valor ], desc: v[ this.descripcion ]  };
                        if (v.HABILITAR_ENTRADA == 1 ) {
                            r['extra'] = "";
                        }
                        return r;    
                    }); 
                this.especifiqueVisible = (event.value ?? []).filter((v) => v.HABILITAR_ENTRADA == 1).length > 0

            } else {
                valor = { value:  event.value[ this.valor ], desc: event.value[ this.descripcion ]   }
                this.especifiqueVisible = event.value.HABILITAR_ENTRADA == 1;
                if (this.especifiqueVisible) {
                    valor['extra'] = "";
                }
            }
            
            this.selectedValue = valor;
           
            //this.selectedItem = valor;
            this.$.emit('onchange', valor); /** emite  una funcion de cambio */
        }
    },
    watch: {
        datasource(v) {
            this.cargarDatos(v, this.params);
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
    },
    setup() {
        return { $t: useI18n() }
    },
    components: {
        Dropdown,
        MultiSelect,
        InputText
    }
}
</script>

<style>
 .p-dropdown-label { line-height: normal !important; }
</style>
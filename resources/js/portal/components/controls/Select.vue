

<script>
import axios from 'axios';
import Dropdown from 'primevue/dropdown';
import MultiSelect from 'primevue/multiselect';
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
        valorCampo: {default: "id"},
        
     },
     data() {
        return  {
            itemsData: this.items,
            cargando: false,
            urlBase: '',
            selectedItem: null,
            descripcion: this.descripcionCampo,
            valor: this.valorCampo,
            selectedItems: []
        }
    },
     /***
      * Se usa la función render, para facilitar el tipo de control a retornar
      */
    render(createElement) {
       
        var control = this.multi ? MultiSelect : Dropdown;
        var props = {  class: this.cssclass, 
        filter : true, 
        filterPlaceholder: "Buscar", 
        onChange: (event) => { this.onChangeSelect(event) },
        onInput:(event) => { this.handleInput(event) },
         'onUpdate:modelValue': (value) => { this.selectedItem = value },
        loading: this.cargando,
        modelValue: this.selectedItem,
        options: this.itemsData,
        optionLabel: this.descripcion,
        optionValue: this.valor};

        if (this.isGroup) {
            props['optionGroupLabel'] = (this.groupDesc ?? "") == "" ? this.descripcion : this.groupDesc;
            props['optionGroupValue'] = (this.groupValue ?? "") == "" ? this.valor : this.groupValue;
            props['optionGroupChildren'] = 'items';
        }
        //** tipo control, propiedades, slots  */
        /** Se modifica el template para el elemento de lista */
        return h(control,props, {  option: (slot) =>  h("span", { "data-id" : slot.option.ID, "class": "p-item-custom" } , slot.option.DESCRIPCION) });
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
                    this.itemsData.push( ...response.data);
                    this.cargando = false;
                    //this.selectedItem = this.value;
                });
        } else {
            this.cargando = false;
            }
        },
        onChangeSelect: function(v) {
            v.originalEvent.stopPropagation();
            let target = v.originalEvent.target;
            let valor = null;    
            if (this.multi) {
                /*
                Se debe hacer una verificación del elemento que fue seleccionado
                */
                let span = target;
                let checkbox = target;
                let parent = target;
                    
                if (parent.className.includes("p-multiselect-item")) { //Si el click fue por al elemento <li></li>
                    checkbox = parent.querySelector(".p-checkbox-box");
                    span = parent.querySelector(".p-item-custom");
                } else if (span.className.includes("p-item-custom")) { //Si el click fue sobre el texto 
                    parent = span.parentElement;
                    checkbox = parent.querySelector(".p-checkbox-box");       
                } else if (checkbox.className.includes("p-checkbox-box")) { //Si el click fue sobre el checkbox
                    parent = checkbox.parentElement.parentElement;
                     span = parent.querySelector(".p-item-custom");
                }

                let desc = parent.attributes['aria-label'].value;
                let value = span.attributes['data-id'].value ;
                /*Se hace una verificación contraria, ya que el elemento checkbox añade la clase .pi-check 
                después de la ejecución de este método
                */
                if (checkbox.querySelector(".pi-check") == null) {
                    this.selectedItems.push( { "value": value, "desc": desc } );
                } else {
                    /**Si lo ha desmarcado el checkbox se quita de la lista de seleccionados */
                    var newArr = [];
                    this.selectedItems.forEach((v, i) => {
                        if (v.value != value) {
                            newArr.push({...v});
                        }
                    });
                    this.selectedItems = newArr;
                }
                
                valor = this.selectedItems.map(( v ) => { return {...v} });

            } else {
             valor =  {'value' : v.value.toString(), 'desc': target.innerText}
            }

            this.selectedItem = valor;
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
        MultiSelect
    }
}
</script>

<style>
 .p-dropdown-label { line-height: normal !important; }
</style>
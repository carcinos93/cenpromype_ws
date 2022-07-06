<template>
        <p-datatable :value="data" :lazy="true" :loading="tabla.cargando" :paginator="tabla.paginator" :total-records="tabla.total" ref="dt" :data-key="tabla.dataKey" :rows="10" 
        @page="onPage($event)">
            <template v-for="({ titulo, campo, filtros }, index) in tabla.columnas" :key="index">
                <p-column :field="campo + (!filtros ? '' : '_formatted')" :header="titulo" >
                    <template #body="{ data }">
                        <div v-html="data[campo + (!filtros ? '' : '_formatted')]"></div>
                    </template>
                </p-column>
            </template>
               <p-column header="">
                    <template #body="{ data }">
                          <i class="pi pi-pencil text-primary p-mr-2 cursor-pointer" @click="editar( data )" > </i>
                          <i class="pi pi-minus-circle text-danger p-mr-2 cursor-pointer" @click="borrar( data )" > </i>
                    </template>
                </p-column>
        </p-datatable>

        <p-dialog style="width: 50vw" v-model:visible="dialogoVisible">
            <p-tabview>
                <p-tabpanel header="Formulario">
                    <div class="p-fluid">
                        <template v-for="(control, index) in controles" :key="index">
                                <div class="p-field">
                                    <controles :config="control" :value="datoSeleccionado[control.campo]"  />
                                </div>
                             
                        </template>
                    </div>
                       
                     
                </p-tabpanel>
            </p-tabview>
        </p-dialog>
</template>

<script>
import datatable from 'primevue/datatable';
import column from 'primevue/column';
import dialog from 'primevue/dialog';
import tabpanel from 'primevue/tabpanel';
import tabview from 'primevue/tabview';
import _cs from '../services/crudservice';
import controles from './controles.vue';

export default {
    props: {
        configuracion: { default: {} },
        controles: { default: [] },
        esDetalle: { type: Boolean },
        titulo: { type: String },
        rutas: {default: {}  },
        conversiones: { default: {}},
    },
    data() {
        return  {
            cs: null,
            model: {},
            datoSeleccionado: {},
            modoSeleccion: "unico",
            data: [],
            tabla: {
                paginator: true,
                total: 1,
                dataKey: 'id',
                columnas: [],
                cargando: false
            },
            parametrosTabla: {
                  first: 0,
                    rows: 10,
                    sortField: null,
                sortOrder: null,
            },
            dialogoVisible: false
        }
    },
    created() {
        this.cs = new _cs();
    },
    methods: {
        cargarListas( origen, indice, parametros   ) {
            
        },
        /**
         * Función de carga de datos
         */
        cargarDatos() {
            this.tabla.cargando = true;
            this.cs.getAll( this.rutas['datos'], this.parametrosTabla ).then((respuesta) => {
                this.data = respuesta.data.data.map((v, i) => {
                //conversiones 
                for (var key in this.conversiones) {
                    if (this.conversiones[key] == "date") {
                     if (v[key]) {
                        v[key] = new Date( v[key] );
                     }
                  }
                }

               this.tabla.columnas.forEach((columna) => {
                    
                   if (columna.filtros) {
                        let valor = v[columna.campo];
                        columna.filtros.forEach((filtro) => {
                            if (typeof filtro == "object") {
                                    let nombreFiltro = filtro[0];
                                    let parametros = filtro[1] ?? [];
                                    valor =this.$filters[nombreFiltro](valor , ...parametros );
                                } 
                                else if (typeof filtro == "string") {
                                    valor =this.$filters[filtro](valor);
                                }
                           }); 
                            
                            v[columna.campo + '_formatted'] = valor          
                        }
                    });
                    return v;
                });
                this.tabla.total = respuesta.data.total
                this.tabla.cargando = false;
            });
           //this.data = [ { 'ID': 1, 'NOMBRE': 'NELSON RODAS', 'FECHA': '2012-04-23T18:25:43.511Z', 'BIO' : '<div style="color:red">Not Working!!!</div>' } ]
        },
        editar(data) {
           this.dialogoVisible = true;
           this.datoSeleccionado = {  ...data };
        },
        borrar(data) {

        },
        /***
         * Paginación
         */
        onPage(event) {
            this.parametrosTabla = event;
            this.cargarDatos();
            console.log(this.datoSeleccionado);
        },
         prepararConfiguracion(v) {
                this.modoSeleccion = v.modoSeleccion || "unico"; // Tipo seleccion de registro
                this.tabla.columnas = v.dataTable.columnas || [];
                if (v.multiple) {
                        
                }
        }
    },
    
    mounted() {
       this.prepararConfiguracion( this.configuracion );
       this.cargarDatos();
    },
    watch: {
       config(v) {
          this.prepararConfiguracion(v);
       }
    },

    components: {
        'p-datatable': datatable,
        'p-column' : column,
        'p-dialog': dialog,
        'p-tabview': tabview,
        'p-tabpanel': tabpanel,
        'controles': controles
    }
}
</script>

<style>


</style>
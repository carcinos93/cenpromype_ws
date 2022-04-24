<template>
    <template v-for="(formulario, i) in formularios" :key="i">
        <Panel :header="formulario.TITULO" :toggleable="true" >
        <div class="p-grid" :id="formulario.ID">
            <div class="p-col-12">
                <div
                    class="p-fluid"
                    v-for="(pregunta, j) in formulario.preguntas"
                    :key="j">
                    <div class="p-field">
                        <label> {{ j + 1 }}. {{  pregunta.PREGUNTA }} </label>
                        <template v-if="pregunta.TIPO == 'text'">
                            <inputtext v-model="model['pregunta' + pregunta.ID]" :id="'pregunta' + pregunta.ID" ></inputtext>
                        </template>
                         <template v-if="pregunta.TIPO == 'select'">
                               <select-control :ref="'pregunta' + pregunta.ID"  @onchange="onChangeSelect($event, pregunta, i, j)" :datasource="pregunta.ORIGEN.datasource"
                                 :items="pregunta.ORIGEN.items"  label=""
                                 :descripcion-campo="pregunta.ORIGEN.campos.descripcion"
                                 :valor-campo="pregunta.ORIGEN.campos.id"></select-control>
                        </template>
                         <template v-if="pregunta.TIPO == 'date'">
                            <calendar dateFormat="dd/mm/yy" v-model="model['pregunta' + pregunta.ID]" :id="'pregunta' + pregunta.ID" ></calendar>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </Panel>
    </template>
    
</template>

<script>
import apiPortal from "../components/apiPortal";
import Panel from "primevue/panel";
import inputtext from "primevue/inputtext";
import calendar from "primevue/calendar";
import SelectControl from '../components/controls/Select';
export default {
    props: {
        idFormulario: { required: true },
    },
    data()  {
       return {
        titulo: "",
        model: {},
        formularios: [],
        formulario: {
            preguntas: []
            }
        }
    },
    methods: {
        cargarFormulario(idFormulario) {
             apiPortal
            .get(`api/catalogos/formulario/${idFormulario}`)
            .then((response) => {
                  this.mapData( response );
            });
        },
        onChangeSelect(event, pregunta, i, j) {
            if (pregunta.CAMPO_DEPENDE) {
            
                //console.log(this.$refs['pregunta' + pregunta.CAMPO_DEPENDE][0]);
                //let datasource =  this.$refs['pregunta' + pregunta.ID][0]
                let ref =  this.$refs['pregunta' + pregunta.CAMPO_DEPENDE][0];
               ref.cargarDatos( ref.datasource, { "padre" : event.value })  ;
            }
            apiPortal.get(`api/catalogos/formulario/pregunta/${pregunta.ID}`, {  params: { valor: event.value } }  )
            .then((response) => {
                this.mapData( response );
               
            });
        },

        mapData(response) {
            var data = response.data;
                var preguntas = data.preguntas.map((v, i) => {
                    let temp = v;
                    this.model[ 'pregunta' + v.ID ] = null;
                    if ((temp.ORIGEN ?? "").trim() != "" ) {
                        let defecto = { items: [], datasource: "", campos: { descripcion: "descripcion", id: "id" } };
                        let obj = defecto;
                        try {
                            obj = JSON.parse(v.ORIGEN);
                            // establecer valores por defecto
                            for (var j in defecto) {
                                if (obj[j] == undefined) {
                                    obj[j] = defecto[j];
                                }
                            }
                            obj.datasource = (obj.datasource ?? "").replace("(sitio)",  window["url_laravel"]);
                        } catch (error) {
                            obj = { items: [], datasource: "", campos: { descripcion: "descripcion", id: "id" } };
                        }
                        temp.ORIGEN = obj;
                    }
                    return temp;
                });
                if (preguntas.length > 0) {
                    data.preguntas = preguntas;
                
                     if (this.formularios[1]) {
                         this.formularios[1] = data;
                    } else {
                        this.formularios.push(  data );
                    }
                }
   
                /*this.formulario = data;
                this.titulo = data.TITULO;*/
        }

    },
    mounted() {
       this.cargarFormulario(this.idFormulario);
    },
    components: {
        Panel,
        inputtext,
        SelectControl,
        calendar
    },
};
</script>

<style></style>

<template>
        <Form @submit="handleSubmit" ref="Formulario">
        <Card>
            <template #header>
                <ProgressBar style="height: 0.5em;" v-if="cargando" mode="indeterminate"/>
            </template>
            <template #content>
                 <TabView ref="tabView">
                    <TabPanel :header="formulario.TITULO"  v-for="(formulario, i) in formularios" :key="i"  >
                <div class="p-grid" :id="'formulario ' + formulario.ID">
                    <div class="p-col-12">
                        <div class="p-fluid">
                            <template v-for="(pregunta, j) in formulario.preguntas" :key="j">
                                <div class="p-field">
                                    <label :for="'pregunta_' + pregunta.ID">
                                        {{ j + 1 }}. {{ pregunta.PREGUNTA }}
                                    </label>
                                <Field v-slot="{ handleChange  }" :name="pregunta.modelId" :rules="pregunta.reglas"
                                :validateOnBlur="true" :validateOnChange="true" :validateOnInput="false">
                                    <template v-if="pregunta.TIPO == 'text'">
                                        <inputtext @change="handleChange"   :id="'pregunta_' + pregunta.ID" v-model="model[pregunta.ID_FORMULARIO][pregunta.modelId].value" ></inputtext>
                                    </template>
                                    <template v-else-if="pregunta.TIPO == 'select'">
                                        <select-control v-model="model[pregunta.ID_FORMULARIO][pregunta.modelId].model"
                                        :ref="'pregunta_' + pregunta.ID"  @onchange="onChangeSelect($event, pregunta, i, j); handleChange($event); model[pregunta.ID_FORMULARIO][pregunta.modelId].value = $event" :datasource="pregunta.ORIGEN.datasource"
                                            :items="pregunta.ORIGEN.items"  label=""
                                            :descripcion-campo="pregunta.ORIGEN.campos.descripcion"
                                            :params="pregunta.ORIGEN.params" 
                                            :multi="pregunta.ORIGEN.multi" 
                                            :valor-campo="pregunta.ORIGEN.campos.id"
                                            :is-group="pregunta.ORIGEN.params.group == 1"
                                            :group-desc="pregunta.ORIGEN.campos.grupoDesc"
                                            :group-value="pregunta.ORIGEN.campos.grupoID"></select-control>
                                    </template>
                                    <template v-else-if="pregunta.TIPO == 'date'">
                                        <calendar show-icon="true" @date-select="handleChange($event)" date-format="dd/mm/yy"  v-model="model[pregunta.ID_FORMULARIO][pregunta.modelId].value"  :id="'pregunta' + pregunta.ID" ></calendar>
                                    </template>
                                    <ErrorMessage :name="'pregunta_' + pregunta.ID" v-slot="{ message }">
                                            <p> 
                                                <small class="p-error">*{{ message }} </small>
                                            </p>
                                    </ErrorMessage>
                                </Field>
                                </div>             
                        </template>
                        </div>
                    </div>
            </div>
                    </TabPanel>
                </TabView>
            </template>
            <template #footer>
                <form-control label="" cssclass="">
                        <Button :disabled="cargando" type="submit" label="Registrarse" class="p-mt-2" />
                </form-control>
            </template>
        </Card>
    </Form>

    

</template>

<script>
import apiPortal from "../components/apiPortal";
import Panel from "primevue/panel";
import inputtext from "primevue/inputtext";
import calendar from "primevue/calendar";
import SelectControl from '../components/controls/Select';
import FormControl from '../components/controls/FormControl';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import ProgressBar from 'primevue/progressbar';
import Card from 'primevue/card';
import { Form, Field, ErrorMessage  } from 'vee-validate';
import * as yup from 'yup';
//import useVuelidate from '@vuelidate/core';
//import { required, email, helpers } from '@vuelidate/validators'
import Button from 'primevue/button';
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
        },
        actualizandoReglas: false,
        cargando: false,
        reglas: {
            required: yup.string().required()
          },
          activeIndex: 0
        }

    },
   /*validations() {
        if (this.formularios.length > 0 && !this.actualizandoReglas  ) {
            var reglas = this.reglas
            console.log(reglas);
            return  { ...reglas };
        }
    },**/
    methods: {
        enviar() {

        },
        /**
         * Envio de formulario
         */
        handleSubmit(values) {


            // TITULO
            var formularios = this.formularios.map((v, i) => { return v.ID });
            var preguntas = {};

            formularios.forEach((v) => {
                let p = this.model[v];
                preguntas = { ...preguntas, ...p};
            });
            
            console.log(preguntas);
            apiPortal.post( 'api/registro', { preguntas: preguntas, formularios: formularios  })
            .then((response) => {
                var data = response.data;
                if (data['success']) {
                    alert("Se ha enviado un correo electrónico con el enlace de verificación");
                    window.close();
                } else {
                     alert(data['message']);
                }
            })
            .catch((err) => console.log(err));
        },
        /**
         * Carga de formulario
         */
        cargarFormulario(idFormulario) {
            this.cargando = true;
             apiPortal
            .get(`api/catalogos/formulario/${idFormulario}`)
            .then((response) => {
                  this.mapData( response );
            }).finally(_ => this.cargando = false )
            .catch((err) => console.log(err));
        },
        /**
         * Evento de onchange de los controles tipo lista
         */
        onChangeSelect(event, pregunta, i, j) {



            if (pregunta.CAMPO_DEPENDE) {
                let ref =  this.$refs['pregunta_' + pregunta.CAMPO_DEPENDE][0];
               ref.cargarDatos( ref.datasource, { "padre" : event.value })  ;
            }
            /**
             * Si la pregunta necesita hacer petición
             */
            if (pregunta.ORIGEN.request) {
                this.cargando = true;
                apiPortal.get(`api/catalogos/formulario/pregunta/${pregunta.ID}`, {  params: { valor: event.value } }  )
                    .then((response) => {
                        this.mapData( response );
                        /**
                         * Se verifican los formularios, puede haber preguntas que invoquen un formulario extra, 
                         * pero no todo sus valores invocan un formulario
                         *
                         * NOTA IMPORTANTE: Ejemplo, si tipo entidad es empresa, hará la carga para las preguntas de empresa, 
                         * pero si selecciona otra opción y esta no tiene preguntas 
                         * debe eliminarse el formulario que se genero anteriormente
                        */
                       if (this.formularios.length >= 2) {
                           /**Si el formulario extra que esta cargado es igual a la pregunta que lo invoco */
                           if (this.formularios[1].CAMPO_DEPENDE == pregunta.ID) {
                               /**Si el valor del cual depende el formulario no se encuentra, se elimina */
                               if ( !this.formularios[1].VALOR_DEPENDE.includes(`{${event.value}}`) ) {
                                  this.formularios = this.formularios.filter((v, i) => i == 0); //para eliminar el formulario extra
                               }
                               
                           }
                       }

                     }).finally(_ => this.cargando = false);

            }
         
        },
        /**
         * Mapeo de la información
         */
        mapData(response) {
            var data = response.data;
            if (response.data.preguntas.length > 0) {
                this.actualizandoReglas = true;
            }
                    //** Se filtran las preguntas activas */
                    var preguntas = data.preguntas.filter((v, i) =>  v.ACTIVO == 1 ).map((v, i) => {
                    let temp = v;
            
                    let idPreguta = `pregunta_${v.ID}`;
                    if (!this.model[v.ID_FORMULARIO]) {
                        this.model[v.ID_FORMULARIO] = {};
                    }

                    temp['modelId'] =( v.VARIABLE ?? "" ) == "" ? idPreguta : v.VARIABLE; 
                    /** Para las listas se utilizara value ya que esta se incluye sus valores con sus respectivas descripciones
                     * en model solo están incluidos los valores **/
                    this.model[v.ID_FORMULARIO][ temp['modelId'] ] = { value: null, formulario: v.ID_FORMULARIO, model: null, id_pregunta: v.ID , label: v.PREGUNTA };

                    var reglas = null;
                        if (v.TIPO == 'text') {
                            reglas = yup.string();
                        } else {
                            reglas = yup.mixed();
                        }
                        // Para evitar errores en las validaciones
                        try  { 
                            if ((v.VALIDACIONES ?? "") != "") {
                                let validaciones = JSON.parse( v.VALIDACIONES );
                                for (var validacion in validaciones) {
                                    if (typeof reglas[validacion] == "function") {
                                        reglas = reglas[validacion]( validaciones[ validacion ] );
                                    } 
                                }
                                
                            }
                        } catch (ex ) {
                            console.log("fallo en validaciones " + ex);
                        }
                    if (v.REQUERIDO) {
                       reglas = reglas.required("El campo es requerido");
                    }

                    temp['reglas'] = reglas;
                    

                    if ((temp.ORIGEN ?? "").trim() != "" ) {
                        //datos de configuración por defecto
                        let defecto = { request: false,multi: false ,items: [], datasource: "", campos: { descripcion: "descripcion", id: "id", grupoDesc: "descripcion", grupoID: "id" }, params: { group: 0} };
                        
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
                            console.log(error, temp.ORIGEN);
                            obj = { items: [], datasource: "", campos: { descripcion: "descripcion", id: "id" } };
                        }
                        temp.ORIGEN = obj;
                    }
                    return temp;
                });
               // Por el momento solo se maneja dos formulario, el principal y el que es cargado según un listado
                if (preguntas.length > 0) {
                    data.preguntas = preguntas;
                    /**Si existe un formulario adicional al principal, solo actualiza con el nuevo */
                     if (this.formularios[1]) {
                         this.formularios = this.formularios.filter((v, i) => i == 0);
                     }
                    this.formularios.push(  data );
                    //si se ha cargado un segundo formulario se cambia el tab
                    if (this.formularios.length >= 2 ) {
                        let ref =  this.$refs["tabView"];
                        ref.d_activeIndex = 1;
                    }
                }
                 if (response.data.preguntas.length > 0) {
                    this.actualizandoReglas = false;
                }
                

                /*this.formulario = data;
                this.titulo = data.TITULO;*/
        }

    },
    mounted() {
        this.cargarFormulario(this.idFormulario);      
    },
    setup() {
        
       // return {  $v: useVuelidate() }
    },
    components: {
        Panel,
        inputtext,
        SelectControl,
        calendar,
        FormControl,
        Button,
        Form,
        Field,
        ErrorMessage,
        TabView,
        TabPanel,
        Card,
        ProgressBar
    },
};
</script>

<style></style>

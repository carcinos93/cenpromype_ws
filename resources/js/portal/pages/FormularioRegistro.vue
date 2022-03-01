<template>

    <form @submit.prevent="handleSubmit($v)">
<div class="p-fluid p-m-5 p-formgrid p-grid">

                <form-control  :validation="$v.formulario.nombre" label="registro.nombre" cssclass="p-col-6" >
                    <input-text v-model="$v.formulario.nombre.$model" type="text" />
                </form-control>
                <form-control label="registro.apellido" :validation="$v.formulario.apellido" cssclass="p-col-6">
                    <input-text type="text" v-model="$v.formulario.apellido.$model" />
                </form-control>
                <form-control :validation="$v.formulario.sexo" label="registro.sexo" cssclass="p-col-6">
                    <div class="p-formgroup-inline">
                        <div class="p-field-radiobutton">
                            <div>
                                <radio-button id="sexo1" name="sexo" value="F" v-model="$v.formulario.sexo.$model" />
                            </div>
                            <label for="sexo1"> {{ $t("formularios.portal.registro.campos.sexo.femenino.valor") }} </label>
                        </div>
                        <div class="p-field-radiobutton">
                            <div>
                                <radio-button name="sexo" value="M" v-model="$v.formulario.sexo.$model" />
                            </div>
                            <label>{{ $t("formularios.portal.registro.campos.sexo.masculino.valor") }}</label>
                        </div>
                        <div class="p-field-radiobutton">
                            <div>
                                <radio-button name="sexo " value="O" v-model="$v.formulario.sexo.$model" />
                            </div>
                            <label>{{ $t("formularios.portal.registro.campos.sexo.otro.valor") }}</label>
                        </div>
                    </div>
                </form-control>
                <form-control label="registro.anioNacimiento" :validation="$v.formulario.anyo" cssclass="p-col-6">
                    <select-control  v-model="$v.formulario.anyo.$model" :items="anyos"  label=""></select-control>
                </form-control>
                <form-control label="registro.pais" cssclass="p-col-6" :validation="$v.formulario.pais">
                    <select-control v-model="$v.formulario.pais.$model" :items="paises" label="" ></select-control>
                </form-control>
                <form-control label="registro.tipoInstitucion" :validation="$v.formulario.tipoInstitucion" cssclass="p-col-6">
                    <select-control v-model="$v.formulario.tipoInstitucion.$model" v-on:onchange="onchangeTipoInstitucion" datasource="api/listas/tipo-instituciones "  label=""></select-control>
                </form-control>
        
                <form-control v-if="esEmpresa" :validation="$v.formulario.empresa.sectorEconomico"   label="registro.sectorEconomico" cssclass="p-col-6">
                    <select-control v-model="$v.formulario.empresa.sectorEconomico.$model" :descripcion-campo="'descripcion_' + lang"   v-on:onchange="onchangeSectorEconomico" datasource="api/listas/empresa-sector"  label=""></select-control>
                </form-control>
        
                <form-control v-if="esEmpresa" :validation="$v.formulario.empresa.actividadEconomica"  label="registro.actividadEconomica" cssclass="p-col-6">
                    <select-control v-model="$v.formulario.empresa.actividadEconomica.$model" :descripcion-campo="'descripcion_' + lang" v-bind:datasource="datasourceActividadEconomica"  label=""></select-control>
                </form-control>
        
                <form-control label="registro.correo"  cssclass="p-col-12" :validation="$v.formulario.correo">
                    <input-text v-model="$v.formulario.correo.$model"  type="text" />
                </form-control>
                <form-control  label="registro.usuario" cssclass="p-col-12" :validation="$v.formulario.usuario">
                    <input-text type="text" v-model.trim="$v.formulario.usuario.$model"  />
                    <span class="text-success" v-if="checking">
                        {{ $t("mensajes.revisando") }}
                    </span>
                </form-control>
                <form-control label="registro.password" :validation="$v.formulario.password" cssclass="p-col-12">
                    <input-text type="password" v-model="$v.formulario.password.$model"  />
                </form-control>
                <form-control label="registro.repetirPassword" :validation="$v.formulario.confirmarPassword" cssclass="p-col-12">
                    <input-text type="password" v-model="$v.formulario.confirmarPassword.$model"  />
                </form-control>
        
                <form-control label="registro.boletin" cssclass="p-col-12">
                    <select-control v-bind:items="[ { id: 1, descripcion: 'Si' }, { id: 0, descripcion: 'No' } ]"  label=""></select-control>
                </form-control>
                <form-control label="" cssclass="p-col-12 p-md-12 p-mt-3">
                    <div class="recaptcha ">
                    <recaptcha @expired="finRecaptcha" @verify="validarRecaptcha" sitekey="6LdfFHAaAAAAAIvUfxf6viOCpYKVzfLBp0WhNi-_ "></recaptcha>
                         <span v-if="!recaptchaValido && submmited">
                        <small class="p-error"> Recaptcha es requerido </small>
                    </span>
                    </div>
                </form-control>
                <form-control label="" cssclass="p-mt-3">
                        <Button type="submit" :label="$t('botones.registrarse')" class="p-mt-2" />
                </form-control>
            
              <!-- <pre>
                   {{{ $v.formulario.usuario }}}</pre>-->
         
 
                
</div>
          </form>
</template>
<script>
import InputText from 'primevue/inputtext';
import RadioButton from 'primevue/radiobutton';
import Button from 'primevue/button';
import { VueRecaptcha } from 'vue-recaptcha';
import SelectControl from '../components/controls/Select';
import FormControl from '../components/controls/FormControl';
import useVuelidate from '@vuelidate/core';
import { useI18n } from 'vue-i18n';
import { required, email, helpers } from '@vuelidate/validators'
import axios from 'axios';




/*helpers.withAsync(async (value) => {
    if (value == '') return true;
    let resp = (await axios.get(`api/existeUsuario?usuario=${value}`)).data
    return resp;
});*/
export default {
    props: {  codigoEmpresa: { required: true } },
    data() {
        return { 
            anyos: [],
            sexo: null,
            paises: [],
            checking: false,
            debounceSearch:undefined,
            datasourceActividadEconomica: "",
            submmited: false,
            recaptchaValido: false,
            esEmpresa: false,
            formulario: {
                nombre: '',
                apellido: '',
                sexo: null,
                anyo: 0,
                pais: 0,
                tipoInstitucion: 0,
                empresa: {
                    sectorEconomico: 0,
                    actividadEconomica: 0
                },
                correo: '',
                usuario: '',
                password: '',
                confirmarPassword: '',
                boletin: null
            }
         }
    },
    /**
     * Validaciones
     */
    validations() {
        
        const fieldRequired = helpers.withMessage(this.$t("validaciones.required"), required);
        this
        const fieldEmail = helpers.withMessage(this.$t("validaciones.email"), email);
        const fieldSelectRequired = helpers.withMessage(this.$t("validaciones.emptyOption") , (value) => {
        return (value ?? 0 ) > 0 || value != ""; 
        });

        const validarConfirmarPassword  = helpers.withMessage(this.$t("validaciones.passwordEqual"), (value) => { 
                return  this.formulario.password == value ;
            });


        /***
         * Validacion de usuario
         * En vue3, las promesas debe resolverse con el helper withAsync
         */
        
        const existeUsuario = helpers.withMessage(this.$t("validaciones.userExists"), helpers.withAsync((value) => {
            if (value == '') { return true };
            /** promesa  */
            return new Promise((resolve) => {
                if (this.debounceSearch) clearInterval(this.debounceSearch);
                this.debounceSearch = setTimeout(() => {
                    if (!value) { return true; };
                    this.checking = true;
                    axios.get("api/existeUsuario", {
                        params: { usuario: value }
                    })
                    .then(res => {
                        this.checking = false;
                        return resolve(!res.data);
                    });

                }, 1000);
                });
        }));

        var reglas =  {
            formulario: {
                nombre: { fieldRequired },
                apellido: { fieldRequired },
                sexo: { fieldRequired },
                anyo: {fieldSelectRequired},
                tipoInstitucion: { fieldSelectRequired },
                pais: {  fieldSelectRequired },
                correo: { fieldRequired, fieldEmail },
                usuario:  { fieldRequired,  existeUsuario } ,
                password:  { fieldRequired },
                confirmarPassword: { validarConfirmarPassword },
                boletin:  { fieldRequired },
                empresa: {
                    sectorEconomico: {},
                    actividadEconomica: {}
                }
            }
        };
        /**solo si es empresa se valida */
        if (this.esEmpresa) {
            reglas.formulario.empresa.sectorEconomico = { fieldSelectRequired };
            reglas.formulario.empresa.actividadEconomica = {  fieldSelectRequired }
        }

        return reglas;
    },
    computed: {
        lang() {
            return window.lang ?? 'es';
        }
    },
    methods: {
        validarRecaptcha() {
            this.recaptchaValido = true;
        },
        finRecaptcha() {
            this.recaptchaValido = false;
           
        },
        onchangeTipoInstitucion(v) {
            this.esEmpresa = v.value == this.codigoEmpresa;
        }, 
        onchangeSectorEconomico(v) {
            if (v.value) {
                this.datasourceActividadEconomica = `api/listas/empresa-actividad/${v.value}`;
                this.formulario.empresa.actividadEconomica = 0;
            }
        },
        handleSubmit($v) {
            this.submmited = true;
            $v.$touch();

            
        },
        cargarPaises() {
             axios.get('assets/json/paises.json').then((response) => {
            let data = response.data;
            if (data['countries']) {
                this.paises = (data.countries ?? []).map((v, i) => {
                    return { id: v.name_es , descripcion: v.name_es };
                });
                }

            });
        }
    },
    beforeMount() {
        let anyo = new Date().getFullYear();
        let arr = [];
        for (let i = 0, total = 85; i<=total; i++) {
            let res = anyo - i;
            arr.push( { id:  res.toString(), descripcion: res.toString() } );
        }

        this.anyos = arr;

        this.cargarPaises();
    },
    mounted() {
       
    },
    setup() {
        return {  $v: useVuelidate(), $t: useI18n() }
    },
    components: {
         InputText,
         RadioButton,
         SelectControl,
         FormControl,
         Recaptcha: VueRecaptcha,
         Button
    }
}
</script>

<style scoped>

</style>
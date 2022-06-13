<template>
        <template v-if="config.tipo == 'texto'">
               <p-inputtext @change="onchange($event)" v-model="dato" />
        </template>
</template>

<script>
//import inputText from './controles/inputText.vue';
import inputtext from 'primevue/inputtext';
export default {
    props:[ 'config', 'model' ],
    data() {
        return {
            dato: null
        }
    },
    /*emits: {
        'update:modelValue': (value) => {  this.dato = value  }
    },*/
    methods: {
        onchange(event) {
            this.$emit("onchange", event );
            
        }
    },
    components: {
        'p-inputtext' : inputtext     
    }
}   
</script>

<style>

</style>
<template>
        <p-inputtext @change="onchange"  v-model="model[conf.campo]" />
</template>

<script>
import inputtext from 'primevue/inputtext';
export default {
    props: {
        conf: { default: {} },
        model: {}
    },
    methods: {
        onchange(event) {
            this.$emit("onchange", event);
        }
    },
    components: {
       'p-inputtext' : inputtext      
    }
}
</script>

<style>

</style>
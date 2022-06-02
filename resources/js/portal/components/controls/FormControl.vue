<template>
  <div v-bind:class="'p-field ' +  cssclass"><label style="text-transform: capitalize" v-if="label != ''"  v-bind:for="label" > 
    {{ label }} </label>
    <slot></slot>  
    <span v-if="hasError">
        <span v-for="(error, index) of errors" :key="index">
          <small class="p-error">{{error.$message}}</small>
          </span>
      </span>
  </div>
</template>
<script>
export default {
    props: {
        label: { required: true, default: "" },
        cssclass: {  default: ''},
        validation: { required: true },
        /*errors: [],
        hasError: false*/
    },
    computed: {
      hasError() {
        if (this.validation) {
          return this.validation.$error;
        }
        return false;
      }, 
      errors() {
        if (this.validation) {
          return this.validation.$errors ?? [];
        } 
        return [];
    
      }
    },
    watch: {
      validation: function(v) {
        if (v)
          {
             /*;
             this.hasError = v.$error;**/

           
          }

      }
    }
}
</script>

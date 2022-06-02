
<template>
        <template v-for="(item, index) in items" :key="index">
              <div class="servicios" v-bind:class="[ selectedKey == index ? 'activo' : '' , cssClassLista.split(' ') ]" @click="onClickItem(item, index)">
                    <slot :item="item" :index="index" :isActive="selectedKey == index" ></slot>
              </div>
              <div v-if="items.length == 0" class="p-p-5 p-shadow-7 bg-white">
                  <h2 class="p-text-center">
                      NO HAY INFORMACIÓN
                  </h2>
              </div>
        </template>
</template>

<script>
import apiPortal from '../components/apiPortal';

export default {
    props: { url: { default: '', required: true }, cssClassLista: { default: '' } },
    data() {
        return { items: [], selectedKey: -1  }
    },
    methods: {
        onClickItem(item, index) {
            this.selectedKey = index;
            this.$emit('onclickitem', item);
        }
    },
    watch: {
        url(v) {
            if (v != '') {
                    if (window.loading) window.loading();
                    apiPortal.get(this.url).then((result) => {
                    this.items = result.data;
                }).finally(_ => {
                    if (window.swal) window.swal.close();        
                } );
            }
        }
    }


}
</script>

<style>

</style>
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import moment from 'moment'
import basegrid from './administrativo/core/components/base-grid';
const app = createApp({}).use(PrimeVue);

app.component('baseGrid', basegrid);

//Filtros
app.config.globalProperties.$filters = {
    date(value, formato) {
        if (!value) {  return ""; }
        moment.locale("es");
        return moment(value).format(formato);
    },
    uppercase(value) {
        return (value ?? "").toUpperCase()
    },
    lowercase(value) {
        return (value ?? "").toLowerCase()
    },
    number(value) {
        if (!value) {  return ""; }
         return Number.parseFloat(value).toLocaleString();
    },
    sufijo(value, suf) {
        if (!value) {  return ""; }
         return `${value} ${suf}`
    }
}


app.mount("#app");
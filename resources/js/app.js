/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

//require('./bootstrap');

const i18nConfig = require('./i18n');

import { createApp } from 'vue';
import moment from 'moment'
import PrimeVue from 'primevue/config';
import FormularioRegistro from './portal/pages/FormularioRegistro';
import Noticias from './portal/pages/Noticias';
import Informes from './portal/pages/Informes';
import RotorImagenes from './portal/pages/RotorImagenes';
import Productos from './portal/pages/Productos';
import { createI18n } from 'vue-i18n';
import Tooltip from 'primevue/tooltip';
/*Vue.component('form-control', require('./portal/components/controls/FormControl.vue').default);
Vue.component('select', require('./portal/components/controls/Select.vue').default);
*/

//const app = createApp({}).use(PrimeVue);

//app.component('formulario-registro', FormularioRegistro);
//app.component('informes', Informes);
//app.component('rotor-imagenes', RotorImagenes);
//app.directive('tooltip', Tooltip);
/*app.component('select-control', Select);*/

//app.mount("#app");
if (window.lang == undefined) window.lang = 'es';

const i18n = createI18n({ locale: window.lang });
i18nConfig.loadLocaleMessages(i18n, window.lang).then(_ => {

    const app = createApp({}).use(PrimeVue).use(i18n);

    app.config.globalProperties.$filters = {
        formatDate(value, formato) {
            moment.locale(window.lang);
            return moment(value).format(formato);
        }
    }

    app.directive('tooltip', Tooltip);
    app.component('formulario-registro', FormularioRegistro);
    app.component('informes', Informes);
    app.component('rotor-imagenes', RotorImagenes);
    app.component('noticias', Noticias);
    app.component('productos', Productos);
    app.mount("#app");

});




/*const app = new VueElement({
    el: '#app',
});*/
//require('./components/registro');
//require('./components/formularios/login');
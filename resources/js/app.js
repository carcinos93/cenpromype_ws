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
//import FormularioRegistro from './portal/pages/FormularioRegistro';
import Noticias from './portal/pages/Noticias';
import Informes from './portal/pages/Informes';
import RotorImagenes from './portal/pages/RotorImagenes';
import SectoresInforme from './portal/pages/informe/Sectores';
import ServiciosInforme from './portal/pages/informe/Servicios';
import ProductosInforme from './portal/pages/informe/Productos';
import InformesListado from './portal/pages/informe/Informes';
import Productos from './portal/pages/Productos';
import Formulario from './portal/pages/Formulario';
import { createI18n } from 'vue-i18n';
import Tooltip from 'primevue/tooltip';
import VueLoading from 'vue-loading-overlay';
import { createRouter, createWebHashHistory } from 'vue-router';

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

    var sections = document.getElementsByClassName( "app-vue" ); 
    let arr = [ ...sections ];
    arr.push( { "id" : "app" } );
    const routes = [
        { path: '/', component: SectoresInforme, name: 'inicio' },
        { path: '/informes/productos/:idSector', component: ProductosInforme, name:'productos' },
        { path: '/informes/servicios/:idProducto', component: ServiciosInforme, name:'servicios' },
        { path: '/informes/:idProducto/:idServicio', component: InformesListado, name: 'informes' }
    ];
    const router = createRouter(
        {
            history: createWebHashHistory(),
            routes
        }
    );
    for (var section in arr) {
        const app = createApp({}).use(PrimeVue, { locale: {
            dayNames: ["Domingo", "Lunes", "Martes", "Mi??rcoles", "Jueves", "Viernes", "S??bado"],
            dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
            dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
            monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun","Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        }}).use(i18n).use(VueLoading).use(router);

            app.config.globalProperties.$filters = {
                formatDate(value, formato) {
                    moment.locale(window.lang);
                    return moment(value).format(formato);
                }
            }
        
        
        app.directive('tooltip', Tooltip);
        app.component('informes', Informes);
        app.component('rotor-imagenes', RotorImagenes);
        app.component('noticias', Noticias);
        app.component('productos', Productos);
        app.component('formulario', Formulario);
    //
        var id = "#" + arr[section].id;
        app.mount(id);
    }

    
    
    /*for (var section in sections) {
        app.mount("#" + section.id);
    }*/
});




/*const app = new VueElement({
    el: '#app',
});*/
//require('./components/registro');
//require('./components/formularios/login');
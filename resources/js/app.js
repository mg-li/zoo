
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import Vuex from 'vuex';
Vue.use(Vuex);
import Loading from 'vue-loading-overlay';
Vue.component('loading', Loading)
import 'vue-loading-overlay/dist/vue-loading.min.css';
// https://github.com/robinvdvleuten/vuex-persistedstate
import createPersistedState from 'vuex-persistedstate';
// Bootstrap-Vue
window.BootstrapVue = require('bootstrap-vue');
Vue.use(BootstrapVue);
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)
import 'vue-multiselect/dist/vue-multiselect.min.css';

import CsvImporter from 'vue-mg-csv-importer'
Vue.component('CsvImporter', CsvImporter)
import DatePickerStandard from 'vue-mg-date-picker-standard'
Vue.component('DatePickerStandard', DatePickerStandard)
import DatePickerFromTo from "vue-mg-date-picker-from-to";
Vue.component("DatePickerFromTo", DatePickerFromTo);
import DateTimeSelector from 'vue-mg-date-time-selector'
Vue.component('DateTimeSelector', DateTimeSelector)
import ToggleSelector from 'vue-mg-toggle-selector'
Vue.component('ToggleSelector', ToggleSelector)
import ModalDialog from 'vue-mg-modal-dialog'
Vue.component('ModalDialog', ModalDialog)
import MgPaginate from "vue-mg-paginate";
Vue.component("MgPaginate", MgPaginate);
import ModalKeypad from "vue-mg-modal-keypad";
Vue.component("ModalKeypad", ModalKeypad);
import ImageFileUploader from "vue-mg-image-file-uploader";
Vue.component("ImageFileUploader", ImageFileUploader);
import TimePickerSelector from "vue-mg-time-picker-selector";
Vue.component("TimePickerSelector", TimePickerSelector);
import ModalSearchMaster from "vue-mg-modal-search-master";
Vue.component("ModalSearchMaster", ModalSearchMaster);
import FileUploader from "vue-mg-file-uploader";
Vue.component("FileUploader", FileUploader);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('main-component', require('./components/MainComponent.vue').default);
Vue.component('back-button', require('./components/commons/buttons/BackButton.vue').default);
Vue.component('modal-component', require('./components/commons/ModalComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    base: process.env.MIX_BASE_URL,
    routes: [
        // ホーム
        { name: 'home', path: '/', component: require('./components/HomeComponent.vue').default },

        // 設定
        { name: 'setting', path: '/setting', component: require('./components/settings/Index.vue').default },
        // 従業員
        { name: 'employee', path: '/employee', component: require('./components/employees/Index.vue').default },
        { name: 'employee.create', path: '/employee/create', component: require('./components/employees/CreateUpdate.vue').default },
        { name: 'employee.show', path: '/employee/show/:employee_id', component: require('./components/employees/CreateUpdate.vue').default, props: true },
        // 従業員
        { name: 'animal', path: '/animal', component: require('./components/animals/Index.vue').default },
        { name: 'animal.create', path: '/animal/create', component: require('./components/animals/CreateUpdate.vue').default },
        { name: 'animal.show', path: '/animal/show/:animal_id', component: require('./components/animals/CreateUpdate.vue').default, props: true },
        // 設備
        { name: 'facility', path: '/facility', component: require('./components/facilities/Index.vue').default },
        { name: 'facility.create', path: '/facility/create', component: require('./components/facilities/CreateUpdate.vue').default },
        { name: 'facility.show', path: '/facility/show/:facility_id', component: require('./components/facilities/CreateUpdate.vue').default, props: true },
        // 機械
        { name: 'category', path: '/category', component: require('./components/categories/Index.vue').default },
        { name: 'category.create', path: '/category/create', component: require('./components/categories/CreateUpdate.vue').default },
        { name: 'category.show', path: '/category/show/:category_id', component: require('./components/categories/CreateUpdate.vue').default, props: true },

        { name: 'import', path: '/import', component: require('./components/import/Index.vue').default },

        // 作業日報
        { name: 'report', path: '/report', component: require('./components/reports/Index.vue').default },
        { name: 'report.create', path: '/report/create', component: require('./components/reports/CreateUpdate.vue').default },
        { name: 'report.show', path: '/report/show/:report_id', component: require('./components/reports/CreateUpdate.vue').default, props: true },
        { name: 'report.copy', path: '/report/copy/:copy_report_id', component: require('./components/reports/CreateUpdate.vue').default, props: true },

        // not found
        { path: '*', component: require('./components/commons/NotFoundComponent.vue').default },
    ]
});

const store = new Vuex.Store({
    state: {
        user: '',
    },
    mutations: {
        getUser (state, payload) {
            axios.get('/api/user/info').then(res => {
                // this.$store.commit('setLoginUser', res.data)
                state.user = res.data
            }).catch(error => {
                console.log(error)
            });
        },
    },
    actions: {
        getUser (context) {
          context.commit('getUser')
        }
    },
    plugins: [createPersistedState()],
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router,
});

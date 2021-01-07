require('./bootstrap');
require('./swal');

import Vue from 'vue';

import { HasError, AlertError } from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.component('loading', Loading);

Vue.component('app-header', require('./components/AppHeader.vue').default);
Vue.component('table-sorter', require('./components/TableSorter.vue').default);
Vue.component('pagination', require('./components/Pagination.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);

import router from './routes';
import store from './store';

import AppVue from './App.vue';

const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    components: {
      AppVue,
    },
    data: {
      return() {

      }
    },
    mounted() {

    },
    created() {
      var token = localStorage.getItem('bearer_token');
      this.$store.dispatch('setAccessToken', token);
    }
});
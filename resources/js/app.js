require('./bootstrap');
require('./swal');

import Vue from 'vue';

import { HasError, AlertError } from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component('app-header', require('./components/AppHeader.vue').default);

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
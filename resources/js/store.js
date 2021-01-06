import Vue from 'vue';
import Vuex from 'vuex';
import articles from './pages/articles/store';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        accessToken: null,
    },

    mutations: {
        setAccessToken(state, accessToken) {
            state.accessToken = accessToken;
        }
    },

    getters: {
        accessToken(state) {
            return state.accessToken;
        }
    },

    actions: {
        setAccessToken(context, accessToken) {
            accessToken = accessToken ? `Bearer ${accessToken}` : null;
            window.axios.defaults.headers.common['Authorization'] = accessToken;
            context.commit('setAccessToken', accessToken);
        },
        authenticate(context, payload) {
            localStorage.setItem('bearer_token', payload.accessToken);
            context.dispatch('setAccessToken', payload.accessToken);
            payload.$router.push('/');
        },
        logout(context, payload) {
            localStorage.removeItem('bearer_token');
            context.dispatch('setAccessToken', null);
            payload.$router.push('/login');
        }
    },

    modules: {
        articles
    },
});

export default store;
import Vue from 'vue';
import Vuex from 'vuex';
import articles from './pages/articles/store';
import clients from './pages/clients/store';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        accessToken: null,
        isLoading: false,
        fullPage: true,
        color: '#20a8d8'
    },

    mutations: {
        setAccessToken(state, accessToken) {
            state.accessToken = accessToken;
        },
        updateIsLoading(state, isLoading) {
            state.isLoading = isLoading
        }
    },

    getters: {
        accessToken(state) {
            return state.accessToken;
        },
        isLoading(state) {
            return state.isLoading;
        },
        fullPage(state) {
            return state.fullPage;
        },
        color(state) {
            return state.color;
        },
    },

    actions: {
        updateIsLoading(context, isLoading) {
            context.commit('updateIsLoading', isLoading);
        },
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
        articles,
        clients
    },
});

export default store;
const store = {

    namespaced: true,

    state: {
        clients: [],
        filters: {
            orderByColumn: 'id',
            orderByValue: 'desc',
            page: 1,
            limit: 2
        },
        pagination: {},
    },

    mutations: {
        setClients(state, clients) {
            state.clients = clients;
        },
    },

    getters: {
        clients(state) {
            return state.clients;
        },
        pagination(state) {
            return state.pagination;
        },
        filters(state) {
            return state.filters;
        }
    },

    actions: {
        setClients(context, clients) {
            context.commit('setClients', clients);
        },
        loadClients(context, payload) {
            this.dispatch('updateIsLoading', true);
            axios.get('/client', {
                params: context.state.filters
            })
            .then(response => {
                context.dispatch('setClients', response.data.data);
                context.state.pagination = {
                    meta: response.data.meta,
                    links: response.data.links
                };
            })
            .catch(error => {
                console.log(error.response);
            })
            .finally(() => {
                this.dispatch('updateIsLoading', false);
            });
        },
    },

};

export default store;
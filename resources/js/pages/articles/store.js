const store = {

    namespaced: true,

    state: {
        articles: [],
        filters: {
            orderByColumn: 'id',
            orderByValue: 'desc',
            page: 1,
            limit: 2
        },
        pagination: {},
    },

    mutations: {
        setArticles(state, articles) {
            state.articles = articles;
        },
    },

    getters: {
        articles(state) {
            return state.articles;
        },
        pagination(state) {
            return state.pagination;
        },
        filters(state) {
            return state.filters;
        }
    },

    actions: {
        setArticles(context, articles) {
            context.commit('setArticles', articles);
        },
        loadArticles(context, payload) {
            axios.get('/article', {
                params: context.state.filters
            })
            .then(response => {
                context.dispatch('setArticles', response.data.data);
                context.state.pagination = {
                    meta: response.data.meta,
                    links: response.data.links
                };
            })
            .catch(error => {
                console.log(error.response);
            });
        },
    },

};

export default store;
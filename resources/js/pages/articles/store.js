const store = {

    namespaced: true,

    state: {
        articles: []
    },

    mutations: {
        setArticles(state, articles) {
            state.articles = articles;
        },
    },

    getters: {
        articles(state) {
            return state.articles;
        }
    },

    actions: {
        setArticles(context, articles) {
            context.commit('setArticles', articles);
        }
    },

};

export default store;
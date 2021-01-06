<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <router-link class="navbar-brand" to="/">
            The Company
        </router-link>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" exact to="/">
                        Articles
                    </router-link>
                </li>
            </ul>
            <button v-if="accessToken" 
                class="btn btn-outline-danger my-2 my-sm-0" 
                @click="logout">
                Logout
            </button>
        </div>
    </nav>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    computed: {
        ...mapGetters({
            'accessToken': 'accessToken',
        })
    },
    methods: {
        logout() {
            axios.post('/auth/logout')
            .then(response => {
                this.$store.dispatch('logout', {
                    $router: this.$router
                });
            })
            .catch(error => {
                console.log(error.response);
            });
        }
    }
}
</script>
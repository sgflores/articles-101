<template>
    <div class="card">
        <div class="card-header">
            Articles List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <table-sorter :columns="columns" :filters="filters" @applyFilterHandler="loadArticles"></table-sorter>
                    <tbody>
                        <tr v-for="list in articles" :key="list.id">
                            <td>{{list.id}}</td>
                            <td>{{list.created_at}}</td>
                            <td>{{list.client.name}}</td>
                            <td>{{list.client.email}}</td>
                            <td>
                                <RequiredWordCount :article="list"/>
                            </td>
                        </tr>
                    </tbody>
               </table>
            </div>
            <pagination :pagination="pagination" :paginateHandler="loadArticles"/>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import RequiredWordCount from './RequiredWordCount';
export default {
    computed: {
        ...mapGetters({
            'articles': 'articles/articles',
            'filters': 'articles/filters',
            'pagination': 'articles/pagination'
        })
    },
    components: {
        RequiredWordCount
    },
    data() {
        return {
            columns: [
                { column: 'id', label: 'Article ID', sortable: true },
                { column: 'created_at', label: 'Date Submitted', sortable: true },
                { column: 'clients.name', label: 'Client Name', sortable: true },
                { column: 'clients.email', label: 'Client Email', sortable: true },
                { column: 'required_word_count', label: 'Required Word Count', sortable: true }
            ],
        }
    },
    methods: {
        loadArticles(page) {
            this.filters.page = page || this.filters.page;
            this.$store.dispatch('articles/loadArticles');
        },
    },
    mounted() {
        this.loadArticles();
    }
}
</script>
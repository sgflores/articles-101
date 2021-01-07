<template>
    <div class="card">
        <div class="card-header">
            Clients List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <table-sorter :columns="columns" :filters="filters" @applyFilterHandler="loadClients"></table-sorter>
                    <tbody>
                        <tr v-for="list in clients" :key="list.id">
                            <td>{{list.id}}</td>
                            <td>{{list.name}}</td>
                            <td>{{list.email}}</td>
                            <td :class="{'clickable-label': list.articles.length >0}" @click="showArticles(list)">
                                {{list.articles.length}}
                            </td>
                        </tr>
                    </tbody>
               </table>
            </div>
            <pagination :pagination="pagination" :paginateHandler="loadClients"/>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
    computed: {
        ...mapGetters({
            'clients': 'clients/clients',
            'filters': 'clients/filters',
            'pagination': 'clients/pagination'
        })
    },
    data() {
        return {
            columns: [
                { column: 'id', label: 'Client ID', sortable: true },
                { column: 'name', label: 'Client Name', sortable: true  },
                { column: 'email', label: 'Client Email', sortable: true  },
                { column: 'articles', label: 'Total Articles', sortable: false  }
            ],
        }
    },
    methods: {
        loadClients(page = 1) {
            this.filters.page = page;
            this.$store.dispatch('clients/loadClients');
        },
        showArticles(list) {
            if (list.articles.length == 0) {
                return;
            }
            var trs = '';
            list.articles.forEach(article => {
                trs += `<tr>  
                    <td> ${article.id} </td>
                    <td> ${article.title} </td>
                    <td> ${article.required_word_count} </td>
                </tr>`;
            });
            var table = `
               <table class='table'>
                    <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Count</th>
                    </thead>
                    <tbody>${trs}</tbody>
               </table>
            `;
            Swal.fire({
                html: table,
                showCloseButton: true,
                showCancelButton: false,
                showConfirmButton: false
            });
        }
    },
    mounted() {
        this.loadClients();
    }
}
</script>
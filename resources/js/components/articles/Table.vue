<template>
    <div class="card">
        <div class="card-header">
            Articles List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <th class="pointer" v-for="list in header" :key="list.column">
                            {{list.label}}
                        </th>
                    </thead>
                    <tbody>
                        <tr v-for="list in articles" :key="list.id">
                            <td>{{list.id}}</td>
                            <td>{{list.created_at}}</td>
                            <td>{{list.client.name}}</td>
                            <td>{{list.client.email}}</td>
                            <td class="pointer">
                                <input type="number" required min="0" class="form-control" v-model="list.required_word_count" v-on:keyup.enter="updateCount(list)" >
                            </td>
                        </tr>
                    </tbody>
               </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            filters: {
                orderByColumn: 'id',
                orderByValue: 'desc',
                limit: 2
            },
            header: [
                { column: 'id', label: 'Article ID' },
                { column: 'created_at', label: 'Date Submitted' },
                { column: 'client.name', label: 'Client Name' },
                { column: 'client.email', label: 'Client Email' },
                { column: 'required_word_count', label: 'Required Word Count' }
            ],
            articles: []
        }
    },
    methods: {
        loadArticles() {
            axios.get('/article', {
                params: this.filters
            })
            .then(response => {
                console.log(response.data);
                this.articles = response.data.data;
            })
            .catch(error => {
                console.log(error.response);
            });
        },
    },
    mounted() {
        this.loadArticles();
    }
}
</script>
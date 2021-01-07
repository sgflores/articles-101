<template>
    <div class="card">
        <div class="card-header pointer" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true">
            Article Form
        </div>
        <div class="collapse show" id="collapseForm" style="">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <input type="text"
                            class="form-control mb-2"
                            v-model="form.title"
                            :class="{ 'is-invalid': form.errors.has('title') }"
                            placeholder="Title" />
                        <has-error :form="form" field="title"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea type="text"
                            class="form-control mb-2"
                            v-model="form.body"
                            :class="{ 'is-invalid': form.errors.has('body') }"
                            placeholder="Body" />
                        <has-error :form="form" field="body"></has-error>
                    </div>

                    <div class="form-group">
                        <select class="form-control mb-2"
                            v-model="form.client_id"
                            :class="{ 'is-invalid': form.errors.has('client_id') }">
                            <option value="" selected disabled>Please select a client</option>
                            <option v-for="list in clients" 
                                :key="list.id" 
                                :value="list.id">
                                {{list.name}}
                            </option>
                        </select>
                        <has-error :form="form" field="client_id"></has-error>
                    </div>

                    <div class="form-group">
                        <button :disabled="form.busy" type="button" 
                            class="btn btn-warning mb-2" 
                            @click="resetForm">Cancel</button>
                        <button :disabled="form.busy" type="submit" 
                            class="btn btn-primary mb-2">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { Form } from 'vform';
export default {
    data() {
        return {
            form: new Form({
                title: '',
                body: '',
                client_id: ''
            }),
            clients: []
        }
    },
    methods: {
        loadClients() {
            axios.get('/client')
            .then(response => {
                this.clients = response.data.data;
            })
            .catch(error => {
                console.log(error.response);
            });
        },
        resetForm() {
            this.form.clear();
            this.form.reset();
        },
        submit() {
            this.$store.dispatch('updateIsLoading', true);
            this.form.post('/article')
            .then(response => {
                this.resetForm();
                Toast.fire({
                    icon: 'success',
                    title: 'Successfully Added'
                });
                this.$store.dispatch('articles/loadArticles');
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: error.response.data.message || 'Invalid Data'
                });
            })
            .finally(() => {
                this.$store.dispatch('updateIsLoading', false);
            });
        }
    },
    mounted() {
        this.loadClients();
    }
}
</script>
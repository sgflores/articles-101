<template>
    <div class="card">
        <div class="card-header pointer" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true">
            Client Form
        </div>
        <div class="collapse show" id="collapseForm" style="">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <input type="text"
                            class="form-control mb-2"
                            v-model="form.name"
                            :class="{ 'is-invalid': form.errors.has('name') }"
                            placeholder="Name" />
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input type="email"
                            class="form-control mb-2"
                            v-model="form.email"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                            placeholder="Email" />
                        <has-error :form="form" field="email"></has-error>
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
                name: '',
                email: '',
            }),
        }
    },
    methods: {
        resetForm() {
            this.form.clear();
            this.form.reset();
        },
        submit() {
            this.$store.dispatch('updateIsLoading', true);
            this.form.post('/client')
            .then(response => {
                this.resetForm();
                Toast.fire({
                    icon: 'success',
                    title: 'Successfully Added'
                });
                this.$store.dispatch('clients/loadClients');
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
    }
}
</script>
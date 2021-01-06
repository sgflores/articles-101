<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-group">

                    <div class="card p-4">

                        <div class="card-body">

                            <form @submit.prevent="login">

                                <h1>Login</h1>
                                <p class="text-muted">Sign In to your account</p>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    </div>
                                    <input class="form-control" 
                                        type="email" 
                                        name="email" 
                                        placeholder="Email" 
                                        v-model="form.email" 
                                        :class="{ 'is-invalid': form.errors.has('email') }"
                                        autofocus>
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    </div>
                                    <input class="form-control" 
                                        type="password" 
                                        name="password" 
                                        v-model="form.password"
                                        :class="{ 'is-invalid': form.errors.has('password') }"
                                        placeholder="Password">
                                    <has-error :form="form" field="password"></has-error>
                                </div>

                                <button :disabled="form.busy" class="btn btn-primary col-md-12" type="submit">Login</button>
                                
                            </form>

                        </div>

                    </div>

                </div>
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
                email: '',
                password: '',
            }),
        }
    },
    methods: {
        login () {
            this.form.post('/auth/login')
            .then(response => {
                this.form.clear();
                this.form.reset();
                this.$store.dispatch('authenticate', {
                    accessToken: response.data.access_token,
                    $router: this.$router
                });
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: error.response.data.message || 'Invalid Credentials'
                });
            });
        }
    }
}
</script>
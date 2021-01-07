<template>
    <form @submit.prevent="submit">
        <div class="input-group mb-3">
            <input type="number"
                class="form-control"
                v-model="form.required_word_count"
                :class="{ 'is-invalid': form.errors.has('required_word_count') }"
                placeholder="Required Word Count">
            <div class="input-group-append">
                <button class="btn btn-sm btn-outline-secondary" type="submit">Update</button>
            </div>

            <has-error :form="form" field="required_word_count"></has-error>
        </div>
    </form>
</template>

<script>
import { Form } from 'vform';
export default {
    props: {
        article: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            form: new Form(this.article)
        }
    },
    methods: {
        submit() {
            this.form.put(`/article/${this.article.id}`)
            .then(response => {
                Toast.fire({
                    icon: 'success',
                    title: 'Successfully Updated'
                });
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: error.response.data.message || 'Invalid Data'
                });
            });
        }
    }
}
</script>
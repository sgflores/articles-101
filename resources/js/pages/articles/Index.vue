<template>
    <div>
        <ArticleForm />
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import ArticleForm from '../../components/articles/Form';
export default {
    computed: {
        ...mapGetters({

        })
    },
    components: {
        ArticleForm
    },
    data() {
        return {

        }
    },
    methods: {

    },
    created() {

    }
}
</script>
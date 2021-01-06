<template>
    <div>
        <ArticleForm />
        <hr />
        <ArticleTable />
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import ArticleForm from '../../components/articles/Form';
import ArticleTable from '../../components/articles/Table';
export default {
    computed: {
        ...mapGetters({

        })
    },
    components: {
        ArticleForm,
        ArticleTable
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
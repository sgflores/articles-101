<template>
    <div>
        <ArticleForm />
        <hr />
        <ArticleTable />
    </div>
</template>

<script>
import ArticleForm from '../../components/articles/Form';
import ArticleTable from '../../components/articles/Table';
export default {
    components: {
        ArticleForm,
        ArticleTable
    }
}
</script>
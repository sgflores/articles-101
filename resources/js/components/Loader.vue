<template>
    <div>
        <loading :active.sync="isLoading" :color="color" :is-full-page="fullPage" loader="dots"></loading>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    computed: {
        ...mapGetters({
            'isLoading': 'isLoading',
            'color': 'color',
            'fullPage': 'fullPage',
            'loader': 'loader'
        }),
    },
}
</script>
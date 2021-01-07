<template>
    <nav aria-label="Pagination" v-if="pagination.meta && pagination.links">
        <ul class="pagination">
            <li class="page-item">
                <span class="page-link pointer" aria-label="Previous"
                    :class="{'disabled-pagination': !pagination.links.prev }"
                    @click="pagination.links.prev && paginate(pagination.meta.current_page-1)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </span>
            </li>
            <li class="page-item" v-for="(list, index) in pagination.meta.last_page" :key="index">
                <span class="page-link pointer"
                    :class="{'disabled-pagination': (index+1 == pagination.meta.current_page) }"
                    @click="(index+1 != pagination.meta.current_page) && paginate(index+1)">{{index+1}}</span>
            </li>
            <li class="page-item">
                <span class="page-link pointer" aria-label="Next" 
                    :class="{'disabled-pagination': !pagination.links.next }"
                    @click="pagination.links.next && paginate(pagination.meta.current_page+1)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </span>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        pagination: {
            required: true,
        },
        paginateHandler: {
            required: true,
            type: Function
        }
    },
    methods: {
        paginate(page) {
            this.paginateHandler(page);
        }
    }
}
</script>
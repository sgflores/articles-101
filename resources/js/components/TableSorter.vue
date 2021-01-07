<template>
    <thead>
        <tr>
            <th class="pointer" v-for="(list, index) in columns" 
                :key="index" @click="orderBy(list)">
                {{list.label}}
                <span v-if="list.sortable"> 
                    <i class="fa fa-sort" v-if="currentSorterColumn != list.column"></i>
                    <i class="fa fa-sort-up" v-if="currentSorterColumn == list.column && currentSorterValue == 'asc'"></i>
                    <i class="fa fa-sort-down" v-if="currentSorterColumn == list.column && currentSorterValue == 'desc'"></i>
                </span>
            </th>
        </tr>
    </thead>
</template>

<script>
export default {
    props: {
        columns: {
            required: true,
            type: Array
        },
        filters: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            currentSorterColumn: '',
            currentSorterValue: 'asc'
        }
    },
    methods: {
        orderBy(list) {
            if (!list.sortable) {
                return;
            }
            this.currentSorterColumn = list.column;
            this.currentSorterValue = this.currentSorterValue == 'asc' ? 'desc' : 'asc';

            // update filters
            this.filters.orderByColumn = this.currentSorterColumn;
            this.filters.orderByValue = this.currentSorterValue;

            this.$emit('applyFilterHandler');
        }
    }
}
</script>
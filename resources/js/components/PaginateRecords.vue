<template>
    <div class="row">
        <div class="col-md-8">
            <pagination :data="records" :limit=3 v-on:pagination-change-page="getRecords"
                        class="m-l-10"></pagination>
        </div>
        <div class="col-md-4" v-if="records.total">
            <div class="pull-right m-r-10">
                <select name="page_length" class="form-control" :value="pageLength" @change="updateValue">
                    <option v-for="option in options" v-bind:value="option.value">
                        {{ option.title + ' per page' }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination'

export default {
    components: {pagination},
    props: ['pageLength', 'records'],
    data() {
        return {
            options: [
                {
                    value: 15,
                    title: 15
                },
                {
                    value: 25,
                    title: 25
                },
                {
                    value: 50,
                    title: 50
                },
                {
                    value: 0,
                    title: "All"
                },
            ]
        }
    },
    methods: {
        updateValue(e) {
            this.$emit('update:pageLength', e.target.value);
        },
        getRecords(page) {
            this.$emit('updateRecords', page);
        }
    }
}
</script>

<template>
    <div class="container">
        <label v-text="label"></label>
        <input class="" :type="type" :placeholder="placeholder" v-model="model">
    </div>

</template>

<script>
export default {
    name: 'Input',
    props: {
        type: String,
        placeholder: String,
        label: String,
        model: Object,
    },
    methods:{
        onChange() {
            // this.$emit('')
        }
    }
}
</script>

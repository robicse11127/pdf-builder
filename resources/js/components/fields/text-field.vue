<template>
    <div>Text Field</div>
</template>

<script>
export default {
    data() {
        return {
            props: ['test'],
        }
    },

    mounted() {
        console.log(this.test)
    }
}
</script>

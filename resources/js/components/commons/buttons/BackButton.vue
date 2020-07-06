<template>
    <div class="back-button">
        <slot></slot>
        <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
    </div>
</template>

<script>
export default {
    props: [
        'back_name',
    ],
    data () {
        return {
            //
        }
    },
    mounted: function () {
        // console.log(this.value)
    },
    watch: {
        //
    },
    computed: {
        //
    },
    methods: {
        onBack: function () {
            if (this.back_name) {
                this.$router.push({ name: this.back_name })
            } else {
                this.$router.go(-1)
            }
        }
    },
    components: {
        //
    },
}
</script>

<style lang="scss">
@import "resources/sass/variables";
.back-button {
    position: absolute;
    top: 20px;
    right: 20px;
}
</style>

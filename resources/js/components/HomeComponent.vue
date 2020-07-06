<template>
<div class="container">
	<div class="card text-center">
        <div class="card-body">
            <h3 class="title-margin mt-3 mb-5">メニュー</h3>
            <div class="d-flex justify-content-center mb-2" v-if="show">
                <router-link :to="{ name: 'report' }" class="btn btn-primary btn-menu mr-3 mb-3">作業日報</router-link>
                <router-link :to="{ name: 'setting' }" class="btn btn-dark btn-menu mr-3 mb-3" v-if="own.is_admin || own.name =='user01'">設定管理</router-link>
            </div>
        </div>
	</div>
</div>
</template>

<script>
export default {
    props: [
        //
    ],
    data () {
        return {
            show: false,
        }
    },
    mounted () {
        setTimeout(() => {
            this.show = true
        }, 500)
    },
    watch: {
        //
    },
    computed: {
        own: function () {
            return this.$store.state.user
        },
    },
    methods: {
        //
    },
}
</script>

<style lang="scss" scoped>
@import "resources/sass/variables";
.btn-menu {
    height: 6rem;
    width: 9rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
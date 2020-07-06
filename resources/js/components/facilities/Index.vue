<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start mb-3">
                        <div class="mr-auto">
                            <span class="span-header">設備一覧</span>
                        </div>
                        <div class="align-self-center mr-3">
                            <button type="button" class="btn btn-secondary" @click="categoryList"><i class="fas fa-list-ul"></i> 機械一覧</button>
                        </div>
                        <div class="align-self-center mr-3">
                            <button type="button" class="btn btn-primary" @click="onCreate"><i class="fas fa-plus"></i> 新規追加</button>
                        </div>
                        <div class="align-self-center">
                            <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
                        </div>
                    </div>

                    <table class="table-custom" key="processes">
                        <thead>
                            <tr>
                                <th class="text-center">管理番号</th>
                                <th class="text-center">機械</th>
                                <th class="text-center">名称</th>
                                <th class="text-center">型番</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="facility in facilities" class="clickable" :key="facility.id" @click="onShow(facility.id)">
                                <td class="text-center align-middle">{{facility.code}}</td>
                                <td class="text-center align-middle">{{facility.category_name}}</td>
                                <td class="text-center align-middle">{{facility.name}}</td>
                                <td class="text-center align-middle">{{facility.model_number}}</td>
                            </tr>
                        </tbody>
                        <loading :active.sync="isLoading"></loading>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import moment from 'moment';
export default {
    props: [

    ],
    data () {
        return {
            facilities: [],
            isLoading: false,
        }
    },
    mounted () {
        this.inspected_on = new moment().format('YYYY-MM-DD')
        this.getItems()
    },
    watch: {
        //
    },
    computed: {
        //
    },
    methods: {
        getItems: function () {
            this.isLoading = true;
            const api = axios.create()
            axios.all([
                api.get('/api/facility'),
            ]).then(axios.spread((res1, res2, res3, res4) => {
                this.facilities = res1.data

                this.isLoading = false
            }))
        },
        onCreate: function () {
            this.$router.push({ name: 'facility.create' })
        },
        onShow: function (facility_id) {
            this.$router.push({ name: 'facility.show', params: {facility_id: facility_id} })
        },
        onBack: function () {
            this.$router.go(-1)
        },
        categoryList: function () {
            this.$router.push({ name: 'category' })
        }
    },
    components: {
        // Loading
    },
}
</script>

<style lang="scss" scoped>
@import "resources/sass/variables";
</style>

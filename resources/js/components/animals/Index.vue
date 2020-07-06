<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start mb-3">
                        <div class="mr-auto">
                            <span class="span-header">動物一覧</span>
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
                                <th class="text-center">名前</th>
                                <th class="text-center">性別</th>
                                <th class="text-center">年齢</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr v-for="animal in animals" class="clickable" :key="animal.id" @click="onShow(animal.id)">
                                <td class="text-center align-middle">{{animal.name}}</td>
                                <td class="text-center align-middle">{{animal.gender}}</td>
                                <td class="text-center align-middle">{{animal.age}}</td>
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
            animals: [],
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
                api.get('/api/animal'),
            ]).then(axios.spread((res1, res2, res3, res4) => {
                this.animals = res1.data
                
                this.isLoading = false
            }))
        },
        onCreate: function () {
            this.$router.push({ name: 'animal.create' })
        },
        onShow: function (animal_id) {
            this.$router.push({ name: 'animal.show', params: {animal_id: animal_id} })
        },
        onBack: function () {
            this.$router.go(-1)
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
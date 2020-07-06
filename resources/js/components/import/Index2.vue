<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start mb-3">
                        <div class="mr-auto">
                            <span class="span-header">得意先マスタ　商品マスタ　CSV取込</span>
                        </div>
                        <div class="align-self-center">
                            <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 d-flex align-items-center">得意先マスタ</div>
                        <div class="col-sm-7">
                            <csv-importer @file-change="customers=$event" :file_name.sync="customer_file_name"/>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" @click="onImport('customer', customers)">取込</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 d-flex align-items-center">商品マスタ</div>
                        <div class="col-sm-7">
                            <csv-importer @file-change="items=$event" :file_name.sync="item_file_name"/>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" @click="onImport('item', items)">取込</button>
                        </div>
                    </div>
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
            isLoading: false,
            customer_file_name: '',
            item_file_name: '',
            customers: [],
            items: [],
        }
    },
    mounted () {
    },
    watch: {
        //
    },
    computed: {
        //
    },
    methods: {
        onImport: function (name, datas) {
            if(!datas.length) {
                alert('データが空です。')
                return
            }
            console.log(datas)
            this.isLoading = true
            let _this = this
            let url = '/api/' + name + '/import'
            axios.post(url, {
                datas: datas,
            })
            .then(function (resp) {
                alert('CSVを取り込みました。')
                console.log(resp)
            })
            .catch(function (resp) {
                // _this.errors = resp.response.data.errors
                alert('CSVを取り込みに失敗しました。')
                console.log(resp)
            })
            .finally(function (resp) {
                _this.isLoading = false
            });
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
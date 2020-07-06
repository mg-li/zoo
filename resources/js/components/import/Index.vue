<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-start mb-5">
                        <div class="mr-auto">
                            <span class="span-header">トレロ　CSV取込</span>
                        </div>
                        <div class="align-self-center">
                            <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-2">
                        <div class="col-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" v-model="checked">
                                <label class="custom-control-label" for="customCheck1">ヘッダーあり</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 d-flex justify-content-center align-items-center">トレロ</div>
                        <div class="col-sm-7">
                            <csv-importer @file-change="items=$event" :file_name.sync="item_file_name" :is_header="checked"/>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" @click="onImport('item', items)">取込</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
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
            checked: true,
            isLoading: false,
            fullPage: false,
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
<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" key="admin">
                <div class="card-body">
                    <div class="d-flex justify-content-start mb-3">
                        <div class="mr-auto">
                            <span class="span-header">{{title}}</span>
                        </div>
                        <div class="align-self-center">
                            <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
                        </div>
                    </div>
                    <form>
                        <div class="form-group required-label row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">名前</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="last_name" v-model="animal.name"/>
                            </div>
                        </div>
                        <div class="form-group required-label row">
                            <!-- <label for="last_name" class="col-sm-4 col-form-label text-md-right">性別</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="last_name" v-model="animal.gender"/>
                            </div> -->
                            <label for="gender"  class="col-sm-4 col-form-label text-md-right">性別</label>
                            <div class="col-md-6">
                                <select class="form-control" v-model="animal.gender" name="性別">
                                    <option></option>
                                    <option value="オス">オス</option>
                                    <option value="メス">メス</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group required-label row">
                            <label for="age" class="col-sm-4 col-form-label text-md-right">年齢</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="last_name" v-model="animal.age"/>
                            </div>
                        </div>
                        <div class="row-line">
                            <transition name="fade" mode="out-in">
                            <div class="alert alert-danger" role="alert" v-if="invalid">
                            {{errorMessage}}
                            </div>
                            </transition>
                        </div>
                    </form>
                    <div class="d-flex justify-content-start mt-4">
                        <div class="mr-auto">
                            <button type="button" class="btn btn-outline-danger" v-if="enable_delete" @click="onDelete">この動物を削除する</button>
                        </div>
                        <div class="mr-3">
                            <button type="button" class="btn btn-dark" @click="onBack">キャンセル</button>
                        </div>
                        <div v-if="mode!='create'">
                            <button type="button" class="btn btn-primary" @click="onStore">保存する</button>
                        </div>
                        <div v-else>
                            <button type="button" class="btn btn-primary" @click="onStore">登録する</button>
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
        'animal_id',
    ],
    data () {
        return {
            animal: {
                id: '',
                name: '',
                gender: '',
                age: '',
            },
            roles: [],
            invalid: false,
            errorMessage: '',

            isLoading: false,
            fullPage: false,
        }
    },
    created () {
        this.getItems()
    },
    computed: {
        own: function () {
            return this.$store.state.user
        },
        title: function () {
            return this.mode == 'create' ? '動物の新規作成' : '動物の編集'
        },
        mode: function () {
            return this.animal_id ? 'update' : 'create'
        },
        enable_delete: function () {
            if (this.mode == 'create') {
                return false
            }
            return this.own.animal_id != this.animal_id
        }
    },
    methods: {
        getInit: function () {
            // this.isLoading = true;
            // const api = axios.create()
            // axios.all([
            //     api.get('/api/team/selector'),
            // ]).then(axios.spread((res1, res2, res3) => {
            //     this.getItems()
            // }))
        },
        getItems: function () {
            this.isLoading = true;
            const api = axios.create()
            if (this.mode == "create") {
                this.isLoading = false
            } else {
                axios.all([
                    api.get('/api/animal/'+this.animal_id),
                ]).then(axios.spread((res1, res2, res3) => {
                    this.animal = res1.data
                    this.isLoading = false
                }))
            }
        },
        onStore: function () {
            this.invalid = false
            this.errorMessage = ''
            if (!this.animal.name) {
                this.errorMessage = '名前を入力してください。'
                this.invalid = true
                return
            }
            if (!this.animal.gender) {
                this.errorMessage = '性別を入力してください。'
                this.invalid = true
                return
            }
            if (!this.animal.age) {
                this.errorMessage = '年齢を入力してください。'
                this.invalid = true
                return
            }
         
            let _this = this
            if (this.mode == 'create') {
                axios.post('/api/animal', {
                    animal: this.animal,
                    teams: this.teams,
                })
                .then(function (resp) {
                    if (resp.data.result) {
                        alert('登録しました。')
                        _this.$router.go(-1)
                    } else {
                        _this.errorMessage = resp.data.errorMessage
                        _this.invalid = true
                    }
                })
                .catch(function (resp) {
                    console.log(resp)
                });
            } else {
                axios.put('/api/animal/'+this.animal.id, {
                    animal: this.animal,
                    teams: this.teams,
                })
                .then(function (resp) {
                    if (resp.data.result) {
                        alert('更新しました。')
                        _this.$router.go(-1)
                    } else {
                        _this.errorMessage = resp.data.errorMessage
                        _this.invalid = true
                    }
                })
                .catch(function (resp) {
                    console.log(resp)
                });
            }
        },
        onBack: function () {
            // this.$emit('cancel');
            this.$router.go(-1)
        },
        onDelete: function () {
            if (!confirm('削除してもよろしいですか？')) {
                return
            }
            let _this = this
            axios.delete('/api/animal/'+this.animal.id)
            .then(function (resp) {
                alert('削除しました。')
                _this.$router.go(-1)
            })
            .catch(function (resp) {
                console.log(resp)
            })
            .finally(function () {
                //
            })
        },
        
    },
    components: {
        // Loading
    },
}
</script>

<style lang="scss" scoped>
@import "resources/sass/variables";
.row-line {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    padding-bottom: 1rem;
}
.form-content {
    width: 12rem;
    padding-left: 1rem;
    padding-right: 1rem;
    display: inline-block;
}
.form-content-lg {
    width: 15rem;
    padding-left: 1rem;
    padding-right: 1rem;
    display: inline-block;
}
.required-label label:after {
    display: inline-block;
    margin-left: 5px;
    padding: 2px 4px;
    border-radius: 3px;
    background-color: #ec5d53;
    color: #fff;
    content: "必須";
    font-size: 9px;
    line-height: 10px;
}
</style>

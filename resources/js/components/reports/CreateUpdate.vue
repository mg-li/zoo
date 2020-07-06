<template>
<div class="container-fluid">
	<div class="card item-center" v-show="show">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-4">
                <div class="mr-auto">
                    <span class="span-header">作業日報</span>
                </div>
                <div class="align-self-right">
                    <button v-if="mode!='create'&&!disabled" type="button" class="btn btn-primary" @click="onCopy">コピーを作成</button>
                </div>
                <!-- <div class="ml-3">
                    <button v-if="mode!='create'" type="button" class="btn btn-info" @click="onDownload">ダウンロード</button>
                </div> -->
                <div class="ml-3">
                    <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
                </div>
            </div>
            <div class="card-block mb-3">
                <div class="card-search-body">
                    <div class="d-flex">
                        <div class="mr-2 align-self-center">
                            作業日
                        </div>
                        <div class="mr-3">
                            <date-picker-standard v-model="report.started_on"/>
                        </div>
                        <div class="mr-2 align-self-center">
                            担当者
                        </div>
                        <div class="w-25">
                            <multiselect v-model="report.employees" :options="employees" :multiple="true" :searchable="false" placeholder="" label="name" track-by="name" selectLabel="" :disabled="disabled" style="font-size:20px;"></multiselect>
                        </div>
                    </div>
                </div>
            </div>

            <template v-for="(report_detail, index) in report.report_details">
                <div :key="index">
                    <hr>
                    <div class="d-flex">
                        <div class="flex-shrink-1 align-items-stretch p-2 mr-2" style="background-color:#fff3e0;">
                            No.{{index+1}}
                        </div>
                        <div class="w-100">
                            <div class="d-flex flex-wrap justify-content-start">
                                <div class="d-flex mb-2">
                                    <div class="align-self-center mr-2">工程</div>
                                    <div class="align-self-center mr-3">
                                        <!-- v-if="!disabled" -->
                                        <select class="form-control" v-model="report_detail.item_process">
                                            <option></option>
                                            <option v-for="process in processes" :key="process" :value="process">{{process}}</option>
                                        </select>
                                        <!-- <span v-else>{{report_detail.item_process}}</span> -->
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="align-self-center mr-2">フラムNo</div>
                                    <div class="align-self-center mr-3" v-show="report_detail.item_flam">
                                        {{ report_detail.item_flam }}
                                    </div>
                                    <div class="align-self-center mr-3">
                                        <input class="form-control" type="text" v-model="report_detail.item_no">
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="align-self-center mr-2">商品名</div>
                                    <div class="align-self-center mr-auto">
                                        <select class="form-control" v-model="report_detail.item_id">
                                            <option></option>
                                            <option v-for="item in filterItems(report_detail)" :key="item.id" :value="item.id">{{item.name}}</option>
                                        </select>
                                    </div>
                                    <div class="align-self-center ml-2 mr-auto">
                                        <input class="form-control" type="text" v-model="report_detail.item_name" v-if="report_detail.item_no && !report_detail.item_id">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-2">
                                <div class="align-self-center mr-2">機械</div>
                                <div class="align-self-center mr-3">
                                    <!-- v-if="!disabled" -->
                                    <select class="form-control" v-model="report_detail.category_id">
                                        <option></option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                    </select>
                                    <!-- <span v-else>{{report_detail.category_name}}</span> -->
                                </div>
                                <div class="align-self-center mr-2">設備</div>
                                <div class="align-self-center mr-auto">
                                     <!-- v-if="!disabled" -->
                                    <select class="form-control" v-model="report_detail.facility_id" v-if="!(report_detail.category_id == 14)">
                                        <option></option>
                                        <option v-for="facility in filterFacilities(report_detail)" :key="facility.id" :value="facility.id">{{facility.name}} {{facility.model_number}}</option>
                                    </select>
                                    <input class="form-control" type="text" v-model="report_detail.facility_other" v-else style="width:20rem;">
                                    <!-- <span v-else>{{report_detail.facility_name}}</span> -->
                                </div>
                            </div>

                            <div class="d-flex justify-content-start mb-2">
                                <div class="align-self-center mr-2">段取り時間</div>
                                <div class="d-flex align-self-center mr-3" style="width:7rem;">
                                    <modal-keypad v-model="report_detail.setup_time" layouts="123|456|789|0-.|{del:backspace}{ok:ok}" />
                                    <div class="align-self-center mx-1">H</div>
                                </div>
                                <div class="align-self-center mr-2">作業時間</div>
                                <div class="d-flex align-self-center mr-3" style="width:7rem;">
                                    <modal-keypad v-model="report_detail.work_time" layouts="123|456|789|0-.|{del:backspace}{ok:ok}" />
                                    <div class="align-self-center mx-1">H</div>
                                </div>
                                <div class="align-self-center mr-2">製造完了数</div>
                                <div class="d-flex align-self-center mr-5" style="width:7rem;">
                                    <modal-keypad v-model="report_detail.finish_num" layouts="123|456|789|0-.|{del:backspace}{ok:ok}" />
                                    <div class="align-self-center mx-1">個</div>
                                </div>

                                <div class="align-self-center mr-2" v-if="!disabled">
                                    <button type="button" class="btn btn-sm btn-primary btn-change" @click="addRow">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="align-self-center" v-if="!disabled">
                                    <button type="button" class="btn btn-sm btn-outline-danger" v-if="index>=1" @click="removeRow(index)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start mb-2">
                                <!-- <div class="align-self-center mr-2">製造指示数</div>
                                <div class="align-self-center mr-4" style="width:5rem;">
                                    <modal-keypad v-model="report_detail.instruction_num" layouts="123|456|789|0-.|{del:backspace}{ok:ok}" v-if="!disabled"/>
                                    <span v-else>{{report_detail.instruction_num}}</span>
                                </div> -->
                                <div class="align-self-center mr-2">添付</div>
                                <div class="align-self-center">
                                    <button type="button" class="btn btn-primary" @click="onShowAttachment(report_detail.attachments)">
                                        <i class="fas fa-paperclip"></i>
                                        <!-- <span class="badge" v-if="attachments.length>0">{{attachments.length}}</span> -->
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <div class="form-group mt-3">
                <label for="remarks">備考</label>
                <textarea class="form-control" id="remarks" rows="4" v-model="report.remarks" :disabled="disabled"></textarea>
            </div>
            <div>
                <transition name="fade" mode="out-in">
                    <div class="alert alert-danger" role="alert" v-if="invalid">
                        {{errorMessage}}
                    </div>
                </transition>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-outline-danger mr-auto" v-if="mode!='create'" @click="onDelete" v-show="!disabled">この作業日報を削除する</button>
                <button v-if="this.mode=='create'" type="button" class="btn btn-info" style="width:15rem;" @click="onStore">登録</button>
                <button v-else type="button" class="btn btn-info text-white" style="width:15rem;" @click="onStore">更新</button>
            </div>
        </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
    <modal-dialog :show="showAttachment" hide-header hide-footer @close="showAttachment=false">

        <template v-slot:body>
            <file-uploader
                :token="token"
                postAction="/api/attachments/report_detail"
                :uploaded-files.sync="attachments"
                :read-only="disabled"
            >
            </file-uploader>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" @click="showAttachment=false">閉じる</button>
            </div>
        </template>
    </modal-dialog>
</div>
</template>

<script>
import moment from 'moment';
export default {
    props: [
        'report_id',
        'copy_report_id',
    ],
    data () {
        return {
            report: {
                id: '',
                started_on: '',
                finished_on: '',
                employees: [],
                remarks: '',
                report_details: [
                    // {
                    //     report_id: null,
                    //     customer: { id: null, code: null },
                    //     item: { id: null, code: null },
                    //     facility: { id: null, code: null },
                    //     instruction_num: null,
                    //     facility_time: null,
                    //     finish_num: null,
                    //     work_time: null,
                    // }
                ],
                is_finished: false,
            },
            process: '',
            processes: [
                'レーザー', '溶接', 'フライス' ,'旋盤', 'マシニング', '門型', 'シャーリング', 'プレス', '酸洗',
            ],
            employees: [],
            categories: [],
            facilities: [],
            attachments: [],
            showAttachment: false,
            show: true,
            modal: false,
            isLoading: false,
            fullPage: false,
            invalid: false,
        }
    },
    created () {
        //
    },
    mounted: function () {
        this.getInit()
        if(!this.report.started_on && !this.report.finished_on) {
            this.report.started_on = this.getToday()
            this.report.finished_on = this.getToday()
        }
    },
    watch: {
    },
    computed: {
        own: function () {
            return this.$store.state.user
        },
        mode: function () {
            return this.report_id ? 'update' : 'create'
        },
        token: function () {
            return axios.defaults.headers.common['X-CSRF-TOKEN']
        },
        disabled: function () {
            return !this.own.is_admin && !this.own.name == 'user01'
        },
        filterFacilities: function () {
            return function (report_detail) {
                if (report_detail.category_id) {
                    return this.facilities.filter( elem => elem.category_id == report_detail.category_id)
                    return []
                } else {
                    return this.facilities
                }
            }
        },
        filterProcesses: function () {
            //重複削除
            var result = this.items.filter(function(v1,i1,a1){
                return (a1.findIndex(function(v2){
                    return (v1.process===v2.process)
                }) === i1);
            });
            return result
        },
        filterItems: function () {
            var result = [];
            return function (report_detail) {
                // Noによる絞り込み
                result = this.items
                if (report_detail.item_no) {
                    result = result.filter(function(elem) {
                        if (elem.flam) {
                            return elem.flam.indexOf(report_detail.item_no) > -1;
                        }
                    })
                }
                return result
                // if (report_detail.item_process) {
                //     // 工程名による絞り込み
                //     result = this.items.filter( elem => elem.process == report_detail.item_process)
                //     // Noによる絞り込み
                //     if (report_detail.item_no) {
                //         result = result.filter(function(elem) {
                //             return elem.name.indexOf(report_detail.item_no) > -1;
                //         })
                //     }
                //     return result
                // } else {
                //     return
                // }
            }
        },
    },
    methods: {
        getToday: function () {
            var dt = new Date();
            var y = dt.getFullYear();
            var m = ("00" + (dt.getMonth()+1)).slice(-2);
            var d = ("00" + dt.getDate()).slice(-2);
            var result = y + "-" + m + "-" + d;
            return result;
        },
        getInit: function () {
            this.isLoading = true
            const api = axios.create()
            axios.all([
                api.get('/api/employee/selector'),
                api.get('/api/facility/selector'),
                api.get('/api/category/selector'),
                api.get('/api/item/selector'),
            ]).then(axios.spread((res1, res2, res3, res4, res5, res6, res7, res8) => {
                this.employees = res1.data
                this.facilities = res2.data
                this.categories = res3.data
                this.items = res4.data
                this.getItems()
            }))
        },
        getItems: function () {
            this.isLoading = true;
            const api = axios.create()
            if (this.mode == "update") {
                axios.all([
                    api.get('/api/report/'+this.report_id),
                ]).then(axios.spread((res1, res2, res3) => {
                    this.report = res1.data
                    this.isLoading = false
                }))
            } else if (this.copy_report_id) {
                // コピー作成
                const api = axios.create()
                let report_id = this.copy_report_id
                axios.all([
                    api.get('/api/report/'+ report_id),
                ]).then(axios.spread((res1) => {
                    this.report = res1.data
                    this.report.report_details.forEach((elem) => {
                        elem.setup_time = ''
                        elem.finish_num = ''
                        elem.work_time = ''
                        elem.attachments = []
                    })
                    this.isLoading = false
                }))
            } else {
                this.addRow()
                this.isLoading = false
            }
            // this.isLoading = true;
            // const api = axios.create()
            // if (this.mode == "update") {
            //     // 更新
            //     let report_id = this.report_id
            //     axios.all([
            //         api.get('/api/report/show/'+ report_id),
            //     ]).then(axios.spread((res1, res2, res3) => {
            //         this.report = res1.data
            //         if (this.report.lathe_tools.length == 0) {
            //             this.report.lathe_tools.push({
            //                 id: null,
            //                 report_id: '',
            //                 number: '',
            //                 tool_name_id: '',
            //                 tool_size_id: '',
            //                 processing_section: '',
            //                 processing_state: '',
            //                 tool_tip_id: '',
            //                 tip_type_id: '',
            //                 stick_out: '',
            //             })
            //         }
            //         if (this.report.lathe_measuring_tools.length == 0) {
            //             this.report.lathe_measuring_tools.push({
            //                 id:null,
            //                 report_id: '',
            //                 measuring_tool_name_id: '',
            //                 measuring_tool_size_id: '',
            //             })
            //         }
            //         this.isLoading = false
            //     }))
            // } else if (this.copy_report_id) {
            //     // コピー作成
            //     const api = axios.create()
            //     let report_id = this.copy_report_id
            //     axios.all([
            //         api.get('/api/report/'+ report_id),
            //     ]).then(axios.spread((res1) => {
            //         this.report = res1.data
            //         this.isLoading = false
            //     }))
            // } else {
            //     // 新規作成
            //     this.isLoading = false
            // }
        },
        onStore: function () {
            this.invalid = false
            this.errorMessage = ''

            this.report.report_details.forEach((report_detail) => {
                if (report_detail.category_id == 14){
                    report_detail.facility_id = null
                } else {
                    report_detail.facility_other = null
                }
            })

            if (!this.report.started_on || !this.report.finished_on) {
                this.invalid = true
                this.errorMessage = '作業日を入力してください。'
                return
            }
            if (this.report.employees.length == 0) {
                this.invalid = true
                this.errorMessage = '担当者を選択してください。'
                return
            }
            for (let i = 0; this.report.report_details.length >= i + 1; i++) {
                // if (!this.report.report_details[i].item_id) {
                //     if (!this.report.report_details[i].item_name) {
                //         this.invalid = true
                //         this.errorMessage = '商品名を選択または入力してください。'
                //         return
                //     }
                // }
                if (!this.report.report_details[i].category_id) {
                    this.invalid = true
                    this.errorMessage = '機械を選択してください。'
                    return
                }
                if (!this.report.report_details[i].facility_id && !this.report.report_details[i].facility_other) {
                    this.invalid = true
                    this.errorMessage = '設備を入力してください。'
                    return
                }
                // if (!this.report.report_details[i].instruction_num) {
                //     this.invalid = true
                //     this.errorMessage = '製造指示数を入力してください。'
                //     return
                // }
                // if (!this.report.report_details[i].setup_time) {
                //     this.invalid = true
                //     this.errorMessage = '段取り時間を入力してください。'
                //     return
                // }
                // if (!this.report.report_details[i].work_time) {
                //     this.invalid = true
                //     this.errorMessage = '作業時間を入力してください。'
                //     return
                // }
                // if (!this.report.report_details[i].finish_num) {
                //     this.invalid = true
                //     this.errorMessage = '製造完了数を入力してください。'
                //     return
                // }
            }

            // if (!this.own.is_admin) {
            //     let list = this.report.report_details.filter(element => {
            //         if (!element.item_name) {
            //             // this.invalid = true
            //             // this.errorMessage = '商品が入力されていません。'
            //             return
            //         }
            //         if (element.item_name.indexOf('CAP') > -1) {
            //             if (element.setup_time == '' || element.setup_time == null) return true
            //             if (element.work_time == '' || element.work_time == null) return true
            //         }
            //     })
            //     if (list.length > 0) {
            //         this.invalid = true
            //         this.errorMessage = '商品が「CAP」の場合は、段取り時間と作業時間を入力してください。'
            //         return
            //     }
            // }
            let incomplete = this.report.report_details.filter(element => {
                // if (element.instruction_num > element.finish_num || element.finish_num == '' || element.finish_num == null) return true
                // if (element.setup_time == '' || element.setup_time == null) return true
                // if (element.work_time == '' || element.work_time == null) return true
                if (element.finish_num > 0) return
            })
            if (incomplete.length > 0) {
                this.report.is_finished = false
            } else {
                this.report.is_finished = true
            }

            this.isLoading = true;
            let _this = this
            if (this.mode == 'create') {
                axios.post('/api/report', {
                    report: this.report,
                })
                .then(function (resp) {
                    if (resp.data.result) {
                        _this.isLoading = false
                        alert('登録しました。')
                        _this.$router.push({ name: 'report'})
                    } else {
                        _this.isLoading = false
                        _this.errorMessage =　resp.data.errorMessage
                        _this.invalid = true
                    }
                })
                .catch(function (resp) {
                    console.log(resp)
                });
            } else {
                axios.put('/api/report/'+this.report.id, {
                    report: this.report,
                })
                .then(function (resp) {
                    if (resp.data.result) {
                        _this.isLoading = false
                        alert('更新しました。')
                        _this.$router.go(-1)
                    } else {
                        _this.isLoading = false
                        _this.errorMessage =　resp.data.errorMessage
                        _this.invalid = true
                    }
                })
                .catch(function (resp) {
                    console.log(resp)
                });
            }
        },
        onBack: function () {
            this.$router.push({ name: 'report'})
        },
        onDelete: function () {
            if (!confirm('削除してもよろしいですか？')) {
                return
            }
            let _this = this
            axios.delete('/api/report/'+this.report.id)
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
        onCopy: function () {
            this.$router.push({ name: 'report.copy', params: { copy_report_id: this.report.id } })
        },
        addRow: function () {
            this.report.report_details.push({
                id: null,
                // customer: {},
                item_id: null,
                category_id: null,
                facility_id: null,
                facility_other: null,
                instruction_num: null,
                finish_num: null,
                setup_time: null,
                facility_time: null,
                work_time: null,
                attachments: [],
            })
        },
        removeRow: function (index) {
            this.report.report_details.splice(index, 1)
        },
        onDownload: function () {
            let _this=this
            axios({
                method:'post',
                url:'/api/report/download/'+this.report.id,
                responseType:'blob',
                dataType: 'binary',
                data: {
                    data: this.$data,
                }
            })
            .then(function (res1) {
                const url = window.URL.createObjectURL(new Blob([res1.data]))
                const link = document.createElement('a')
                link.href = url
                let report_updated_at = _this.report.updated_at;
                let filename= report_updated_at+'.xlsx'
                link.setAttribute('download', 'NC旋盤加工指示書_'+filename)
                document.body.appendChild(link)
                link.click()
            });
        },
        onSearchCustomer: function (code, name, callback) {
            axios.get('/api/customer/selector', {
                params: {
                    code: code,
                    name: name,
                }
            }).then(function (res) {
                callback(res.data)
            })
        },
        onFindCustomer: function (code, callback) {
            axios.get('/api/customer/selector', {
                params: {
                    code: code,
                }
            }).then(function (res) {
                console.log(res)
                const data = res.data.find( elem => elem.code == code )
                callback(res.data)
            })
        },
        onSearchItem: function (process, name, callback) {
            axios.get('/api/item/selector', {
                params: {
                    process: process,
                    name: name,
                }
            }).then(function (res) {
                callback(res.data)
            })
        },
        // onFindItem: function (process, callback) {
        //     axios.get('/api/item/selector', {
        //         params: {
        //             process: process,
        //         }
        //     }).then(function (res) {
        //         const data = res.data.find( elem => elem.code == code )
        //         callback(data)
        //     })
        // },
        onShowAttachment: function (attachments) {
            this.attachments = attachments
            this.showAttachment = true
        }
    },
    components: {
        //
    },

}
</script>
<style lang="scss" scoped>
@import "resources/sass/variables";

.table td {
    padding-left: 1px;
    padding-right: 1px;
}
</style>
<style lang="css">
.multiselect__tag {
    margin-bottom: 0;
}
</style>

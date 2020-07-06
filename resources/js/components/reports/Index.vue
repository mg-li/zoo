<template>
<div class="container-fluid">
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-start mb-3">
            <div class="mr-auto">
                <span class="span-header">作業日報一覧</span>
            </div>
            <div class="align-self-center mr-2">
                <button type="button" class="btn btn-success" @click="downloadCSV"><i class="fa fa-download"></i> CSV</button>
            </div>
            <div class="align-self-center mr-2">
                <button type="button" class="btn btn-info" @click="onCreate" v-if="user01 || own.is_admin"><i class="fas fa-plus"></i> 新規追加</button>
            </div>
            <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
            </div>
        </div>
        <div class="card-block mb-3">
            <form class="form-inline">
                <div class="form-group mr-sm-2">
                    <date-picker-from-to label="作業日" :from_dt.sync="started_from" :to_dt.sync="started_to" />
                </div>
                <div class="align-self-center ml-3">
                    <button type="button" class="btn btn-primary" @click="onSearch">検索</button>
                </div>
            </form>
            <!-- <form class="form-inline d-flex mt-3"> -->

                <!-- <div class="form-group">
                    <label class="mr-sm-2 ml-sm-4">得意先名</label>
                    <select class="form-control" v-model="selectedCustomer">
                        <option></option>
                        <option v-for="customer in customers" :key="customer.id" :value="customer.name">{{customer.name}}</option>
                    </select>
                </div> -->
            <!-- </form> -->
        </div>
        <div class="card-block mb-3">
            <div class="row mt-2">
                <div class="d-flex col-md-auto mb-2">
                    <div class="align-self-center mr-2">フラムNo</div>
                    <div class="align-self-center mr-3">
                        <input class="form-control" type="text" v-model="searchNo">
                    </div>
                </div>
                <!-- <div class="d-flex col-md-auto mb-2">
                    <div class="align-self-center mr-2">工程</div>
                    <div>
                        <select class="form-control" v-model="selectedProcess">
                            <option></option>
                            <option v-for="(process, index) in filterProcesses" :key="index" >{{process}}</option> -->
                            <!-- <option v-for="item in items" :key="item.id" :value="item.name">{{item.name}}</option> -->
                        <!-- </select>
                    </div>
                </div> -->
                <!-- <form class="form-inline"> -->
                <!-- <div class="d-flex col-sm-auto mb-2">
                    <div class="align-self-center mr-2">商品名</div>
                    <div>
                        <select class="form-control" v-model="selectedItem">
                            <option></option>
                            <option v-for="(item, index) in filterItems" :key="index" >{{item.item_name}}</option> -->
                            <!-- <option v-for="item in items" :key="item.id" :value="item.name">{{item.name}}</option> -->
                        <!-- </select>
                    </div>
                </div> -->
                <div class="d-flex col-sm-auto mb-2">
                    <div class="align-self-center mr-2">担当者</div>
                    <div>
                        <select class="form-control" v-model="selectedEmployee">
                            <option></option>
                            <option v-for="(employee, index) in filterEmployees" :key="index" :value="employee">{{employee}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <table class="table-custom" key="processes">
            <thead>
                <tr>
                    <th class="text-center bg-primary text-white" style="width:7rem;">作業日</th>
                    <th class="text-center bg-primary text-white">工程</th>
                    <th class="text-center bg-primary text-white clickable" @click="sortBy('flams')" :class="sortedClass('flams')">フラムNo</th>
                    <th class="text-center bg-primary text-white">商品名</th>
                    <th class="text-center bg-primary text-white">担当者</th>
                    <th class="text-center bg-primary text-white">段取り時間</th>
                    <th class="text-center bg-primary text-white">作業時間</th>
                    <th class="text-center bg-primary text-white">製造完了数</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="report in paginateReports" class="clickable" :class="classObject(report.status)" :key="report.id" @click="onShow(report.id)">
                    <td class="text-center">{{report.started_on}}</td>
                    <td class="text-center">
                        <div v-for="(report_detail, index) in report.report_details" :key="index">
                            {{report_detail.item_process}}
                        </div>
                    </td>
                    <td class="text-center">
                        <div v-for="(report_detail, index) in report.report_details" :key="index">
                            {{report_detail.item_flam}}
                        </div>
                    </td>
                    <td class="text-center">
                        <div v-for="(report_detail, index) in report.report_details" :key="index">
                            {{report_detail.item_name}}
                        </div>
                    </td>
                    <td class="text-center">{{report.employees}}</td>
                    <td class="text-center">
                        <div v-for="(report_detail, index) in report.report_details" :key="index">
                            {{report_detail.setup_time}}
                        </div>
                    </td>
                    <td class="text-center">
                        <div v-for="(report_detail, index) in report.report_details" :key="index">
                            {{report_detail.work_time}}
                        </div>
                    </td>
                    <td class="text-center">
                        <div v-for="(report_detail, index) in report.report_details" :key="index">
                            {{report_detail.finish_num}}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-2">
            <mg-paginate :data="filterReports" :count-per-page="countPerPage" @change="paginateReports=$event"></mg-paginate>
        </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
</div>
</div>
</template>

<script>
import moment from 'moment';
export default {
    props: [
        //
    ],
    data () {
        return {
            started_from: '',
            started_to: '',
            selectedEmployee: '',
            selectedCustomer: '',
            selectedItem: '',
            selectedProcess: '',
            selectedFinish: '',
            searchNo: '',
            reports: [],
            employees: [],
            customers: [],
            items: [],
            sort: {
                key: '', // ソートキー
                isAsc: false // 昇順ならtrue,降順ならfalse
            },

            paginateReports: [],
            countPerPage: 20,

            isLoading: false,
            fullPage: false,
        }
    },
    mounted: function () {
        // this.started_from = new moment().format('YYYY-MM-DD')
        // this.started_to = new moment().format('YYYY-MM-DD')
        this.getInit()
        this.started_from = moment().subtract(14, 'days')
        this.started_to = moment()
    },
    watch: {
        // selectedMachine: function () {
        //     this.getItems()
        // },
        // selectedCompany: function () {
        //     this.getItems()
        // },
    },
    computed: {
        own: function () {
            return this.$store.state.user
        },
        disabled: function () {
            return !this.own.is_admin
        },
        user01: function () {
            if (this.own.name == 'user01') {
                return true
            }
        },
        filterReports: function () {
            // if (this.disabled) {
            //     this.selectedFinish = '0'
            // }
            let list = this.filterSortReports.slice()
            // if (!this.selectedProcess && !this.selectedItem && !this.selectedEmployee) return list
            if (!this.searchNo && !this.selectedEmployee) return list
            // let filterWord = this.selectedCustomer
            // if (filterWord) {
            //     list = list.filter(function (row) {
            //         let find = false
            //         row.report_details.forEach( elem => {
            //             if (elem.customer_name.indexOf(filterWord) > -1) {
            //                 find = true
            //                 return false
            //             }
            //         })
            //         return find
            //     })
            // }
            let filterWord = this.selectedItem
            if (filterWord) {
                list = list.filter(function (row) {
                    let find = false

                    row.report_details.forEach( elem => {
                        // console.log(elem.item_name, filterWord, elem.item_name.indexOf(filterWord))
                        if (elem.item_name.indexOf(filterWord) > -1) {
                            find = true
                            return false
                        }
                    })
                    return find
                })
            }
            filterWord = this.selectedProcess
            if (filterWord) {
                list = list.filter(function (row) {
                    let find = false
                    row.report_details.forEach( elem => {
                        if (elem.item_process.indexOf(filterWord) > -1) {
                            find = true
                            return false
                        }
                    })
                    return find
                })
            }
            filterWord = this.selectedEmployee
            if (filterWord) {
                list = list.filter(function (row) {
                    return row.employees.indexOf(filterWord) > -1
                })
            }
            // filterWord = this.selectedFinish
            // if (filterWord) {
            //     list = list.filter(function (row) {
            //         return row.is_finished == filterWord
            //     })
            // }
            filterWord = this.searchNo
            if (filterWord) {
                list = list.filter(function (row) {
                    let find = false
                    row.report_details.forEach( elem => {
                        if (!elem.item_flam) {
                            if (elem.item_name.indexOf(filterWord) > -1) {
                                find = true
                                return false
                            }
                        } else {
                            if (elem.item_flam.indexOf(filterWord) > -1) {
                                find = true
                                return false
                            }
                        }
                    })
                    return find
                })
            }
            return list
        },
        filterSortReports: function() {
            let list = this.reports.slice()
            // ソート実施
            if (this.sort.key) {
                list.sort((a, b) => {
                    a = a[this.sort.key]
                    b = b[this.sort.key]
                    return (a === b ? 0 : a > b ? 1 : -1) * (this.sort.isAsc ? 1 : -1);
                })
            }
            return list
        },
        classObject: function () {
            return function (status) {
                if (status == 0) return 'todo-color'
                if (status == 1) return 'doing-color'
                if (status == 2) return 'done-color'
            }
        },
        // filteredItems: function () {
        //     let list = this.reports.slice()
        //     let selectItemList = []
        //     list.forEach( function( v1 ) {
	    //         v1.report_details.forEach( function( v2 ) {
        //             if (selectItemList.indexOf(v2.item_name) == -1){
        //                 selectItemList.push(v2.item_name);
        //             }
	    //         });
        //     });
        //     selectItemList.sort()
        //     return selectItemList
        // },
        filterProcesses: function () {
            let list = this.reports.slice()
            let selectItemList = []
            list.forEach( function( v1 ) {
	            v1.report_details.forEach( function( v2 ) {
                    if (selectItemList.indexOf(v2.item_process) == -1){
                        selectItemList.push(v2.item_process);
                    }
	            });
            });
            selectItemList.sort()
            // return selectItemList
            // 重複削除
            var result = selectItemList.filter(function(v1,i1,a1){
                return (a1.findIndex(function(v2){
                    return (v1===v2)
                }) === i1);
            });

            return result
        },
        filterItems: function () {
            let list = this.reports.slice()
            // console.log(list)
            let selectItemList = []
            list.forEach( function( v1 ) {
	            v1.report_details.forEach( function( v2 ) {
                    // console.log(v2)
                    if (selectItemList.indexOf(v2) === -1){
                        selectItemList.push(v2);
                    }
	            });
            });
            // console.log(selectItemList)
            selectItemList.sort()
            // console.log(selectItemList)
             // 重複削除
            selectItemList = selectItemList.filter(function(v1,i1,a1){
                return (a1.findIndex(function(v2){
                    return (v1.item_name===v2.item_name)
                }) === i1);
            });
            // console.log(selectItemList)
            let _this = this
            if (_this.selectedProcess) {
                console.log(selectItemList.filter( elem => elem.item_process == _this.selectedProcess))
                return selectItemList.filter( elem => elem.item_process === _this.selectedProcess)
                return []
            } else {
                return
            }
        },
        filterEmployees: function () {
            let list = this.reports.slice()
            let selectItemList = []
            list.forEach( function( v1 ) {
	            v1.report_employees.forEach( function( v2 ) {
                    if (selectItemList.indexOf(v2.full_name) == -1){
                        selectItemList.push(v2.full_name);
                    }
	            });
            });
            selectItemList.sort()
           // 重複削除
            var result = selectItemList.filter(function(v1,i1,a1){
                return (a1.findIndex(function(v2){
                    return (v1===v2)
                }) === i1);
            });
            return result
        },
    },
    methods: {
        getInit: function () {
            this.isLoading = true;
            const api = axios.create()
            axios.all([
                api.get('/api/employee/selector'),
                api.get('/api/customer/selector'),
                api.get('/api/item/selector'),
            ]).then(axios.spread((res1, res2, res3, res4) => {
                this.employees = res1.data
                this.customers = res2.data
                this.items = res3.data
                // if (this.own.agent_id) this.searchAgent = this.own.agent_id
                this.isLoading = false
                // this.getItems()
            }))
        },
        getItems: function () {
            this.isLoading = true
            const api = axios.create()
            axios.all([
                api.get('/api/report', {
                    params: {
                        started_on: this.started_from,
                        finished_on: this.started_to,
                        is_admin : this.own.is_admin,
                        // customer_id: this.selectedCustomer,
                        // item_id: this.selectedItem,
                    }
                }),
            ]).then(axios.spread((res1, res2, res3, res4) => {
                this.reports = res1.data
                this.isLoading = false
            }))
        },
        onCreate: function () {
            this.$router.push({ name: 'report.create' })
        },
        onShow: function (report_id) {
            this.$router.push({ name: 'report.show', params: {'report_id': report_id} })
        },
        onBack: function () {
            this.$router.push({ name: 'home' })
        },
        onSearch: function () {
            this.getItems()
        },
        showCustomers: function(details) {
            var text = ''
            for(let i = 0; i < details.length; i++) {
                text = text + details[i].customer + "\n"
            }
            return text
        },
        showItems: function(details) {
            var text = ''
            for(let i = 0; i < details.length; i++) {
                text = text + details[i].item + " " + details[i].status + "\n"
            }
            return text
        },
        showEmployees: function(employees) {
            var text = ''
            for(let i = 0; i < employees.length; i++) {
                text = text + employees[i].full_name + "\n"
            }
            return text
        },
        downloadCSV: function () {
            var csv = '\ufeff' + '作業開始日,作業終了日,担当者,工程,FlamNo,商品名,機械,設備,段取り時間,作業時間,製造完了数'
            csv += '\n'
            this.reports.forEach(el => {
                el.report_details.forEach(detail => {
                    var line = '"' + el.started_on + '",'
                    line += '"' + el.finished_on + '",'
                    line += '"' + el.employees + '",'
                    line += '"' + detail.item_process + '",'
                    line += '"' + detail.item_flam + '",'
                    line += '"' + detail.item_name + '",'
                    line += '"' + detail.category_name + '",'
                    line += '"' + detail.facility_name + '",'
                    line += '"' + detail.setup_time + '",'
                    line += '"' + detail.work_time + '",'
                    line += '"' + detail.finish_num + '",'
                    line += '\n'
                    csv += line
                })
            })
            let blob = new Blob([csv], { type: 'text/csv' })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'download.csv'
            link.click()
        },
        sortBy: function(key) {
            this.sort.isAsc = this.sort.key === key ? !this.sort.isAsc : false
            this.sort.key = key
        },
        sortedClass: function(key) {
            return this.sort.key === key ? `sorted ${ this.sort.isAsc ? 'asc' : 'desc' }` : ''
        },
    },
}
</script>

<style lang="scss" scoped>
@import "resources/sass/variables";
.clickable:hover {
    background-color: #fff8e1 !important;
}
.clickable {
    cursor: pointer;
}
.todo-color {
    background-color: #ffcdd2 !important;
}
.doing-color {
    background-color: #b2dfdb !important;
}
.done-color {
    background-color: #ffffff !important;
}
</style>

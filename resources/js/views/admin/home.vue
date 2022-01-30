<template>
    <div class="col-lg-12 admin-body-wrap">
        <div class="ibox ">
            <div class="ibox-title">
                <h3 class="text-info">All Customer Details
                    <span class="card-subtitle"
                          v-if="customer_details">Count: {{ customer_details.total }}</span>
                    <span class="card-subtitle" v-else>No Results Found</span>
                    <button class="btn btn-info btn-sm btn-right" v-if="!showFilterPanel"
                            @click="showFilterPanel = !showFilterPanel"><i class="fas fa-filter"></i> <span
                        class="d-none d-sm-inline">Filter</span></button>
                    <button class="btn btn-info btn-sm btn-right"
                            @click="filter.trashed = !filter.trashed"><i class="fas fa-filter"></i> <span
                        class="d-none d-sm-inline">{{
                            filter.trashed ? 'Get Undeleted Data' : 'Get Deleted Data'
                        }}</span></button>
                </h3>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-12">
                        <transition name="fade">
                            <div class="card border-bottom" v-if="showFilterPanel">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-6 col-sm-3">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input class="form-control" name="name"
                                                       v-model="filter.name">
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <div class="form-group">
                                                <label for="">Phone</label>
                                                <input class="form-control" name="phone"
                                                       v-model="filter.phone">
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input class="form-control" name="email"
                                                       v-model="filter.email">
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <input class="form-control" name="address"
                                                       v-model="filter.address">
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <div class="form-group">
                                                <label for="nationality">Nationality</label>
                                                <input class="form-control" name="nationality"
                                                       v-model="filter.nationality">
                                            </div>
                                        </div>
                                        <div class="col-4 col-sm-6">
                                            <div class="form-group">
                                                <date-range-picker
                                                    :start-date.sync="filter.created_at_start_date"
                                                    :end-date.sync="filter.created_at_end_date"
                                                    :label="'Created At'"></date-range-picker>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger btn-sm pull-right" v-if="showFilterPanel"
                                            @click="showFilterPanel = !showFilterPanel">Cancel
                                    </button>
                                </div>
                            </div>
                        </transition>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" v-if="customer_details.total">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <td>
                                                <input type="checkbox" @click="selectAll" v-model="all_select">
                                                <span> {{ all_select ? 'Un select All' : "Select All" }} </span>
                                            </td>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Nationality</th>
                                            <th>Address</th>
                                            <th>Preferred Contact Mode</th>
                                            <th>Date of birth</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th class="table-option">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(customer, index) in customer_details.data" :key=index>
                                            <td><input type="checkbox" v-model="deleteableGuids"
                                                       :value="`${customer.guid}`"></td>
                                            <td v-text="customer.name"></td>
                                            <td v-text="customer.phone"></td>
                                            <td v-text="customer.email"></td>
                                            <td v-text="customer.nationality"></td>
                                            <td v-text="customer.address"></td>
                                            <td v-text="customer.preferred_contact_mode"></td>
                                            <td v-text="customer.date_of_birth"></td>
                                            <td>{{ customer.created_at | momentDate }}</td>
                                            <td>{{ customer.updated_at | momentDate }}</td>
                                            <td class="table-option">
                                                <div class="btn-group" v-if="filter.trashed === false">
                                                    <router-link tag="v-btn"
                                                                 :to="`/admin/customer-details/review/${customer.guid}`"
                                                                 class="btn btn-info btn-sm"><span>View</span>
                                                    </router-link>
                                                </div>

                                                <div class="btn-group" v-if="filter.trashed === false">
                                                    <v-btn color="red" @click="deleteCustomerDetail(customer.guid)">
                                                        Delete
                                                    </v-btn>
                                                </div>
                                                <div class="btn-group" v-else>
                                                    <v-btn color="red" @click="restoreCustomerDetails(customer.guid)">
                                                        Restore
                                                    </v-btn>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <pagination-record :page-length.sync="filter.page_length"
                                                   :records="customer_details"
                                                   @updateRecords="getCustomerDetails"></pagination-record>
                                <div class="float-start" v-if="customer_details.total">
                                    <v-btn color="red" @click="deleteAll" v-if="filter.trashed === false">
                                        Delete all selected rows
                                    </v-btn>
                                    <v-btn color="blue" @click="restoreAll" v-else>
                                        Restore all selected rows
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import dateRangePicker from '../../components/date-range-picker'

export default {
    components: {
        dateRangePicker
    },
    data() {
        return {
            showFilterPanel: false,
            all_select: false,
            deleteableGuids: [],
            customer_details: {
                total: 0,
                data: []
            },
            filter: {
                name: '',
                phone: '',
                email: '',
                address: '',
                nationality: '',
                created_at_start_date: '',
                created_at_end_date: '',
                sort_by: 'created_at',
                order: 'desc',
                page_length: '15',
                trashed: false,
            }
        }
    },
    mounted() {
        this.getCustomerDetails()
    },
    methods: {
        getCustomerDetails(page) {
            if (typeof page !== 'number') {
                page = 1;
            }
            let url = helper.getFilterURL(this.filter);
            axios.get(`/api/admin/customer-details/get?page=` + page + url)
                .then((response) => {
                    this.customer_details = response.data;
                })
                .catch((error) => {
                    helper.showErrorMsg(error);
                })
        },
        selectAll() {
            if (!this.all_select) {
                this.customer_details.data.forEach(customer => {
                    console.log(customer);
                    this.deleteableGuids.push(customer.guid)
                });
            } else {
                this.deleteableGuids = []
            }
        },
        deleteCustomerDetail(guid) {
            axios.delete(`/api/admin/customer-detail/delete/${guid}`)
                .then((response) => {
                    toastr.success(response.data.message);
                    this.getCustomerDetails();
                }).catch((error) => {
                helper.showErrorMsg(error);
            })
        },
        deleteAll() {
            if (this.deleteableGuids.length < 1) {
                toastr.error('Please select rows');
            } else {
                let guids = {
                    'guids': this.deleteableGuids
                };
                axios.post('/api/admin/customer-detail/delete/bulk', guids)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.getCustomerDetails();
                        this.all_select = false;
                        this.deleteableGuids = null;
                    }).catch((error) => {
                    helper.showErrorMsg(error);
                })
            }
        },
        restoreCustomerDetails(guid) {
            axios.get(`/api/admin/customer-detail/restore/${guid}`)
                .then((response) => {
                    toastr.success(response.data.message);
                    this.getCustomerDetails();
                    this.filter.trashed = true;
                }).catch((error) => {
                helper.showErrorMsg(error);
            })
        },
        restoreAll() {
            if (this.deleteableGuids.length < 1) {
                toastr.error('Please select rows');
            } else {
                let guids = {
                    'guids': this.deleteableGuids
                };
                axios.post('/api/admin/customer-detail/restore/bulk', guids)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.getCustomerDetails();
                        this.deleteableGuids = null;
                        this.all_select = false;
                        this.filter.trashed = true;
                    }).catch((error) => {
                    helper.showErrorMsg(error);
                })
            }
        },

    },
    watch: {
        filter: {
            handler(val) {
                this.getCustomerDetails();
            },
            deep: true
        }
    },
    filters: {
        momentDate(date) {
            return helper.formatDate(date);
        }
    }

}
</script>


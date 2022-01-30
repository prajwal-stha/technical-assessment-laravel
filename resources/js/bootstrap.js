import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import helper from './services/helper'
import paginationRecord from './components/PaginateRecords'
import './validation/index';
import DatePicker from "vue2-datepicker";
import 'vue2-datepicker/index.css';
window.Vue = Vue;

Vue.use(VueRouter);

window.axios = axios;
window.helper = helper;

Vue.component('pagination-record', paginationRecord);
Vue.component('DatePicker', DatePicker);

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {
}

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

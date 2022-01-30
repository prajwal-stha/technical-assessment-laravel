import store from '../store'
import router from '../routes'
import $ from "lodash/core";

export default {
    // to logout user
    logout() {
        return axios.post('/api/auth/logout').then(response => response.data).then(response => {
            toastr.success(response.message);
        }).catch(error => {
            this.showErrorMsg(error);
        });
    },

    // to check for authenticated user
    check() {
        return axios.post('/api/auth/check').then(response => response.data).then(response => {
            if (response.authenticated) {
                store.dispatch('setAuthUserDetail', {
                    id: response.user.id,
                    name: response.user.name,
                    email: response.user.email,
                });
            } else {
                store.dispatch('resetAuthUserDetail');
            }

            return response.authenticated;
        }).catch(error => {
            store.dispatch('resetAuthUserDetail');
        });

    },

    // to get Auth Status
    isAuth() {
        return store.getters.getAuthStatus;
    },

    // to get Auth user detail
    getAuthUser(name) {
        return store.getters.getAuthUser('name');
    },
    // shows toastr notification for axios form request
    showErrorMsg(error) {
        console.log(error)
        if (error.hasOwnProperty("error")) {
            toastr.error(error.error);
            if (error.error === 'token_expired') {
                toastr.error('Session Expired. Please login again.');
                router.push('/login');
            } else {
                toastr.error(error.error);
            }
        } else if (error.hasOwnProperty("response")) {
            if (error.response.status === 401) {
                console.log('here')
                toastr.error('Unauthorized')
            } else if (error.response.status === 422) {
                if (error.response.data.hasOwnProperty('errors')) {
                    if (error.response.data.errors.hasOwnProperty("message")) {
                        toastr.error(error.response.data.errors.message[0]);
                    } else {
                        $.each(error.response.data.errors, function (key, value) {
                            toastr.error(value);
                        });
                    }
                }
                if (error.response.data.hasOwnProperty('message')) {
                    toastr.error(error.response.data.message);
                } else if (error.response.data.hasOwnProperty('error')) {
                    toastr.error(error.response.data.error);
                }
            } else if (error.response.status === 404) {
                toastr.error("Invalid link.");
            }
        }
    },
    getFilterURL(data) {
        let url = '';
        $.each(data, function (key, value) {
            url += (value) ? '&' + value + '=' + encodeURI(key) : '';
        });
        return url;
    },

    formatDate(date) {
        if (!date)
            return;

        return moment(date).format('YYYY-MM-DD, hh:mm A');
    },
}

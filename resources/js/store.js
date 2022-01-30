import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        auth: {                 // to store auth user data
            id: '',
            name: '',
            email: ''
        },
        is_auth: false,         // to store auth status
    },
    mutations: {
        setAuthStatus (state) {
            state.is_auth = true;
        },
        setAuthUserDetail (state, auth) {
            for (let key of Object.keys(auth)) {
                state.auth[key] = auth[key] !== null ? auth[key] : '';
            }
            state.is_auth = true;
        },
        resetAuthUserDetail (state) {
            for (let key of Object.keys(state.auth)) {
                state.auth[key] = '';
            }
            state.is_auth = false;
            localStorage.removeItem('auth_token');
            axios.defaults.headers.common['Authorization'] = null;
        },
    },
    actions: {
        setAuthStatus ({ commit }) {
            commit('setAuthStatus');
        },
        setAuthUserDetail ({ commit }, auth) {
            commit('setAuthUserDetail',auth);
        },
        resetAuthUserDetail ({commit}){
            commit('resetAuthUserDetail');
        },
    },
    getters: {
        getAuthUser: (state) => (name) => {
            return state.auth[name];
        },
        getAuthStatus: (state) => {
            return state.is_auth;
        },
    },
    plugins: [
        createPersistedState({ storage: window.sessionStorage })
    ]
});

export default store;

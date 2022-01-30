<template>
    <header class="pt-5">
        <div class="row" v-if="authenticated">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Welcome {{ getAuthUser('name') }}
                    </h1>
                    <v-btn @click="logout" color="primary" class="btn login-btn btn-md float-end">
                        Logout
                    </v-btn>
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Welcome</h1>
                    <router-link to="/login" tag="v-btn" color="secondary" class="btn btn-md login-btn float-end">
                        Login
                    </router-link>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: 'Nav',
    data() {
        return {
            authenticated: false,
        }
    },
    mounted() {
        this.isAuthenticated();
    },
    methods: {
        logout() {
            helper.logout().then(() => {
                this.$store.dispatch('resetAuthUserDetail');
                this.$router.push('/')
            })
        },
        getAuthUser(name) {
            return helper.getAuthUser(name);
        },
        isAuthenticated() {
            return this.authenticated = helper.isAuth();
        }
    }
}
</script>

<style scoped>
.login-btn {
    margin-top: -51px;
}
</style>

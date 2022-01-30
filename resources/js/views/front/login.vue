<template>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login-body-wrap">
                    <div class="login100-form validate-form">
                        <span class="login100-form-title">Login</span>
                        <p class="sub-title">Login in. To see it in action.</p>
                        <form
                            class="form-horizontal form-material"
                            role="form"
                            id="loginform"
                            @submit.prevent="submit"
                        >
                            <div class="form-group">
                                <v-text-field height="45px" type="email" v-model="loginForm.email" outlined
                                              label="Email"
                                              prepend-inner-icon="mdi-email"></v-text-field>
                            </div>
                            <div class="form-group">
                                <v-text-field
                                    height="45px"
                                    v-model="loginForm.password"
                                    :append-icon="show1 ? 'fa-eye' : 'fa-eye-slash'"
                                    :type="show1 ? 'text' : 'password'"
                                    name="input-10-1"
                                    label="Password"
                                    hint="At least 8 characters"
                                    counter
                                    outlined
                                    @click:append="show1 = !show1"
                                ></v-text-field>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="container-login100-form-btn">
                                    <v-btn class="btn btn-md" :class="{'loading': isLoading}" type="submit">
                                        Login
                                    </v-btn>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="container-login100-form-btn">
                                    <v-btn @click="goHome">Home</v-btn>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            isLoading: '',
            show1: false,
            dialog: true,
            loginForm: {
                username: '',
                password: ''
            },
        }
    },
    methods: {
        submit() {
            this.isLoading = true;
            axios.post('/api/auth/login', this.loginForm)
                .then(response => {
                    localStorage.setItem('auth_token', response.data.access_token);
                    localStorage.setItem('user_data', JSON.stringify(response.data.user));
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
                    this.$store.dispatch('setAuthStatus');
                    toastr.success(response.data.message);
                    this.$router.push('/admin/home');
                    this.isLoading = false;
                }).catch(error => {
                helper.showErrorMsg(error);
                this.isLoading = false;
            });
        },
        goHome() {
            this.$router.push('/');
        }
    }
}
</script>

<style lang="scss">
.limiter {
    width: 100%;
    margin: 0 auto;
}

.container-login100 {
    width: 100%;
    min-height: 100vh;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background: #e53135;
    background: linear-gradient(-135deg, #e5313552, #e53135);
    position: relative;
}

.wrap-login100 {
    width: 350px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    position: relative;
    z-index: 9;
    padding: 30px;
    box-shadow: 0 2.8px 2.2px rgba(212, 0, 0, 0.034),
    0 6.7px 5.3px rgba(212, 0, 0, 0.048), 0 12.5px 10px rgba(212, 0, 0, 0.06),
    0 22.3px 17.9px rgba(212, 0, 0, 0.072),
    0 41.8px 33.4px rgba(212, 0, 0, 0.086), 0 100px 80px rgba(212, 0, 0, 0.12);
}

.login100-form-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: rgba(0, 0, 0, 0.8);
    line-height: 1.2;
    text-align: center;
    width: 100%;
    display: block;
    padding-bottom: 5px;
    padding-top: 16px;
}

.wrap-login100 .p-t-136 {
    padding-top: 45px;
}

.wrap-login100 .login-body-wrap {
    width: 100%;
    text-align: center;
}

.container-login100-form-btn .button {
    width: 200px;
    height: 40px;
    margin: 0 0 1rem;
}

.container-login100 {
    .txt1 {
        margin-right: 5px;
    }

    .create-account {
        display: inline-block;
        cursor: pointer;

        .mdi {
            font-size: 1rem;
        }
    }

    .login100-pic {
        img {
            width: 120px;
        }
    }
}

.container-login100 {
    .content-overlay {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0.1;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
}

.login100-form {
    .sub-title {
        margin-bottom: 2rem;
    }
}

.container-login100 .form-group {
    margin-bottom: 1.4rem;
}

.logo-wrapper .logo-top img {
    position: absolute;
    top: 0;
    left: 28%;
    width: 42px;
}

.logo-wrapper .logo-btm img {
    position: absolute;
    bottom: 0;
    left: 0;
}

.login100-pic {
    display: inline-block;
    position: relative;
}

.login100-pic .main-logo {
    opacity: 0;
}

.login100-pic.loading .logo-wrapper .logo-top img {
    -webkit-animation: rotation 2s infinite linear;
}

@-webkit-keyframes rotation {
    from {
        -webkit-transform: rotate(0deg);
    }
    to {
        -webkit-transform: rotate(359deg);
    }
}

span.btn-icon {
    position: absolute;
    right: 10px;
    width: 28px;
    opacity: 0;
}

.loading span.btn-icon {
    opacity: 1;
    -webkit-animation: rotation 2s infinite linear;
}
</style>

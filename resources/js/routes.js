import VueRouter from 'vue-router'
import store from './store'


let routes = [
    {
        path: '/',
        component: require('./layouts/home-page').default,
        children: [
            {
                path: '/',
                component: require('./views/front/home').default
            }
        ]
    },
    {
        path: '/login',
        component: require('./views/front/login').default,
    },
    {
        path: '/', // all the routes which needs authentication + two factor authentication + lock screen
        component: require('./layouts/admin-page').default,
        meta: {
            validate: ['auth']
        },
        children: [
            {
                path: '/admin/home',
                component: require('./views/admin/home').default
            },
            {
                path: '/admin/customer-details/review/:id',
                component: require('./views/admin/reviewCustomerDetails').default
            }
        ]
    },
];
const router = new VueRouter({
    mode: 'history',
    routes,
    // linkActiveClass: 'active',
    // scrollBehavior(to, from, savedPosition) {
    //     if (savedPosition) {
    //         return savedPosition
    //     } else {
    //         return {x: 0, y: 0}
    //     }
    // }
});

router.beforeEach((to, from, next) => {
    if (_.words(to.path)[0] === 'admin') {
        helper.check()
            .then(response => {
                if (to.matched.some(m => m.meta.validate)) {
                    const m = to.matched.find(m => m.meta.validate);
                    // Check for authentication; If no, redirect to "/login" route
                    if (m.meta.validate.indexOf('auth') > -1) {
                        if (!helper.isAuth()) {
                            toastr.error('Authorization is required to perform this action');
                            return next({
                                path: '/login'
                            })
                        }
                    }
                }

                return next()
            })
            .catch(error => {
                // Authentication check fail, redirected back to "/login" route
                store.dispatch('resetAuthUserDetail');
                return next({
                    path: '/login'
                })
            });
    } else {
        return next()
    }
});


export default router;


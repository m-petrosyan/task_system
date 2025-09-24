import {createRouter, createWebHistory} from 'vue-router'

import ClientLayouth from "@/layouts/ClientLayouth.vue";
import AdminLayouth from "@/layouts/AdminLayouth.vue";
import Login from "@/pages/auth/Login.vue";
import NotFound404 from "@/pages/NotFound404.vue";
import Dashboard from "@/pages/dashboard/Dashboard.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: ClientLayouth,
            children: [
                {
                    path: '',
                    name: 'login',
                    component: Login
                },
            ],
        },
        {
            path: '/',
            component: AdminLayouth,
            children: [
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: Dashboard,
                    meta: {requiresAuth: true},
                    children: [
                        {
                            path: 'tasks',
                            children: [
                                {
                                    path: 'create',
                                    name: 'tasks-create',
                                    component: Dashboard,
                                },
                                {
                                    path: ':id/edit',
                                    name: 'tasks-edit',
                                    component: Dashboard,
                                },
                                {
                                    path: ':id',
                                    name: 'tasks-show',
                                    component: Dashboard,
                                },
                            ]
                        },
                        {
                            path: 'notifications',
                            name: 'notifications',
                            component: Dashboard,
                        },
                        {
                            path: 'users',
                            name: 'users',
                            component: Dashboard,
                        },
                    ]
                },
            ]
        },
        {
            path: '/:pathMatch(.*)*',
            name: '404',
            component: NotFound404
        },
    ],
    scrollBehavior() {
        return {top: 0}
    },
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta?.requiresAuth)) {
        if (!localStorage.getItem('access_token')) {
            next({
                name: 'login',
                query: {redirect: to.fullPath}
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router;

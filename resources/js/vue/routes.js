import { createRouter, createWebHistory } from 'vue-router';

import Login from './views/auth/Login.vue';
import Register from './views/auth/Register.vue';

import Equipments from './views/Equipments.vue';
import EquipmentTypes from './views/EquipmentTypes.vue';

import EquipmentTypeAdd from './views/EquipmentTypeAdd.vue';
import EquipmentsAdd from './views/EquipmentsAdd.vue';

import EquipmentsEdit from './views/EquipmentsEdit.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        redirect: {
            name: 'equipments'
        }
    },
    {
        path: '/equipments',
        name: 'equipments',
        meta: {
            auth: true
        },
        component: Equipments
    },
    {
        path: '/equipment-types',
        name: 'equipment_types',
        meta: {
            auth: true
        },
        component: EquipmentTypes,
    },
    {
        path: '/equipment-types/add',
        name: 'equipment_types_add',
        meta: {
            auth: true
        },
        component: EquipmentTypeAdd
    },
    {
        path: '/equipments/add',
        name: 'equipments_add',
        meta: {
            auth: true
        },
        component: EquipmentsAdd
    },
    {
        path: '/equipments/:id',
        name: 'equipments_edit',
        meta: {
            auth: true
        },
        component: EquipmentsEdit
    },
    {
        path: '/login',
        name: 'login',
        meta: {
            guest: true,
            layout: 'auth'
        },
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        meta: {
            guest: true,
            layout: 'auth'
        },
        component: Register
    }
];

const router = createRouter({
    history: createWebHistory(),
    base: process.env.BASE_URL,
    routes,
    strict: true
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user')

    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        if (to.path === '/login') {
            next()
            return
        }
        next({
            name: 'login'
        })
        return
    } else if (to.matched.some(record => record.meta.guest) && loggedIn) {
        next({
            name: 'home'
        })
        return
    }
    next()
})

export default router;
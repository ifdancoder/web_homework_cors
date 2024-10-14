import { createStore } from 'vuex'
import { useRoute } from 'vue-router'
import apiClient from '../api';

const store = createStore({
    state: {
        user: null,
        flashMessages: [],
    },
    mutations: {
        setUserData(state, userData) {
            state.user = userData
            localStorage.setItem('user', JSON.stringify(userData))
            apiClient.defaults.headers.common.Authorization = `Bearer ${userData.token}`
        },

        clearUserData() {
            localStorage.removeItem('user');
        },

        addFlashMessage(state, message) {
            if (typeof message === 'string') {
                message = {
                    type: 'warning',
                    message: message
                }
            }
            state.flashMessages.push(message)
            setTimeout(() => {
                state.flashMessages.shift();
            }, 10000);
        },

        clearFlashMessages(state) {
            state.flashMessages = [];
        }
    },

    actions: {
        login({ commit }, data) {
            return apiClient.post('/login',
                data.credentials,
            ).then(({ data }) => {
                commit('setUserData', data)
            }).catch(err => {
                if ('response' in err && 'data' in err.response) {
                    throw err.response.data;
                }
                throw err;
            })
        },

        register({ commit }, data) {
            return apiClient.post('/register',
                data.credentials
            ).then(({ data }) => {
                commit('setUserData', data)
            }).catch(err => {
                if ('response' in err && 'data' in err.response) {
                    throw err.response.data;
                }
                throw err;
            })
        },

        logout({ commit }) {
            this.errors = {};
            commit('clearUserData');
        },

        addFlashMessage({ commit }, message) {
            commit('addFlashMessage', message);
        },

        clearFlashMessages({ commit }) {
            commit('clearFlashMessages');
        }
    },
    getters: {
        isLogged: state => !!state.user,
        getUserData: state => state.user?.user ?? null,
        getFlashMessages: state => state.flashMessages
    },
})

apiClient.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            if (store.getters.getUserData) {
                store.dispatch('addFlashMessage', 'Ваша сессия истекла, пожалуйста, войдите снова.');
            }
            store.dispatch('logout');
        }
        return Promise.reject(error);
    }
);

export default store;
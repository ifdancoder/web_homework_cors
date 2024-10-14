<template>
    <div id="app">
        <div class="page">
            <AuthLayout v-if="this.$route.meta.layout">
                <router-view />
            </AuthLayout>
            <MainLayout v-else>
                <router-view />
            </MainLayout>
        </div>
    </div>
</template>

<script>
import MainLayout from './views/layouts/MainLayout.vue';
import AuthLayout from './views/layouts/AuthLayout.vue';

export default {
    name: 'App',
    components: {
        MainLayout,
        AuthLayout,
    },
    created() {
        const userInfo = localStorage.getItem('user')
        if (userInfo) {
            const userData = JSON.parse(userInfo)
            this.$store.commit('setUserData', userData)
        }
    }
};
</script>
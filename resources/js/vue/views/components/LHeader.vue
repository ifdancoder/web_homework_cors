<template>
    <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
        <div class="container-xl justify-content-end">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav flex-row order-md-last">
                <div class="d-none d-md-flex">
                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" aria-label="Включить темный режим"
                        data-bs-original-title="Включить темный режим">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z">
                            </path>
                        </svg>
                    </a>
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" aria-label="Включить светлый режим"
                        data-bs-original-title="Включить светлый режим">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                        aria-label="Open user menu">
                        <div class="d-none d-xl-block ps-2" v-if="getUserData">
                            <div>{{ getUserData.last_name }} {{ getUserData.first_name }}</div>
                            <div class="mt-1 small text-secondary">{{ getUserData.email }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <form method="POST" action="">
                            <button type="button" @click="logout" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-door-exit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 12v.01" />
                                    <path d="M3 21h18" />
                                    <path d="M5 21v-16a2 2 0 0 1 2 -2h7.5m2.5 10.5v7.5" />
                                    <path d="M14 7h7m-3 -3l3 3l-3 3" />
                                </svg>
                                &nbspВыйти
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'LHeader',
    methods: {
        logout() {
            this.errors = {};
            this.$store.dispatch(
                'logout')
                .then((response) => {
                    console.log('Succeed with: ', response);

                    let flash = {
                        type: 'success',
                        message: 'Вы успешно вышли из системы'
                    }
                    this.$store.dispatch(
                        'addFlashMessage',
                        flash
                    );

                    this.$router.push({ name: 'login' });
                })
                .catch(err => {
                    if (typeof err === 'string') {
                        this.$store.dispatch(
                            'addFlashMessage',
                            err
                        );
                    } else if ('errors' in err) {
                        this.errors = err.errors;
                    } else if ('message' in err) {
                        this.$store.dispatch(
                            'addFlashMessage',
                            err.message
                        );
                    }
                });
        }
    },
    computed: {
        ...mapGetters(['getUserData'])
    }
};
</script>
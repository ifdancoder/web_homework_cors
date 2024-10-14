<template>
    <form class="mt-0" method="POST" action="" autocomplete="on" novalidate>
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Войдите</h2>
            <div class="mb-2">
                <label class="form-label">Электронная почта</label>
                <input type="email" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="form.email"
                    placeholder="your_email@gmail.com" autocomplete="off" name="email">
                <span v-if="errors.email" class="invalid-feedback" role="alert">
                    <strong>
                        {{ errors.email.join('. ') }}
                    </strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Пароль
                </label>
                <input type="password" class="form-control" :class="{ 'is-invalid': errors.password }"
                    v-model="form.password" name="password" autocomplete="current-password"
                    placeholder="Введите пароль">
                <span v-if="errors.password" class="invalid-feedback" role="alert">
                    <strong>
                        {{ errors.password.join('. ') }}
                    </strong>
                </span>
            </div>
            <div class="mb-3">
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" :class="{ 'is-invalid': errors.remember_me }"
                        v-model="form.remember_me" name="remember_me" id="remember_me" />
                    <span class="form-check-label">Запомнить на этом устройстве</span>
                    <span v-if="errors.remember_me" class="invalid-feedback" role="alert">
                        <strong>
                            {{ errors.remember_me.join('. ') }}
                        </strong>
                    </span>
                </label>
            </div>
            <Flash class="mb-3" />
            <div class="mb-1">
                <button type="button" @click="login" class="btn btn-outline-primary w-100">Войти</button>
            </div>
        </div>
    </form>
    <div class="mb-3 d-flex justify-content-center">
        <div class="d-flex align-items-center">
            <div class="text-center text-muted">
                Еще нет аккаунта?
            </div>
            <router-link class="ml-2" :to="{ name: 'register' }">&nbspЗарегистрироваться</router-link>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import Flash from '../components/Flash.vue';

export default {
    name: 'Login',
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember_me: false
            },
            errors: {
            }
        }
    },
    components: {
        Flash
    },
    methods: {
        login() {
            this.errors = {};
            
            this.$store.dispatch(
                'login',
                {
                    credentials: this.form
                })
                .then((response) => {
                    console.log('Succeed with: ', response);

                    let flash = {
                        type: 'success',
                        message: 'Вы успешно вошли в систему'
                    }
                    this.$store.dispatch(
                        'addFlashMessage',
                        flash
                    );

                    this.$router.push({ name: 'home' });
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
    }
}

const email = ref('');
const password = ref('');

const login = () => {
    console.log('Login with', email.value, password.value);
};
</script>
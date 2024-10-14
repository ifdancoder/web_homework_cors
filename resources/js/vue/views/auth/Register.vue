<template>
    <form class="mt-0" @submit.prevent="registerUser">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Зарегистрироваться</h2>
            <div class="mb-3 row">
                <div class="col-6">
                    <label class="form-label">Имя</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.first_name }"
                        v-model="form.first_name" placeholder="Иван" autocomplete="off" name="first_name">
                    <span v-if="errors.first_name" class="invalid-feedback" role="alert">
                        <strong>
                            {{ errors.first_name.join('. ') }}
                        </strong>
                    </span>
                </div>
                <div class="col-6">
                    <label class="form-label">Фамилия</label>
                    <input type="text" class="form-control" :class="{ 'is-invalid': errors.last_name }"
                        v-model="form.last_name" placeholder="Иванов" autocomplete="off" name="last_name">
                    <span v-if="errors.last_name" class="invalid-feedback" role="alert">
                        <strong>
                            {{ errors.last_name.join('. ') }}
                        </strong>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Электронная почта</label>
                <input type="text" class="form-control" :class="{ 'is-invalid': errors.email }" v-model="form.email"
                    placeholder="your_email@gmail.com" autocomplete="off" name="email">
                <span v-if="errors.email" class="invalid-feedback" role="alert">
                    <strong>
                        {{ errors.email.join('. ') }}
                    </strong>
                </span>
            </div>
            <div class="mb-3 row">
                <div class="col-6">
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
                <div class="col-6">
                    <label class="form-label">
                        Повторите пароль
                    </label>
                    <input type="password" class="form-control" :class="{ 'is-invalid': errors.password_confirmation }"
                        v-model="form.password_confirmation" name="password_confirmation"
                        autocomplete="current-password" placeholder="Повторите пароль">
                    <span v-if="errors.password_confirmation" class="invalid-feedback" role="alert">
                        <strong>
                            {{ errors.password_confirmation.join('. ') }}
                        </strong>
                    </span>
                </div>
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
                <button type="submit" class="btn btn-outline-primary w-100">Зарегистрироваться</button>
            </div>
        </div>
    </form>
    <div class="mb-3 d-flex justify-content-center">
        <div class="d-flex align-items-center">
            <div class="text-center text-muted">
                Уже есть аккаунт?
            </div>
            <router-link class="ml-2" :to="{ name: 'login' }">&nbspВойти</router-link>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import apiClient from '../../api';
import Flash from '../components/Flash.vue';

const register = () => {
    console.log('Register with', email.value, password.value);
};

export default {
    name: 'Register',
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                remember_me: false
            },
            errors: {}
        };
    },
    components: {
        Flash
    },
    methods: {
        async registerUser() {
            this.errors = {};

            this.$store.dispatch(
                'register',
                {
                    credentials: this.form
                })
                .then((response) => {
                    console.log('Succeed with: ', response);

                    let flash = {
                        type: 'success',
                        message: 'Вы успешно зарегистрировались и вошли в систему'
                    }
                    this.$store.dispatch(
                        'addFlashMessage',
                        flash
                    );

                    this.$router.push({ name: 'home' });
                })
                .catch(err => {
                    console.log(err);
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
</script>
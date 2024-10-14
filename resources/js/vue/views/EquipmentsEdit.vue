<template>
    <div class="m-3">
        <div class="card">
            <form @submit.prevent="saveEquipment">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Редактирование параметров оборудования c ID: {{
                        equipment_id }}</h2>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Примечание</label>
                        <div class="col-sm-9">
                            <textarea type="text" :class="{ 'is-invalid': errors.description }"
                                v-model="form.description" class="form-control" placeholder="Описание"></textarea>
                            <span v-if="errors.description" class="invalid-feedback" role="alert">
                                <strong>
                                    {{ errors.description.join('. ') }}
                                </strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Серийный номер</label>
                        <div class="col-sm-9">
                            <input type="text" :class="{ 'is-invalid': errors.serial_number }"
                                v-model="form.serial_number" class="form-control" placeholder="Описание">
                            <span v-if="errors.serial_number" class="invalid-feedback" role="alert">
                                <strong>
                                    {{ errors.serial_number.join('. ') }}
                                </strong>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="form-label">Тип оборудования</div>
                        <select :class="{ 'is-invalid': errors.equipment_type_id }" v-model="form.equipment_type_id"
                            class="form-select">
                            <option v-for="type in equipment_types" :key="type.id" :value="type.id">{{ type.name + ' ('
                                + type.mask + ')' }}</option>
                        </select>
                        <span v-if="errors.equipment_type_id" class="invalid-feedback" role="alert">
                            <strong>
                                {{ errors.equipment_type_id.join('. ') }}
                            </strong>
                        </span>
                    </div>
                    <div class="mb-1">
                        <button type="submit" @click="saveEquipment"
                            class="btn btn-outline-primary w-100">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import apiClient from '../api';

export default {
    name: 'EquipmentsEdit',
    components: {
    },
    data() {
        return {
            equipment_id: 1,
            equipment: {},
            equipment_types: [],
            form: {
                equipment_type_id: 1,
                serial_number: '',
                description: ''
            },
            errors: {},
        }
    },
    methods: {
        async getEquipment() {
            this.errors = {};
            this.success = {};
            try {
                const response = await apiClient.get(
                    '/equipment/' + this.equipment_id,
                    {}
                ).then(
                    (response) => {
                        this.equipment = response.data;
                        this.form.equipment_type_id = this.equipment.equipment_type.id;
                        this.form.description = this.equipment.description || '';
                        this.form.serial_number = this.equipment.serial_number;
                    }
                ).catch(
                    (error) => {
                        if (typeof error === 'string') {
                            this.$store.dispatch(
                                'addFlashMessage',
                                error
                            );
                        } else if ('errors' in error) {
                            this.errors = error.errors;
                        } else if ('message' in error) {
                            this.$store.dispatch(
                                'addFlashMessage',
                                error.message
                            );
                        }
                    }
                );
            } catch (error) {
                if (typeof error === 'string') {
                    this.$store.dispatch(
                        'addFlashMessage',
                        error
                    );
                } else if ('errors' in error) {
                    this.errors = error.errors;
                } else if ('message' in error) {
                    this.$store.dispatch(
                        'addFlashMessage',
                        error.message
                    );
                }
            }
        },
        async saveEquipment() {
            this.errors = {};
            this.success = {};
            try {
                const response = await apiClient.put(
                    '/equipment/' + this.equipment_id,
                    this.form
                ).then(
                    (response) => {
                        this.success = response.data;
                    }
                ).catch(
                    (error) => {
                        error = error.response?.data;
                        if (typeof error === 'string') {
                            this.$store.dispatch(
                                'addFlashMessage',
                                error
                            );
                        } else if ('message' in error) {
                            this.$store.dispatch(
                                'addFlashMessage',
                                error.message
                            );
                        } else {
                            this.errors = error;
                        }
                    }
                );
            } catch (error) {
                if (typeof error === 'string') {
                    this.$store.dispatch(
                        'addFlashMessage',
                        error
                    );
                } else if ('errors' in error) {
                    this.errors = error.errors;
                } else if ('message' in error) {
                    this.$store.dispatch(
                        'addFlashMessage',
                        error.message
                    );
                }
            }
        }
    },
    async mounted() {
        this.equipment_id = this.$route.params.id;
        this.errors = {};
        this.success = {};
        try {
            const response = await apiClient.get(
                '/equipment-type/without-pagination',
                {}
            ).then(
                (response) => {
                    this.equipment_types = response.data;
                    this.form.equipment_type_id = this.equipment_types[0].id || 1;
                }
            ).catch(
                (error) => {
                    if (typeof error === 'string') {
                        this.$store.dispatch(
                            'addFlashMessage',
                            error
                        );
                    } else if ('errors' in error) {
                        this.errors = error.errors;
                    } else if ('message' in error) {
                        this.$store.dispatch(
                            'addFlashMessage',
                            error.message
                        );
                    }
                }
            );
        } catch (error) {
            if (typeof error === 'string') {
                this.$store.dispatch(
                    'addFlashMessage',
                    error
                );
            } else if ('errors' in error) {
                this.errors = error.errors;
            } else if ('message' in error) {
                this.$store.dispatch(
                    'addFlashMessage',
                    error.message
                );
            }
        }

        this.getEquipment();
    }
};
</script>
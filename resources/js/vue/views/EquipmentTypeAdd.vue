<template>
    <div class="m-3">
        <div class="container">
            <div class="card">
                <form @submit.prevent="createEquipmentType">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Добавить тип оборудования</h2>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label class="form-label">Название типа</label>
                                <input type="text" class="form-control"
                                    :class="{ 'is-invalid': errors.equipment_type_name }"
                                    v-model="form.equipment_type_name" placeholder="TP-Link TL-WR74" autocomplete="off"
                                    name="equipment_type_name">
                                <span v-if="errors.equipment_type_name" class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ errors.equipment_type_name.join('. ') }}
                                    </strong>
                                </span>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Маска серийного номера</label>
                                <input type="text" class="form-control"
                                    :class="{ 'is-invalid': errors.serial_number_mask }"
                                    v-model="form.serial_number_mask" placeholder="XXAAAAAXAA" autocomplete="off"
                                    name="mask">
                                <span v-if="errors.serial_number_mask" class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ errors.serial_number_mask.join('. ') }}
                                    </strong>
                                </span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <button type="submit" class="btn btn-outline-primary w-100">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import apiClient from '../api';

export default {
    name: 'EquipmentTypeAdd',
    components: {
    },
    data() {
        return {
            form: {
                equipment_type_name: '',
                serial_number_mask: ''
            },
            errors: {}
        }
    },
    methods: {
        async createEquipmentType() {
            this.errors = {};
            const response = await apiClient.post(
                '/equipment-type',
                this.form,
            ).then(
                (response) => {
                    this.$router.push({ name: 'equipment_types' });
                }
            ).catch(
                (error) => {
                    console.log(error);
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
        }
    }
};
</script>
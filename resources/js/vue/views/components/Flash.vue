<template>
    <div style="position: fixed; bottom: 5vh; right: 0; z-index: 100;">
        <div v-if="getFlashMessages" v-for="(flashMessage, index) in getFlashMessages" :key="index"
            class="alert" :class="'alert-' + flashMessage.type" role="alert">
            <div class="d-flex">
                <div>
                    <h4 class="alert-title">{{ flashMessage.message }}</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'Flash',
    data() {
        return {
            message: null,
        };
    },
    methods: {
    },
    computed: {
        ...mapGetters(['getFlashMessages'])
    }
};
</script>
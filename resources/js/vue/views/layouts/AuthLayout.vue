<template>
    <div class="page-wrapper">
        <div class="page page-center">
            <div class="container container-tight py-4">
                <div class="d-flex justify-content-center">
                    <div class="col-4">
                        <div class="card card-md">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AuthLayout',
    data() {
        return {
        }
    }
}
</script>
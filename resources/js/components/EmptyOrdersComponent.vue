<template>
    <div class="container">
        <div class="container text-center py-5 w-75">
            <div class="container">
                <lottie-animation class="container"
                                  path="assets/lottie/empty-cart.json"
                />
                <div class="card-footer">
                    <button class="btn btn-block" @click="back()">Aún no tienes compras... <strong>empezar ahora</strong></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LottieAnimation from 'lottie-vuejs/src/LottieAnimation.vue'

export default {
    name: 'empty-orders-component',
    components: {
        LottieAnimation
    },

    methods: {
        back() {
            window.history.back()
        }
    }
}
</script>

<template>
    <div class="container">
        <div class="container text-center py-5 w-75">
            <div class="container">
                <img @click="back()" class="img-fluid" src="/storage/assets/gifs/empty-cart.gif">
                <div class="card-footer">
                    <button class="btn btn-block" @click="back()">Carrito vacío... <strong>ir de compras</strong></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LottieAnimation from 'lottie-vuejs/src/LottieAnimation.vue'

export default {
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

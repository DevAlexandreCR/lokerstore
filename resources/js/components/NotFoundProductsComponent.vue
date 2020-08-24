<template>
    <div class="container">
        <div class="container text-center">
            <p class="text-primary d-inline-block">No encontramos lo que buscas</p>
            <button class="btn btn-link btn-sm font-weight-bold">Volver</button>
        </div>
        <div class="container w-75">
            <lottie-animation class="container"
                              path="assets/lottie/404-page1.json"
            />
        </div>
    </div>
</template>

<script>
import LottieAnimation from 'lottie-vuejs/src/LottieAnimation.vue'

export default {
    components: {
        LottieAnimation
    },
    data: () => ({

    })
};
</script>

<template>
    <div class="container">
        <div class="container text-center py-5 w-75">
            <div class="container">
                <img @click="back()" class="img-fluid" src="/assets/gifs/empty-cart.gif">
                <div class="card-footer">
                    <button class="btn btn-block" @click="back()">{{ __('users.empty_cart') }} <strong>{{ __('users.go_shopping') }}</strong></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LottieAnimation from 'lottie-vuejs/src/LottieAnimation.vue'

export default {
    name: 'empty-cart-component',
    data() {
        return {
            url: process.env.MIX_APP_URL + '/home/show?'
        }
    },
    components: {
        LottieAnimation
    },

    methods: {
        back() {
            window.location.href = this.url
        }
    }
}
</script>

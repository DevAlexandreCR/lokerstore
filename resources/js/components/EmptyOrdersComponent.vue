<template>
    <div class="container">
        <div class="container text-center py-5 w-75">
            <div class="container">
                <lottie-animation class="container"
                                  path="assets/lottie/empty-cart.json"
                />
                <div class="card-footer">
                    <button class="btn btn-block" @click="back()">{{ __('orders.empty') }} <strong>{{ __('users.go_shopping') }}</strong></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LottieAnimation from 'lottie-vuejs/src/LottieAnimation.vue'

export default {
  name: 'empty-orders-component',
  data () {
    return {
      url: process.env.MIX_APP_URL + '/home/show?'
    }
  },
  components: {
    LottieAnimation
  },

  methods: {
    back () {
      window.location.href = this.url
    }
  }
}
</script>

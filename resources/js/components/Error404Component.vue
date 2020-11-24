<template>
    <div class="container">
        <div class="container text-center">
            <p class="text-primary d-inline-block">{{ __('http_errors.404') }}</p>
            <a href="/home" class="btn btn-link btn-sm font-weight-bold">{{ __('actions.back') }}</a>
        </div>
        <lottie-animation class="container"
            path="assets/lottie/404-page.json"
        />
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
}
</script>

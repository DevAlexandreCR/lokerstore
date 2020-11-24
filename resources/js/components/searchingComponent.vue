<template>
    <div class="container">
        <div class="container w-75">
            <span class="spinner-border spinner-border-sm" ></span>
            {{ __('actions.loading') }}
            <lottie-animation class="container"
                              path="assets/lottie/loading.json"
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
}
</script>

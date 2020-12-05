<template>
    <div v-bind:class="[ 'card', 'text-center', 'traslate-up', 'card-gender', 'shadow-sm', (filter ===  __('fields.woman')) ? 'bg-gender-w' : 'bg-gender-m']">
        <div class="card-body">
            <div id="see-more" class="container">
            <h1 class="card-title">{{filter}}</h1>
            <router-link class="btn btn-secondary"
            :to="{name: 'showcase', query: { tags: [this.filter] }}"
            >ver mas</router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'gender',

  data () {
    return {
    }
  },

  props: {
    filter: {
      type: String,
      required: true
    }
  }
}
</script>

<template>
    <div class="container py-4">
        <div class="row cols-3">
            <div class="col">
                <hr>
            </div>
            <div class="col-sm-2 text-center">
                <h5>{{category.name}}</h5>
            </div>
            <div class="col">
                <hr>
            </div>
        </div>
        <div class="row" v-if="selectedRandomProducts.length > 0">
            <div v-bind:class="[ 'col-md-6', (category.id%2 === 0) ? '' : 'order-12']"
                 v-on:click="goToShowcase(category.name)">
                <img v-if="selectedRandomProducts[4]" class="img-fluid img-category"
                     :src="'/photos/' + selectedRandomProducts[4].photos[0].name" alt="">
                <div class="ofert-title">Hasta 50% Off</div>
            </div>
            <div class="col-md-6" v-if="products.length > 0">
                <div class="row">
                    <div class="col-sm-6 d-none d-sm-block my-1" v-on:click="goToShowcase(category.name)"
                    v-for="(product, index) in selectedRandomProducts" :key="product.id">
                        <card-category-component v-if="index < 4" :product="product"></card-category-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import CardCategoryComponent from '../../components/CardCategoryComponent'

export default {

  name: 'category',

  components: {
    CardCategoryComponent
  },

  data () {
    return {
    }
  },

  props: {
    category: {
      required: true
    },
    products: {
      type: Array,
      default: () => []
    }
  },

  methods: {
    goToShowcase (filter) {
      this.$router.push({ name: 'showcase', query: { category: filter } })
    }
  },

  computed: {
    selectedRandomProducts: function () {
      const selectedRandomProducts = [] // selected random products
      let maxSelected = 0 // count max selected 4 products
      let count = 0 // count iterations
      while (maxSelected < 5 && this.products.length > 0 && count < this.products.length) {
        count++
        const random = Math.floor(Math.random() * this.products.length)
        const product = this.products[random]
        if (product.category.id_parent === this.category.id) {
          if (!selectedRandomProducts.includes(product)) {
            selectedRandomProducts.push(product)
            maxSelected++
          }
        }
      }

      return selectedRandomProducts
    }
  }
}
</script>

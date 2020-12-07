<template>
    <div class="card card-hover img-hover-zoom shadow-sm card-product" @click="showProduct(product.id)" v-if="product">
        <img :src="'/photos/' + product.photos[0].name" class="card-img-top" :alt="product.name">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 text-name text-sm-center">{{product.name}}</div>
                <div class="col-lg-6"><p class="text-price">
                    <span class="text-old-price">{{ product.price | oldPrice }}</span>
                    <strong>{{ product.price | price }}</strong></p>
                </div>
            </div>
            <div class="row container">
                <p class="text-left d-none d-md-block">{{ product.description | truncate }}</p>
            </div>
        </div>
    </div>
</template>

<script>

import NumberFormat from '../constants/NumberFormat'

export default {
  name: 'product-component',

  props: {
    product: {
      type: Object,
      default: () => []
    }
  },

  methods: {
    showProduct (id) {
      window.location.assign(`/products/${id}`)
    }
  },

  filters: {
    price: function (value) {
      return NumberFormat.format(value)
    },

    truncate: function (value) {
      return value.substring(0, 50) + '...'
    },

    oldPrice: function (value) {
      value = parseFloat(value)
      const oldPrice = value + value * 0.1
      return NumberFormat.format(oldPrice)
    }
  }
}

</script>

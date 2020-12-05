<template>
    <div>
        <div class="row">
            <search-product-component :products="products" v-on:add="addProduct">
            </search-product-component>
        </div>
        <div class="row">
            <order-table-component :selectedProducts="selectedProducts" :count="count" v-model="count">
            </order-table-component>
        </div>
    </div>
</template>

<script>

import SearchProductComponent from '../../admin-components/SearchProductComponent'
import OrderTableComponent from '../../admin-components/OrderTableComponent'
export default {
  name: 'create-order',
  components: { OrderTableComponent, SearchProductComponent },
  data () {
    return {
      selectedProducts: [],
      count: 0
    }
  },

  props: {
    products: {
      type: Array,
      default: () => []
    }
  },

  methods: {
    addProduct (product) {
      let existing = false
      this.selectedProducts.forEach((prod, index) => {
        if (prod.stock.id === product.stock.id) {
          prod.quantity += 1
          this.selectedProducts[index] = prod
          existing = true
        }
      })

      if (!existing) this.selectedProducts.push(product)
      this.count += 1
    }
  }
}
</script>

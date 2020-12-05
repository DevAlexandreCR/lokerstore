<template>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <autocomplete :suggestions="products" v-model="selection" v-on:select="selectProduct"
                              :name-input="'reference'" :name-label="__('fields.products')" :styles="'form-control'"></autocomplete>
            </div>
            <div class="col-md-5">
                <label for="productsFound">{{ __('products.details') }}</label>
                <table class="table table-condensed table-sm table-borderless" id="productsFound">
                    <thead>
                    <tr>
                        <th>{{ __('fields.product') }}</th>
                        <th>{{ __('products.category') }}</th>
                        <th>{{ __('products.stock') }}</th>
                        <th>{{ __('products.cost') }}</th>
                        <th>{{ __('products.price') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="productFound">
                        <td>{{ productFound.name }}</td>
                        <td>{{ productFound.category.name }}</td>
                        <td>{{ productFound.stock }}</td>
                        <td>{{ productFound.cost | price }}</td>
                        <td>{{ productFound.price | price }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <label for="productFoundStocks">{{ __('products.stock_available') }}</label>
                <table class="table table-condensed table-sm table-borderless" id="productFoundStocks">
                    <thead>
                    <tr>
                        <th>{{ __('products.size') }}</th>
                        <th>{{ __('products.color') }}</th>
                        <th>{{ __('products.quantity') }}</th>
                        <th>{{ __('actions.add') }}</th>
                    </tr>
                    </thead>
                    <tbody v-if="productFound">
                    <tr v-for="stock in productFound.stocks" :key="stock.id">
                        <td>{{ stock.size.name }}</td>
                        <td class="text-lowercase">{{ stock.color.name }}</td>
                        <td>{{ stock.quantity }}</td>
                        <td>
                            <button class="btn btn-success btn-sm" v-on:click="addProduct(stock.id)">
                                <ion-icon name="add-outline"></ion-icon>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import Autocomplete from './Autocomplete'
import NumberFormat from '../constants/NumberFormat'

export default {
  name: 'search-product-component',
  components: { Autocomplete },
  data () {
    return {
      productFound: null,
      selection: ''
    }
  },

  props: {
    products: {
      type: Array,
      default: () => []
    }
  },

  methods: {
    selectProduct (product) {
      this.productFound = product
    },

    addProduct (stockSelected) {
      const product = {}
      const stock = this.productFound.stocks.filter(stock => {
        return stock.id === stockSelected
      })
      product.stock = stock[0]
      product.reference = this.productFound.reference
      product.name = this.productFound.name
      product.quantity = 1
      product.price = this.productFound.price
      this.$emit('add', product)
    }
  },

  filters: {
    price (price) {
      return NumberFormat.format(price)
    }
  }
}
</script>

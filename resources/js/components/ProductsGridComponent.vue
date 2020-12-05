<template>
    <div class="mt-1">
        <div class="row row-cols-sm-2">
            <div class="col-8">
                <div class="container">
                    <div class="form-inline pt-4 pl-2">
                        <label class="text-small" for="exampleFormControlSelect1">{{ __('actions.order') }}</label>
                        <select class="form-control form-control-sm ml-2 mr-2" id="exampleFormControlSelect1" v-on:change="orderBy($event)">
                            <option selected value="0">{{ __('actions.order') }}</option>
                            <option value="1">{{ __('actions.min_price') }}</option>
                            <option value="2">{{ __('actions.max_price') }}</option>
                            <option value="3">{{ __('fields.name') }}</option>
                        </select>
                        <small class="text-small" for="exampleFormControlSelect1"> {{ __('products.found', { product_found: products.length }) }} </small>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 pt-4">
                <paginate-links v-if="products.length > 0"
                                for="products"
                                :classes="{
                    'ul': ['pagination', 'pagination-sm', 'justify-content-end'],
                    'li': 'page-item',
                    'a' : 'page-link'
                }"
                :show-step-links="true">
                </paginate-links>
            </div>
        </div>
        <paginate v-if="products.length > 0" name="products" :list="products" :per="15" class="">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6  my-2" v-for="product in paginated('products')" :key="product.name">
                    <product-component :product="product"></product-component>
                </div>
            </div>
        </paginate>

        <div v-else>
            <transition name="fade">
                <div class="my-2 btn" v-show="loading">
                    <searching-component></searching-component>
                </div>
            </transition>

            <transition name="fade">
                <div class="my-2 btn" v-show="loading === false" @click="viewAll()">
                    <not-found-products-component></not-found-products-component>
                </div>
            </transition>
        </div>
</div>

</template>

<script>
import ProductComponent from './ProductComponent'
import NotFoundProductsComponent from './NotFoundProductsComponent'
import SearchingComponent from './searchingComponent'
export default {
  name: 'products-grid',
  components: {
    SearchingComponent,
    ProductComponent,
    NotFoundProductsComponent
  },
  data () {
    return {
      paginate: ['products']
    }
  },

  props: {
    products: {
      type: Array,
      required: true,
      default: () => []
    },

    loading: {
      type: Boolean,
      required: true,
      default: false
    }
  },

  methods: {
    viewAll () {
      this.$emit('sendQuery', null, true)
    },

    orderBy (event) {
      const value = event.target.value
      switch (value) {
        case '1':
          this.products.sort(function (a, b) {
            if (parseFloat(a.price) > parseFloat(b.price)) {
              return 1
            }
            if (parseFloat(a.price) < parseFloat(b.price)) {
              return -1
            }
            // a must be equal to b
            return 0
          })
          break
        case '2':
          this.products.sort(function (a, b) {
            if (parseFloat(a.price) < parseFloat(b.price)) {
              return 1
            }
            if (parseFloat(a.price) > parseFloat(b.price)) {
              return -1
            }
            // a must be equal to b
            return 0
          })
          break
        case '3':
          this.products.sort(function (a, b) {
            if (a.name > b.name) {
              return 1
            }
            if (a.name < b.name) {
              return -1
            }
            // a must be equal to b
            return 0
          })
          break
      }
    }
  }
}
</script>

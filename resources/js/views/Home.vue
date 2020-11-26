<template>
    <div class="container-fluid">
         <banner-component ></banner-component>
        <div class="container" v-if="isNotHomeRoute()">
            <div class="row my-1" id="navbar-category">
                <div class="col-sm-2 d-none d-sm-block">
                    <router-link
                    class="nav-link"
                    exact
                    :to="{name: 'showcase', query: { tags: [__('fields.woman')] }}"
                    >Mujer</router-link>
                </div>
                <div class="col-sm-2 d-none d-sm-block">
                    <router-link
                    class="nav-link"
                    exact
                    :to="{name: 'showcase', query: { tags: [__('fields.man')] }}"
                    >Hombre</router-link>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" :placeholder="__('actions.search_by')"
                        aria-label="Search" aria-describedby="btn-search" v-model="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" @click="getProducts(search)" type="button" id="btn-search">{{ __('actions.search') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </div>
        <div class="container" v-show="isNotHomeRoute()">
        <div class="row">
            <div class="col-md-6 first">
                <gender-component :filter="__('fields.woman')"></gender-component>
            </div>
            <div class="col-md-6">
                <gender-component :filter="__('fields.man')"></gender-component>
            </div>
        </div>
        <br>
        <section>
            <promotions-component></promotions-component>
        </section>
        <br>
        <section v-for="category in categories" :key="category.id">
            <category-component :category="category" :products="products"></category-component>
        </section>
        </div>
    </div>
</template>

<script>

import api from '../api.js'
import BannerComponent from '../components/BannerComponent'
import GenderComponent from '../components/GenderComponent'
import CategoryComponent from './sections/CategoryComponent'
import PromotionsComponent from './sections/PromotionsComponent'

export default {
  name: 'home',

  data () {
    return {
      categories: {
        type: Array,
        default: () => []
      },
      products: {
        type: Array,
        default: () => []
      },
      search: null
    }
  },
  components:
        {
          BannerComponent,
          GenderComponent,
          CategoryComponent,
          PromotionsComponent
        },

  methods: {
    isNotHomeRoute () {
      return this.$router.history.current.path === '/home'
    },

    getProducts (search = null) {
      this.products = []
      var query = {}

      if (search) {
        query = {
          search: search
        }
        this.$router.push({ name: 'showcase', query: query }).catch((e) => { console.log(e) })
      }
    }
  },
  created () {
    this.getProducts()
    api.getProducts().then(products => {
      products.forEach(product => {
        this.products.push(product)
      })
    })
    api.getCategories().then(categories => {
      this.categories = categories
    })
  },
  mounted () {

  }
}
</script>

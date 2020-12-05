<template>
    <div id="showcase" class="m-auto">
        <div class="container">
            <div class="row my-1" id="navbar-category">
                <div class="col-sm-2 d-none d-sm-block">
                    <div
                        type="button"
                        :class="['nav-link', { 'router-link-exact-active' : query.tags.includes(__('fields.woman'))}]"
                        @click="setTag(__('fields.woman'))"
                        >{{ __('fields.woman') }}</div>
                </div>
                <div class="col-sm-2 d-none d-sm-block">
                    <div
                        type="button"
                        :class="['nav-link', { 'router-link-exact-active' : query.tags.includes(__('fields.man'))}]"
                        @click="setTag(__('fields.man'))"
                        >{{ __('fields.man') }}</div>
                </div>
                <div class="col-sm-2 d-none d-sm-block">
                    <div
                        type="button"
                        :class="['nav-link', { 'router-link-exact-active' : query.tags.length === 0}]"
                        @click="setTag(null)"
                    >{{ __('fields.all') }}</div>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" :placeholder="__('actions.search_by')"
                        aria-label="Search" aria-describedby="btn-search" v-model="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" @click="setSearch(search)" type="button" id="btn-search">{{ __('actions.search') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <a class="btn btn-sm btn-dark btn-block d-md-none" data-toggle="collapse" href="#collapseFilters" data-trigger="#collapseFilters" role="button" aria-expanded="false"
               aria-controls="collapseFilters">
              {{ __('fields.filters') }}
            </a>
        </div>
        <div class="row">
            <div class="col-sm-3 col-lg-2 container collapse navbar-collapse" id="collapseFilters">
                <filters-component @sendQuery="sendQuery" :query="query" @setSearch="setSearch" :search="search"></filters-component>
            </div>
            <div class="col-sm-9 col-lg-10">
                <products-grid-component @sendQuery="sendQuery" :loading="loading" :products="products"></products-grid-component>
            </div>
        </div>
    </div>
</template>

<script>
import api from '../api.js'
import FiltersComponent from '../components/FiltersComponent'
import ProductsGridComponent from '../components/ProductsGridComponent'
import $ from 'jquery'

export default {
  name: 'showcase',

  components: {
    FiltersComponent,
    ProductsGridComponent
  },

  data () {
    return {
      products: {
        type: Array,
        default: () => []
      },
      search: null,
      query: {
        tags: [],
        category: null,
        colors: [],
        price: [],
        size: null,
        search: null
      },

      loading: true
    }
  },

  methods: {
    buildQuery (data) {
      for (const key in data) {
        // eslint-disable-next-line no-prototype-builtins
        if (data.hasOwnProperty(key)) {
          switch (key) {
            case 'tags': {
              const tags = []
              let array = []
              if (typeof data.tags === 'object') {
                array = data.tags
              } else {
                array.push(data.tags)
              }
              array.forEach(tag => {
                tags.push(tag)
              })
              this.query.tags = tags
              break
            }
            case 'category':
              this.query.category = data[key]
              break
            case 'search':
              this.query.search = data[key]
              this.search = data[key]
              break
            case 'colors':
              this.query.colors = data[key]
              break
            case 'price':
              this.query.price = data[key]
              break
            default:
              break
          }
        }
      }
    },

    setTag (tag) {
      this.query.tags = []
      if (tag) this.query.tags.push(tag)
      this.sendQuery(this.query)
    },

    setSearch (search) {
      this.query = {
        tags: [],
        category: null,
        colors: [],
        price: [],
        size: null,
        search: search
      }

      this.sendQuery(this.query, true)
    },

    sendQuery (query, reload = false) {
      // $('#collapseFilters').collapse('hide')
      this.$router.push({ name: 'showcase', query: query }).catch(() => {})
      this.loading = true
      if (reload) location.reload()
      else this.getProducts(query)
    },

    getProducts (query) {
      this.products = []
      api.getProducts(query).then(products => {
        this.loading = false
        products.forEach(products => {
          this.products.push(products)
        })
      })
    },

    getScreenSize () {
      const size = screen.width

      if (size < 768) {
        $('#collapseFilters').collapse('hide')
      } else {
        $('#collapseFilters').collapse('show')
      }
    }
  },

  created () {
    this.buildQuery(this.$route.query)
    this.getProducts(this.query)
  },

  mounted () {
    this.getScreenSize()
  }
}
</script>

<template>
    <div class="" id="accordion">
        <div class="card border-primary my-2 card-product" v-show="hasFiltersActive">
            <div class="card-header">
                <h6>{{ __('fields.filters') }}</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-list">
                    <li class="nav-item my-1 w-100" v-if="query.search">
                        <div class="container text-center text-price">{{ __('fields.search') }}</div>
                        <span class="badge badge-pill badge-link shadow-sm p-0 ml-2 pl-2">{{query.search}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_search)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1 w-100" v-if="categorySelected">
                        <div class="container text-center text-price">{{ __('products.category') }}</div>
                        <span class="badge badge-pill badge-link shadow-sm p-0 ml-2 pl-2">{{categorySelected}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_category)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1 w-100" v-if="sizesSelected.length > 0">
                        <div class="container text-center text-price">{{ __('products.size') }}</div>
                        <span v-for="size in sizesSelected" :key="size" class="badge badge-pill badge-link shadow-sm p-0 ml-2 pl-2">
                            {{getSizeName(size)}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_sizes, size)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1 w-100" v-if="colorsSelected.length > 0">
                        <div class="container text-center text-price">{{ __('products.color') }}</div>
                        <span v-for="color in colorsSelected" :key="color" class="badge badge-pill badge-link shadow-sm p-0 ml-2 pl-2">
                            <span v-if="getColorName(color)" :class="['badge', 'badge-color-' + getColorName(color).toLowerCase()]">
                                .</span> {{getColorName(color)}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_color, color)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1 w-100" v-if="priceRange">
                        <div class="container text-center text-price">{{ __('products.price') }}</div>
                        <span class="badge badge-pill badge-link shadow-sm p-0 ml-2 pl-2">
                            <small v-for="(price, index) in priceRange" :key="index">{{price}}</small>
                            <a class="btn btn-link" @click="removeFilter(constants.filter_price)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary btn-sm" @click="resetFilters()">{{ __('actions.clean_filters') }}</button>
            </div>
        </div>
        <div class="card border-primary my-2 card-product">
          <div class="card-header">
              <h6>{{ __('fields.categories') }}</h6>
          </div>
          <div class="card-body" v-if="categories">
            <ul class="nav nav-list" v-for="category in categories" :key="category.id">
                <li class="nav-header w-100" :id="'heading' + category.name">
                    <a class="btn btn-link btn-block" data-toggle="collapse" :data-target="'#' + category.name"
                    aria-expanded="true" :aria-controls="category.name" >{{category.name}}</a>
                    <div class="list-group collapse" :id="category.name" v-for="sub in category.children" :key="sub.name"
                    :aria-labelledby="'heading' + category.name" data-parent="#accordion">
                        <a v-on:click="selectCategory(sub.name)" class="btn list-group-item list-group-item-action">{{sub.name}}</a>
                    </div>
                </li>
            </ul>
          </div>
        </div>
        <div class="card border-primary my-2 card-product">
          <div class="card-header">
              <h6>{{ __('products.price') }}</h6>
          </div>
          <div class="card-body card-filter">
              <div class="row rows-2">
                  <div class="col p-1">
                        <div class="form-group">
                            <label for="inputMin" class="sr-only">Min</label>
                            <input v-model="min" :min="0" type="number" class="form-control input-sm font-mini" id="inputMin" placeholder="min">
                        </div>
                  </div>
                  <div class="col p-1">
                        <div class="form-group">
                            <label for="inputMax" class="sr-only">Max</label>
                            <input v-model="max" :min="0" type="number" class="form-control input-sm font-mini" id="inputMax" placeholder="max">
                        </div>
                  </div>
              </div>
          </div>
          <div class="card-footer text-center">
              <button type="button" class="btn btn-primary btn-sm" @click="sendQuery()">{{ __('actions.apply') }}</button>
          </div>
        </div>
        <div class="card border-primary my-2 card-product">
          <div class="card-header">
              <h6>{{ __('products.color') }}</h6>
          </div>
          <div class="card-body  card-filter overflow-auto" v-if="colors">
            <ul class="list-group w-100" v-for="color in colors" :key="color.name">
                <li class="list-group-item text-lowercase p-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <input type="checkbox" :value="color.id" v-model="colorsSelected">
                            </div>
                        </div>
                        <input type="text" class="form-control text-lowercase" disabled :value="color.name">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            <span v-if="color.name" :class="['badge', 'badge-color-' + color.name.toLowerCase()]">.</span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
          </div>
          <div class="card-footer text-center">
              <button type="button" class="btn btn-primary btn-sm" v-on:click="sendQuery()">{{ __('actions.apply') }}</button>
          </div>
        </div>
        <div class="card border-primary my-2 card-product">
          <div class="card-header">
              <h6>{{ __('products.size') }}</h6>
          </div>
          <div class="card-body" v-if="type_sizes">
            <ul class="nav nav-list" v-for="type in type_sizes" :key="type.name">
                <li class="nav-header w-100" :id="'heading' + type.name">
                    <a class="btn btn-link btn-block" data-toggle="collapse" :data-target="'#sizes' + type.name"
                    aria-expanded="true" :aria-controls="type.name" >{{type.name}}</a>
                    <ul class="list-group collapse" :id="'sizes' + type.name" v-for="size in type.sizes" :key="size.name"
                        :aria-labelledby="'heading' + type.name" data-parent="#accordion">
                        <li class="list-group-item text-lowercase p-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" :value="size.id" v-model="sizesSelected">
                                    </div>
                                </div>
                                <input type="text" class="form-control text-lowercase" disabled :value="size.name">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span v-if="size.name" :class="['badge', 'badge-success']"><ion-icon name="resize-outline"></ion-icon></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
          </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary btn-sm" v-on:click="sendQuery()">{{ __('actions.apply') }}</button>
            </div>
        </div>
    </div>
</template>

<script>

import api from '../api'
import * as Constants from '../constants/Constants'

export default {
  name: 'filters',

  data () {
    return {
      constants: {
        filter_color: Constants.FILTER_COLORS,
        filter_category: Constants.FILTER_CATEGORY,
        filter_price: Constants.FILTER_PRICE,
        filter_sizes: Constants.FILTER_SIZES,
        filter_search: Constants.FILTER_SEARCH
      },
      colors: {
        type: Array,
        default: []
      },
      categories: {
        type: Array,
        default: []
      },
      type_sizes: {
        type: Array,
        default: []
      },
      hasFiltersActive: false,
      tags: [],
      colorsSelected: [],
      categorySelected: null,
      sizesSelected: [],
      priceRange: null,
      min: process.env.MIX_MIN_PRICE_FILTER,
      max: process.env.MIX_MAX_PRICE_FILTER
    }
  },

  props: {
    search: null,
    query: {}
  },

  watch: {
    min: function (val) {
      this.priceRange = `${val}-${this.max}`
    },
    max: function (val) {
      this.priceRange = `${this.min}-${val}`
    }
  },

  methods: {
    getCategories () {
      api.getCategories().then(categories => {
        this.categories = categories
      })
    },
    getColors () {
      api.getColors().then(colors => {
        this.colors = colors
      })
    },

    getColorName (id) {
      if (this.colors.length > 0) {
        const color = this.colors.find(color => color.id === parseInt(id))
        return color.name.toLowerCase()
      }
    },

    getSizes () {
      api.getSizes().then(sizes => {
        this.type_sizes = sizes
      })
    },

    getSizeName (id) {
      let name
      if (this.type_sizes.length > 0) {
        this.type_sizes.forEach(type => {
          type.sizes.forEach(size => {
            if (size.id === parseInt(id)) {
              name = size.name
            }
          })
        })
      }
      return name
    },

    selectCategory (name) {
      this.categorySelected = name
      this.sendQuery()
    },

    selectSizes (id) {
      this.sizeSelected = id
      this.sendQuery()
    },

    resetFilters () {
      this.colorsSelected = []
      this.categorySelected = null
      this.sizesSelected = []
      this.priceRange = null
      this.tags = []
      this.min = process.env.MIX_MIN_PRICE_FILTER
      this.max = process.env.MIX_MAX_PRICE_FILTER
      this.hasFiltersActive = false
      if (this.query.search != null) {
        this.search = null
        this.query.search = null
        this.$emit('sendQuery', null, true)
      } else {
        this.sendQuery()
      }
    },

    getQuerySelected (query) {
      this.query = query
      this.query.colors ? this.colorsSelected = this.getArrayFilter(query.colors) : this.colorsSelected = []
      this.query.sizes ? this.sizesSelected = this.getArrayFilter(query.sizes) : this.sizesSelected = []
      this.query.category ? this.categorySelected = query.category : this.categorySelected = null
      this.query.tags ? this.tags = this.getArrayFilter(query.tags) : this.tags = []
      if (query.price) {
        this.query.price = this.getPriceFromQuery(query.price)
      }

      this.hasFiltersActive = this.hasFilters()
    },

    getArrayFilter (data) {
      let array = []
      if (typeof data === 'object') array = data
      else array.push(data)
      return array
    },

    getPriceFromQuery (data) {
      const array = data.split('-')
      this.min = array[0]
      this.max = array[1]
    },

    sendQuery () {
      this.sizesSelected ? this.query.sizes = this.sizesSelected : this.query.sizes = null
      this.colorsSelected ? this.query.colors = this.colorsSelected : this.query.colors = null
      this.categorySelected ? this.query.category = this.categorySelected : this.query.category = null
      this.priceRange ? this.query.price = this.priceRange : this.query.price = null
      this.hasFiltersActive = this.hasFilters()
      this.$emit('sendQuery', this.query)
    },

    hasFilters () {
      if (this.colorsSelected.length > 0) return true
      else if (this.sizesSelected.length > 0) return true
      else if (this.categorySelected) return true
      else if (this.query.search) return true
      else if (this.min > process.env.MIX_MIN_PRICE_FILTER) return true
      else return this.max < process.env.MIX_MAX_PRICE_FILTER
    },

    removeFilter (key, id = null) {
      switch (key) {
        case Constants.FILTER_CATEGORY:
          this.categorySelected = null
          break
        case Constants.FILTER_COLORS:
          this.removeItemFromArr(this.colorsSelected, id)
          break
        case Constants.FILTER_PRICE:
          this.min = process.env.MIX_MIN_PRICE_FILTER
          this.max = process.env.MIX_MAX_PRICE_FILTER
          this.priceRange = null
          break
        case Constants.FILTER_SIZES:
          this.removeItemFromArr(this.sizesSelected, id)
          break
        case Constants.FILTER_SEARCH:
          this.query.search = null
          this.$emit('setSearch', null, true)
          break
      }

      this.sendQuery()
    },

    removeItemFromArr (arr, item) {
      const i = arr.indexOf(item)

      if (i !== -1) {
        arr.splice(i, 1)
      }
    }
  },

  created () {
    this.getCategories()
    this.getColors()
    this.getSizes()
    this.getQuerySelected(this.$route.query)
  }
}
</script>

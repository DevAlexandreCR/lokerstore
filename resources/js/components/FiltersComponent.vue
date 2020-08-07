<template>
    <div class="container-fluid" id="accordion">
        <div class="card border-primary m-2" v-show="hasFiltersActive">
            <div class="card-header">
                <h6>Filtros</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-list">
                    <li class="nav-item my-1" v-if="categorySelected">
                        <span class="badge badge-pill badge-info shadow-sm p-0 ml-2 pl-2">{{categorySelected}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_category)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1" v-if="sizesSelected.length > 0">
                        <span v-for="size in sizesSelected" class="badge badge-pill badge-link shadow-sm p-0 ml-2 pl-2">{{size}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_sizes)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1" v-if="colorsSelected.length > 0">
                        <span v-for="color in colorsSelected" class="badge badge-pill badge-danger shadow-sm p-0 ml-2 pl-2">{{color}}
                            <a class="btn btn-link" @click="removeFilter(constants.filter_color)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                    <li class="nav-item my-1" v-if="priceRange">
                        <span class="badge badge-pill badge-dark shadow-sm p-0 ml-2 pl-2">
                            <small v-for="price in priceRange">{{price}}</small>
                            <a class="btn btn-link" @click="removeFilter(constants.filter_price)">
                                <ion-icon name="close-outline"></ion-icon>
                            </a>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary btn-sm" @click="resetFilters()">Limpiar filtros</button>
            </div>
        </div>
        <div class="card border-primary m-2">
          <div class="card-header">
              <h6>Categorias</h6>
          </div>
          <div class="card-body" v-if="categories">
            <ul class="nav nav-list" v-for="category in categories" :key="category.id">
                <li class="nav-header w-100" :id="'heading' + category.name">
                    <a class="btn btn-link btn-block" data-toggle="collapse" :data-target="'#' + category.name"
                    aria-expanded="true" :aria-controls="category.name" >{{category.name}}</a>
                    <div class="list-group collapse" :id="category.name" v-for="sub in category.children" :key="sub.id"
                    :aria-labelledby="'heading' + category.name" data-parent="#accordion">
                        <a v-on:click="selectCategory(sub.name)" class="btn list-group-item list-group-item-action">{{sub.name}}</a>
                    </div>
                </li>
            </ul>
          </div>
        </div>
        <div class="card border-primary m-2">
          <div class="card-header">
              <h6>Precio</h6>
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
              <button type="button" class="btn btn-primary btn-sm" @click="sendQuery()">Aplicar</button>
          </div>
        </div>
        <div class="card border-primary m-2">
          <div class="card-header">
              <h6>Colores</h6>
          </div>
          <div class="card-body  card-filter overflow-auto" v-if="colors">
            <ul class="list-group w-100" v-for="color in colors" :key="color.id">
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
              <button type="button" class="btn btn-primary btn-sm" v-on:click="sendQuery()">Aplicar</button>
          </div>
        </div>
        <div class="card border-primary m-2">
          <div class="card-header">
              <h6>Tallas</h6>
          </div>
          <div class="card-body" v-if="type_sizes">
            <ul class="nav nav-list" v-for="type in type_sizes" :key="type.id">
                <li class="nav-header w-100" :id="'heading' + type.name">
                    <a class="btn btn-link btn-block" data-toggle="collapse" :data-target="'#' + type.name"
                    aria-expanded="true" :aria-controls="type.name" >{{type.name}}</a>
                    <ul class="list-group collapse" :id="type.name" v-for="size in type.sizes" :key="size.id"
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
                <button type="button" class="btn btn-primary btn-sm" v-on:click="sendQuery()">Aplicar</button>
            </div>
        </div>
    </div>
</template>

<script>

import api from '../api'
import Constants from "../Constants/constants";

export default {
    name: 'filters',

    data() {
        return {
            constants: {
                filter_color: Constants.FILTER_COLORS,
                filter_category: Constants.FILTER_CATEGORY,
                filter_price: Constants.FILTER_PRICE,
                filter_sizes: Constants.FILTER_SIZES,
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
        getCategories() {
            api.getCategories().then(categories =>  {
                this.categories = categories
            })
        },
        getColors() {
            api.getColors().then(colors =>  {
                this.colors = colors
            })
        },
        getSizes() {
            api.getSizes().then(sizes =>  {
                this.type_sizes = sizes
            })
        },

        selectCategory(name) {
            this.categorySelected = name
            this.sendQuery()
        },

        selectSizes(id) {
            this.sizeSelected = id
            this.sendQuery()
        },

        resetFilters() {
            this.colorsSelected = []
            this.categorySelected = null
            this.sizesSelected = []
            this.priceRange = null
            this.tags = []
            this.min = process.env.MIX_MIN_PRICE_FILTER
            this.max = process.env.MIX_MAX_PRICE_FILTER
            this.hasFiltersActive = false
            this.sendQuery()
        },

        getQuerySelecteds(query) {
            this.query = query
            this.query.colors ? this.colorsSelected = query.colors : this.colorsSelected = []
            this.query.sizes ? this.sizesSelected = query.sizes : this.sizesSelected = []
            this.query.category ? this.categorySelected = query.category : this.categorySelected = null
            this.query.tags ? this.tags = query.tags : this.tags = []
            this.query.price ? this.getPriceFromQuery(query.price) : null

            this.hasFiltersActive = this.hasFilters()
        },

        getPriceFromQuery(data) {
            let array = data.split('-')
            this.min = array[0]
            this.max = array[1]
        },

        sendQuery() {
            this.sizesSelected ? this.query.sizes = this.sizesSelected : this.query.sizes = null
            this.colorsSelected ? this.query.colors = this.colorsSelected : this.query.colors = null
            this.categorySelected ? this.query.category = this.categorySelected : this.query.category = null
            this.priceRange ? this.query.price = this.priceRange : this.query.price = null
            this.hasFiltersActive = this.hasFilters()
            this.$emit('sendQuery', this.query)
        },

        hasFilters() {
            if (this.colorsSelected.length > 0) return true
            else if (this.sizesSelected.length > 0) return true
            else if (this.categorySelected) return true
            else if (this.min > process.env.MIX_MIN_PRICE_FILTER) return true
            else return this.max < process.env.MIX_MAX_PRICE_FILTER;
        },

        removeFilter(key, id = null) {
            switch (key) {
                case Constants.FILTER_CATEGORY:
                    this.categorySelected = null
                    break
                case Constants.FILTER_COLORS:
                    this.colorsSelected = []
                    break
                case Constants.FILTER_PRICE:
                    console.log(key)
                    this.min = process.env.MIX_MIN_PRICE_FILTER
                    this.max = process.env.MIX_MAX_PRICE_FILTER
                    this.priceRange = null
                    break
                case Constants.FILTER_SIZES:
                    this.sizesSelected = []
                    break
            }

            this.sendQuery()
        }
    },

    created() {
        this.getCategories()
        this.getColors()
        this.getSizes()
        this.getQuerySelecteds(this.$route.query)
    }
}
</script>

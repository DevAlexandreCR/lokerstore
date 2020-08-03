<template>
    <div class="container-fluid" id="accordion">
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
                        <a v-on:click="selectCategory(sub.id)" class="btn list-group-item list-group-item-action">{{sub.name}}</a>
                    </div>
                </li>
            </ul>
          </div>
        </div>
        <div class="card border-primary m-2">
          <div class="card-header">
              <h6>Precio</h6>
          </div>
          <div class="card-body  card-filter" v-if="colors">
              <div class="row rows-2">
                  <div class="col p-1">
                        <div class="form-group">
                            <label for="inputMin" class="sr-only">Min</label>
                            <input v-model="priceRange.min" type="number" class="form-control input-sm font-mini" id="inputMin" placeholder="min">
                        </div>
                  </div>
                  <div class="col p-1">
                        <div class="form-group">
                            <label for="inputMax" class="sr-only">Max</label>
                            <input v-model="priceRange.max" type="number" class="form-control input-sm font-mini" id="inputMax" placeholder="max">
                        </div>
                  </div>
              </div>
          </div>
          <div class="card-footer text-center">
              <button type="button" class="btn btn-secondary btn-sm" @click="sendQuery()">Aplicar</button>
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
              <button type="button" class="btn btn-secondary btn-sm" v-on:click="sendQuery()">Aplicar</button>
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
                    <div class="list-group collapse" :id="type.name" v-for="size in type.sizes" :key="size.id"
                    :aria-labelledby="'heading' + type.name" data-parent="#accordion">
                        <a @click="selectSize(size.id)" class="btn list-group-item list-group-item-action">{{size.name}}</a>
                    </div>
                </li>
            </ul>
          </div>
        </div>
    </div>
</template>

<script>

import api from '../api'

export default {
    name: 'filters',

    data() {
        return {
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
            colorsSelected: [],
            categorySelected: {
                type: Number,
                default: null
            },
            sizeSelected: {
                type: Number,
                default: null
            },
            priceRange: {
                min: 0,
                max: 0
            }

        }
    },

    props: {
        query: {
            type: Object,
            default: () => {}
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

        selectCategory(id) {
            this.categorySelected = id
            this.sendQuery()
        },

        selectSize(id) {
            this.sizeSelected = id
            this.sendQuery()
        },

        getQuerySelecteds(query) {
            query.colors ? this.colorsSelected = query.colors : null
            query.category ? this.categorySelected = query.category : null
            if (query.price) {
                this.priceRange.min = query.price.min
                this.priceRange.max = query.price.max
            }
        },

        sendQuery() {
            this.query.size = this.sizeSelected
            this.query.colors = this.colorsSelected
            this.query.category = this.selectCategory
            this.query.price = this.priceRange
            this.$emit('getProducts', this.query)
        }
    },

    created() {
        this.getCategories()
        this.getColors()
        this.getSizes()
        this.getQuerySelecteds(this.query)
    },

    mounted() {
        
    },
}
</script>
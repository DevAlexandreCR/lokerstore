<template>
    <div class="container-fluid">
        <div class="card border-primary m-4">
          <div class="card-header">
              <h6>Categorias</h6>
          </div>
          <div class="card-body  card-filter " v-if="categories">
            <ul class="list-group" v-for="category in categories" :key="category.id">
                <li class="list-group-item">{{category.name}}
                    <ul class="list-group" v-for="sub in category.children" :key="sub.id">
                        <li class="list-group-item">{{sub.name}}</li>
                    </ul>
                </li>
            </ul>
          </div>
        </div>
        <div class="card border-primary m-4">
          <div class="card-header">
              <h6>Colores</h6>
          </div>
          <div class="card-body  card-filter " v-if="colors">
            <ul class="list-group" v-for="color in colors" :key="color.id">
                <li class="list-group-item">{{color.name}}</li>
            </ul>
          </div>
        </div>
        <div class="card border-primary m-4">
          <div class="card-header">
              <h6>Tallas</h6>
          </div>
          <div class="card-body  card-filter " v-if="sizes">
            <ul class="list-group" v-for="size in sizes" :key="size.id">
                <li class="list-group-item">{{size.name}}</li>
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
            sizes: {
                type: Array,
                default: []
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
                console.log(categories);
            })
        },
        getColors() {
            api.getColors().then(colors =>  {
                this.colors = colors
                console.log(colors);
            })
        },
        getSizes() {
            api.getSizes().then(sizes =>  {
                this.sizes = sizes
                console.log(sizes);
            })
        }
    },

    created() {
        this.getCategories()
        this.getColors()
        this.getSizes()
    },

    mounted() {
        
    },
}
</script>
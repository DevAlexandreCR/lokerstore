<template>
    <div class="container-fluid">
         <banner-component v-show="isNotHomeRoute()"></banner-component>
        <div class="container">
            <div class="row my-1" id="navbar-category">
                <div class="col-sm-2 d-none d-sm-block">
                    <router-link 
                    class="nav-link" 
                    exact
                    :to="{name: 'categories', params: { gender: 'Mujer' }}"
                    >Mujer</router-link>
                </div>
                <div class="col-sm-2 d-none d-sm-block">
                    <router-link 
                    class="nav-link" 
                    exact
                    :to="{name: 'categories', params: { gender: 'Hombre' }}"
                    >Hombre</router-link>
                </div>
                <div class="col">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar por nombre, marca, categoria, etc..." aria-label="Search" aria-describedby="btn-search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="btn-search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <router-view></router-view>
        </div>
        <div class="container" v-show="isNotHomeRoute()">
        <div class="row justify-content-center">
            <div class="col-sm-6 first">
                <gender-component :gender="'Mujer'"></gender-component>
            </div>
            <div class="col-sm-6">
                <gender-component :gender="'Hombre'"></gender-component>
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
        data() {
            return {
                categories: {
                    type: Array,
                    default: () => []
                },
                products: {
                    type: Array,
                    default: () => []
                }
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
                return this.$router.history.current['path'] === '/home'
            }
        },
        created() {
            this.products = []
            api.getProducts().then(products => {
                products.forEach(product => {
                    this.products.push(product)
                });
            })

            api.getCategories().then(categories => {
                this.categories = categories              
            })
        },
        mounted() {           
            console.log('Component mounted home')
        }
    }
</script>
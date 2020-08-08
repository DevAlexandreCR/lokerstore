<template>
    <div class="container-fluid" id="showcase">
        <div class="container">
            <div class="row my-1" id="navbar-category">
                <div class="col-sm-2 d-none d-sm-block">
                    <div
                        type="button"
                        :class="['nav-link', { 'router-link-exact-active' : query.tags.includes('Mujer')}]"
                        @click="setTag('Mujer')"
                        >Mujer</div>
                </div>
                <div class="col-sm-2 d-none d-sm-block">
                    <div
                        type="button"
                        :class="['nav-link', { 'router-link-exact-active' : query.tags.includes('Hombre')}]"
                        @click="setTag('Hombre')"
                        >Hombre</div>
                </div>
                <div class="col-sm-2 d-none d-sm-block">
                    <div
                        type="button"
                        :class="['nav-link', { 'router-link-exact-active' : query.tags.length === 0}]"
                        @click="setTag(null)"
                    >Todos</div>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar por nombre, marca, categoria, etc..."
                        aria-label="Search" aria-describedby="btn-search" v-model="search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" @click="setSearch(search)" type="button" id="btn-search">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-3">
                <filters-component @sendQuery="sendQuery" :query="query" @setSearch="setSearch" :search="search"></filters-component>
            </div>
            <div class="col-sm-7">
                <products-grid-component @sendQuery="sendQuery" :products="products"></products-grid-component>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../api.js'
    import FiltersComponent from '../components/FiltersComponent'
    import ProductsGridComponent from '../components/ProductsGridComponent'

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
                }
            }
        },

        methods: {
            buildQuery(data) {
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        switch (key) {
                            case 'tags':
                                let tags = [];
                                let array = []
                                if(typeof data.tags === 'object') {
                                    array = data.tags
                                } else {
                                    array.push(data.tags)
                                }
                                array.forEach(tag => {
                                    tags.push(tag)
                                });
                                this.query['tags'] = tags
                                break;
                            case 'category':
                                this.query['category'] = data[key]
                                break
                            case 'search':
                                this.query['search'] = data[key]
                                this.search = data[key]
                                break
                            case 'colors':
                                this.query['colors'] = data[key]
                                break
                            case 'price':
                                this.query['price'] = data[key]
                                break
                            default:
                                break;
                        }
                    }
                }
            },

            setTag(tag) {
                this.query.tags = []
                if (tag) this.query.tags.push(tag)
                this.sendQuery(this.query)
            },

            setSearch(search) {
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

            sendQuery(query, reload = false) {
                this.$router.push({name: 'showcase', query: query}).catch(()=>{})
                if (reload) location.reload()
                else this.getProducts(query)
            },

            getProducts(query) {
                this.products = []
                api.getProducts(query).then(products => {
                    products.forEach(products => {
                        this.products.push(products)
                    })
                })
            }
        },

        created() {
            this.buildQuery(this.$route.query)
            this.getProducts(this.query)
        },

        mounted() {

        }
    }
</script>

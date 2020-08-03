<template>
    <div class="container-fluid" id="showcase">
        <div class="row justify-content-center">
            <div class="col-3">
                <filters-component @getProducts="getProducts" :query="query"></filters-component>
            </div>
            <div class="col-9">
                <products-grid-component :products="products"></products-grid-component>
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
                query: {
                    type: Object,
                    default: {
                        tags: [],
                        category: null,
                        colors: [],
                        price: {},
                        search: null,
                    }
                }
            }
        },

        computed: {

        },

        methods: {
            buildQuery(data) {
                var query = {}
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        switch (key) {
                            case 'tags':
                                var tags = [];
                                var array = []
                                if(typeof data.tags === 'object') {
                                    array = data.tags
                                } else {
                                    array.push(data.tags)
                                }
                                array.forEach(tag => {
                                    tags.push(tag)
                                });
                                query['tags'] = tags
                                break;
                            case 'category':
                                query['category'] = data[key]
                                break
                            case 'search':
                                query['search'] = data[key]
                                break
                            case 'colors':
                                query['colors'] = data[key]
                                break
                            case 'price':
                                query['price'] = data[key]
                                break
                            default:
                                break;
                        }
                        
                    }
                }

                return query
            },

            getProducts(query) {
                console.log(query);
                api.getProducts(query).then(products => {
                                this.products = products
                            })
            }
        },

        created() {
            this.query = this.buildQuery(this.$route.query) 
            this.getProducts(this.query)            
        },

        mounted() {

        }
    }
</script>
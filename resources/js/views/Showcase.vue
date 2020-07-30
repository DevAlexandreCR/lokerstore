<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Categories view</div>
                    {{products}}
                    <div class="card-body">
                        I'm an example component.
                        <router-link to="/home"><a>return</a></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../api.js'

    export default {
        name: 'showcase',

        data () {
            return {
                products: {
                    type: Array,
                    default: () => []
                }
            }
        },

        computed: {

        },

        methods: {
            getQuery(data) {
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
                            default:
                                break;
                        }
                        
                    }
                }

                return query
            }
        },

        created() {
            var query = this.getQuery(this.$route.query) 
      
            api.getProducts(query).then(products => {
                this.products = products
                console.log(products);
            })
        },

        mounted() {
            console.log('View showcase ...')
            var query = this.$route.query
        }
    }
</script>
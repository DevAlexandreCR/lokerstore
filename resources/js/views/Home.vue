<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Home view</div>

                    <div class="card-body">
                        I'm an Home
                        <router-link to="/home/ej"><a>url to example</a></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import api from '../api.js'
    export default {
        name: 'home',
        data() {
            return {
                products: []
            }
        },
        created() {
            api.getProducts().then(products => {
                console.log(products);
                
                this.products = products
            })
        },
        mounted() {
            console.log('Component mounted home')
        }
    }
</script>
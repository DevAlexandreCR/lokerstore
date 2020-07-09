<template>
    <div class="container-fluid">
         <banner-component></banner-component>
        <div class="container">
            <nav class="navbar navbar-expand-lg" id="navbar-category">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Mujer <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Hombre <span class="sr-only"></span></a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre, categoria, marca, etc..." aria-label="Search">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
            </nav>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Home viewdddddd</div>

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
    import BannerComponent from '../components/BannerComponent'

    export default {
        name: 'home',
        data() {
            return {
                products: []
            }
        },
        components: 
        {
            BannerComponent
        },
        created() {
            api.getProducts().then(products => {
                this.products = products
            })
        },
        mounted() {
            console.log('Component mounted homeeeee')
        }
    }
</script>
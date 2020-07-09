<template>
    <div class="container-fluid">
         <banner-component></banner-component>
        <div class="container">
            <div class="row my-1" id="navbar-category">
                <div class="col-sm-2 d-none d-lg-block">
                    <a class="nav-link" href="#">Mujer <span class="sr-only"></span></a>
                </div>
                <div class="col-sm-2 d-none d-lg-block">
                    <a class="nav-link" href="#">Hombre <span class="sr-only"></span></a>
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
        <div class="row justify-content-center">
            <div class="col">
                <gender-component :gender="'Mujer'"></gender-component>
            </div>
            <div class="col">
                <gender-component :gender="'Hombre'"></gender-component>
            </div>
        </div>
        </div>
    </div>
</template>

<script>

    import api from '../api.js'
    import BannerComponent from '../components/BannerComponent'
    import GenderComponent from '../components/GenderComponent'

    export default {
        name: 'home',
        data() {
            return {
                products: [],
                categories: []
            }
        },
        components: 
        {
            BannerComponent,
            GenderComponent
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
<template>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <paginate-links v-if="products.length > 0"
                                for="products"
                                :classes="{
                    'ul': ['pagination', 'pagination-sm', 'justify-content-end'],
                    'li': 'page-item',
                    'a' : 'page-link'
                }"
                :show-step-links="true">
                </paginate-links>
            </div>
        </div>
        <hr>
        <paginate v-if="products.length > 0" name="products" :list="products" :per="18" class="paginate-list">
            <div class="row row-cols-3" >
                <div class="col-sm-4 my-2" v-for="product in paginated('products')" :key="product.id">
                    <div class="card card-hover" v-if="product">
                        <img :src="'/storage/photos/' + product.photos[0].name" class="card-img-top" :alt="product.name">
                        <div class="card-body">
                            <p class="card-text"><strong>${{product.price}}</strong></p>
                        </div>
                    </div>
                </div>
            </div>

        </paginate>

        <div class="col-sm-4 my-2" v-else-if="paginate" @click="viewAll()">
                <div class="card card-hover">
                    <div class="card-body">
                        <p class="card-text"><strong>no se encontraron resultados</strong></p>
                        <h5>Ver Todos</h5>
                    </div>
                </div>
        </div>
</div>

</template>

<script>
export default {
    name: 'products-grid',

    data() {
        return {
            paginate:['products']
        }
    },

    props: {
        products: {
            type: Array,
            default: () => []
        },
    },

    methods: {
      viewAll() {
          this.$emit('sendQuery', null)
          location.reload()
      }
    },

    mounted() {

    },
}
</script>

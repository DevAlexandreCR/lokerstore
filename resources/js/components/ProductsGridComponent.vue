<template>
    <div class="container-fluid">
        
            <!-- <div class="col-sm-4 my-2" v-for="(product, index) in products" :key="index">
                <div class="card card-hover" v-if="product">
                    <img :src="'/storage/photos/' + product.photos[0].name" class="card-img-top" :alt="product.name">
                    <div class="card-body">
                        <p class="card-text"><strong>${{product.price}}</strong></p>
                    </div>
                </div>
            </div> -->
            <paginate v-if="products.length > 0" name="products" :list="products" :per="20" class="paginate-list">
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
            <paginate-links v-if="products.length > 0" for="products" :simple="{
                    next: 'Next »',
                    prev: '« Back'
            }"></paginate-links>
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
        products : []
    },

    mounted() {
        
    },
}
</script>
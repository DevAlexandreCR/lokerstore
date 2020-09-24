<template>
    <div class="card card-hover img-hover-zoom" @click="showProduct(product.id)" v-if="product">
        <img :src="'/Photos/' + product.photos[0].name" class="card-img-top" :alt="product.name">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5 text-name">{{product.name}}</div>
                <div class="col-sm-7"><p class="text-price">
                    <span class="text-old-price">${{ product.price | oldPrice }}</span>
                    <strong>${{ product.price | price }}</strong></p>
                </div>
            </div>
            <div class="row container">
                <div class="text-left">{{ product.description | truncate }}</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'product-component',

    data() {
        return {

        }
    },

    props: {
        product: {
            type: Object,
            default: {}
        }
    },

    methods: {
        showProduct(id) {
            window.location.assign(`/products/${id}`)
        },
    },

    filters: {
        price: function (value) {
            return Math.round(value)
        },

        truncate: function (value) {
            return value.substring(0,50) + '...'
        },

        oldPrice: function (value) {
            value = parseFloat(value)
            let oldPrice = value + value * 0.1
            return Math.ceil(oldPrice)
        }
    }
}

</script>

<template>
    <div class="card card-hover">
        <img :src="'/storage/photos/' + product.photos[0].name" class="card-img-top" :alt="product.name">
        <div class="card-body">
            <p class="card-text">{{product.description}}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'card-category',

    props: {
        product :{
            type: Object,
            default: {}
        }
    },

    mounted() {
        // console.log(this.product);
    },
}
</script>
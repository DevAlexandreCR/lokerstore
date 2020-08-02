<template>
    <div class="container-fluid">
        <div class="card-title">{{products}}</div>
    </div>
</template>

<script>
export default {
    name: 'products-grid',

    props: {
        products :{
            type: Array,
            default: () => []
        }
    },

    mounted() {
        
    },
}
</script>
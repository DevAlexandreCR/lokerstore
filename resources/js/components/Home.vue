<template>
    <div>
        <router-link to="/home/ej"><a>url to example</a></router-link>
    </div>
</template>

<script>
    export default {
        name: 'home',
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
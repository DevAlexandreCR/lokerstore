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
    export default {
        name: 'home',
        mounted() {
            console.log('Component mounted. home')
        }
    }
</script>
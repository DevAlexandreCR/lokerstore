<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Categories view</div>

                    <div class="card-body">
                        I'm an example component.
                        <router-link to="/home"><a>return</a></router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'categories',

        props: {
            categories: {
                type: () => Array,
                default: []
            }
        },

        mounted() {
            console.log('View categories ...')
        }
    }
</script>
<template>
    <div v-bind:class="[ 'card', 'text-center', 'card-gender', 'shadow-sm', (gender == 'Mujer') ? 'bg-gender-w' : 'bg-gender-m']">
        <div class="card-body">
            <div id="see-more" class="container">
            <h1 class="card-title">{{gender}}</h1>
            <a  href="#" class="btn btn-secondary">Ver mas</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'gender',

        data() {

        },

        props: {
            gender: {
                type: String,
                default: 'Mujer'
            }
        },

        mounted() {
            console.log(`Component mounted. gender ${gender}`)
        }
    }
</script>
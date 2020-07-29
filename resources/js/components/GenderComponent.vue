<template>
    <div v-bind:class="[ 'card', 'text-center', 'traslate-up', 'card-gender', 'shadow-sm', (gender == 'Mujer') ? 'bg-gender-w' : 'bg-gender-m']">
        <div class="card-body">
            <div id="see-more" class="container">
            <h1 class="card-title">{{gender}}</h1>
            <router-link class="btn btn-secondary"
            :to="{name: 'categories', params: { gender: gender }}"
            >ver mas</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'gender',

        data() {
           return{
           } 
        },

        props: {
            gender: {
                type: String,
                default: 'Mujer'
            }
        },

        mounted() {
            console.log(`Component mounted. gender `)
        }
    }
</script>
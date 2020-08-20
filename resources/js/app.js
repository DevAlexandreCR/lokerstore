import './bootstrap'
import router from './router'
import VuePaginate from 'vue-paginate'

window.Vue = require('vue');

Vue.component('banner-component', require('./components/BannerComponent.vue').default)
Vue.component('error404-component', require('./components/Error404Component.vue').default)
Vue.component('empty-cart-component', require('./components/EmptyCartComponent.vue').default)

Vue.use(VuePaginate)

Vue.config.ignoredElements = [/^ion-/]

const app = new Vue({
    el: '#app',
    router
});

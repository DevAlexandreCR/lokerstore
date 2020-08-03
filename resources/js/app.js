import './bootstrap'
import router from './router'

window.Vue = require('vue');

Vue.component('banner-component', require('./components/BannerComponent.vue').default)
import VuePaginate from 'vue-paginate';

Vue.use(VuePaginate);

Vue.config.ignoredElements = [/^ion-/]

const app = new Vue({
    el: '#app',
    router
});

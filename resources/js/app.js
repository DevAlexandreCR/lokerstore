import './bootstrap'
import router from './router'
import VuePaginate from 'vue-paginate';

window.Vue = require('vue');

Vue.component('banner-component', require('./components/BannerComponent.vue').default)

Vue.use(VuePaginate);

Vue.config.ignoredElements = [/^ion-/]

const app = new Vue({
    el: '#app',
    router
});

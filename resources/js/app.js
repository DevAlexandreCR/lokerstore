import './bootstrap'
import router from './router'

window.Vue = require('vue');

Vue.component('banner-component', require('./components/BannerComponent.vue').default)

Vue.config.ignoredElements = [/^ion-/]

const app = new Vue({
    el: '#app',
    router
});

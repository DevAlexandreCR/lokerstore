import './bootstrap'
import router from './router'

window.Vue = require('vue');

Vue.component('edit-user-component', require('./admin-components/EditUserComponent.vue').default)
Vue.component('banner-component', require('./components/BannerComponent.vue').default)

const app = new Vue({
    el: '#app',
    router
});

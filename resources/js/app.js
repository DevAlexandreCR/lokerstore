import Vue from 'vue'
window.Vue = Vue
import './bootstrap'
import router from './router'
import VuePaginate from 'vue-paginate'
import SellersMetric from './components/charts/SellersMetric'
import OrdersMetric from './components/charts/OrdersMetric'
import EmptyCartComponent from './components/EmptyCartComponent'
import EmptyOrdersComponent from './components/EmptyOrdersComponent'
import Error404Component from './components/Error404Component'
import BannerComponent from './components/BannerComponent'

Vue.component('banner-component', BannerComponent)
Vue.component('error404-component', Error404Component)
Vue.component('empty-cart-component', EmptyCartComponent)
Vue.component('empty-orders-component', EmptyOrdersComponent)
Vue.component('orders-metric', OrdersMetric)
Vue.component('sellers-metric', SellersMetric)

Vue.use(VuePaginate)

Vue.config.ignoredElements = [/^ion-/]

const app = new Vue({
    el: '#app',
    router
});

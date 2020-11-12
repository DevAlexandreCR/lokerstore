import Vue from 'vue'
window.Vue = Vue
import './bootstrap'
import router from './router'
import VuePaginate from 'vue-paginate'
import EmptyCartComponent from './components/EmptyCartComponent'
import EmptyOrdersComponent from './components/EmptyOrdersComponent'
import Error404Component from './components/Error404Component'
import BannerComponent from './components/BannerComponent'
import OrdersMetric from "./admin-components/charts/OrdersMetric";
import SellersMetric from "./admin-components/charts/SellersMetric";
import CategoryMetric from "./admin-components/charts/CategoryMetric";
import SalesPercentComponent from "./admin-components/SalesPercentComponent";
import TestApiComponent from "./admin-components/TestApiComponent";

Vue.component('banner-component', BannerComponent)
Vue.component('error404-component', Error404Component)
Vue.component('empty-cart-component', EmptyCartComponent)
Vue.component('empty-orders-component', EmptyOrdersComponent)
Vue.component('orders-metric', OrdersMetric)
Vue.component('sellers-metric', SellersMetric)
Vue.component('category-metric', CategoryMetric)
Vue.component('sales-percent-component', SalesPercentComponent)
Vue.component('test-api-component', TestApiComponent)

Vue.use(VuePaginate)

Vue.config.ignoredElements = [/^ion-/]

const app = new Vue({
    el: '#app',
    router
});

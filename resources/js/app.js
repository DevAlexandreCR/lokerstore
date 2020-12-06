import Vue from 'vue'
import './bootstrap'
import router from './router'
import VuePaginate from 'vue-paginate'
import EmptyCartComponent from './components/EmptyCartComponent'
import EmptyOrdersComponent from './components/EmptyOrdersComponent'
import Error404Component from './components/Error404Component'
import BannerComponent from './components/BannerComponent'
import OrdersMetric from './admin-components/charts/OrdersMetric'
import SellersMetric from './admin-components/charts/SellersMetric'
import CategoryMetric from './admin-components/charts/CategoryMetric'
import SalesPercentComponent from './admin-components/SalesPercentComponent'
import TestApiComponent from './admin-components/TestApiComponent'
import CreateOrder from './views/admin-views/CreateOrder'
import AddPaymentComponent from './admin-components/AddPaymentComponent'
import ToastComponent from './admin-components/ToastComponent'
import { Lang } from 'laravel-vue-lang'
window.Vue = Vue

Vue.component('banner-component', BannerComponent)
Vue.component('error404-component', Error404Component)
Vue.component('empty-cart-component', EmptyCartComponent)
Vue.component('empty-orders-component', EmptyOrdersComponent)
Vue.component('orders-metric', OrdersMetric)
Vue.component('sellers-metric', SellersMetric)
Vue.component('category-metric', CategoryMetric)
Vue.component('sales-percent-component', SalesPercentComponent)
Vue.component('test-api-component', TestApiComponent)
Vue.component('create-order', CreateOrder)
Vue.component('add-payment-component', AddPaymentComponent)
Vue.component('toast-component', ToastComponent)

Vue.use(VuePaginate)

Vue.use(Lang, {
  locale: process.env.MIX_APP_LOCALE,
  fallback: 'en',
  ignore: {
    en: ['validation']
  }
})

Vue.config.ignoredElements = [/^ion-/]

new Vue({
  el: '#app',
  router
})

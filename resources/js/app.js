import './bootstrap';
import router from './router'
import Home from './components/Home'

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home', require('./components/Home.vue').default);

const app = new Vue({
    el: '#app',
    router
});

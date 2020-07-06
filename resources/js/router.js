import Router from 'vue-router'
import Vue from 'vue'
import Home from './views/Home'
import ExampleComponent from './components/ExampleComponent'


Vue.use(Router)

export default new Router({
    mode: 'history',

    routes:[
        {
            path:'/home',
            name: 'home',
            component: Home
        },
        {
            path:'/home/ej',
            name: 'ej',
            component: ExampleComponent 
        }
    ]
})
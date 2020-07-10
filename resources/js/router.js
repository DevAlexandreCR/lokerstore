import Router from 'vue-router'
import Vue from 'vue'
import Home from './views/Home'
import Categories from './views/Categories'
import ExampleComponent from './components/ExampleComponent'


Vue.use(Router)

export default new Router({
    mode: 'history',

    routes:[
        {
            path:'/home',
            name: 'home',
            component: Home,
            children: [
                {
                    path:':gender/categories',
                    name: 'categories',
                    component: Categories 
                }
            ]
        },
        {
            path:'/home/ej',
            name: 'ej',
            component: ExampleComponent 
        }
    ]
})
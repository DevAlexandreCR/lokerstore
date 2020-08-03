import Router from 'vue-router'
import Vue from 'vue'
import Home from './views/Home'
import Showcase from './views/Showcase'
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
                    path:'/home/show',
                    name: 'showcase',
                    component: Showcase 
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
import Router from 'vue-router'
import Home from './components/Home'
import ExampleComponent from './components/ExampleComponent'


Vue.use(Router)

export default new Router({
    mode: 'history',

    routes:[
        {
            path:'/home',
            name: 'home',
            components: Home
        },
        {
            path:'/ej',
            name: 'ej',
            components: ExampleComponent 
        }
    ]
})
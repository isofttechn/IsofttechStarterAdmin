
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

//Import Gate.j here
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

//SWEET ALERT
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
  //Import toast to the window
window.toast = toast;
  

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));


//Import vfrom here
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//Import progressBar here
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })
//Next, wite the progressbar in my master.blade.php

let routes = [
    {path: '/dashboard', component: require('./components/Dashboard.vue').default },
    {path: '/Users', component:  require('./components/Users.vue').default },
    {path: '/profile', component:  require('./components/Profile.vue').default },
    {path: '/developer', component:  require('./components/developer.vue').default },
    {path: '/messanger', component:  require('./components/Messanger').default },
    {path: '*', component:  require('./components/NotFound.vue').default }
   
] 
 

const router = new VueRouter({
    mode: 'history',
    routes
})

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
    });

Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY');
    //return created.moment().format('MMMM Do YYYY, h:mm:ss a');
});


window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('chat-app', require('./components/ChatApp.vue').default);
//Import chat App Component

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
//Import not found page
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

// Vue.component(
//     'chat-app',
//     require('./components/ChatApp.vue').default
// );

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() =>{
            Fire.$emit('searching');
        }, 1000),
        
        printPage() {
            window.print();
        }
    }
});

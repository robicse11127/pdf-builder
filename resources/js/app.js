/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VModal from 'vue-js-modal'

Vue.use(VueRouter)
Vue.use(VModal)


const navbar = Vue.component('app-nav', require('./components/layouts/navbar.vue').default);
const dashboard = Vue.component('dashboard', require('./components/dashboard/dashboard.vue').default);
const createForm = Vue.component('create-form', require('./components/forms/create.vue').default);
const editForm = Vue.component('edit-form', require('./components/forms/edit.vue').default);
const listOfFomrs = Vue.component('list-of-form', require('./components/forms/list.vue').default);

// const textField = Vue.component('text-field', require('./components/fields/text-field.vue').default);

/**
 * Vue Routes
 */
const routes = [
    {path: '/admin/dashboard', component: dashboard},

    {path: '/admin/forms/create', component: createForm},
    {path: '/admin/forms/edit/:id', component: editForm},
    {path: '/admin/forms', component: listOfFomrs}
]

const router = new VueRouter({
    routes,
    mode: 'history'
})

/**
 * Initialize the App
 */
const app = new Vue({
    router,
    el: '#app',
});

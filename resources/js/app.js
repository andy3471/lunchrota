import "./bootstrap";
import Vue from "vue";
window.Vue = Vue;

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Pages
Vue.component("rota", require("./pages/Rota.vue").default);
Vue.component("role-admin", require("./pages/RoleAdmin.vue").default);
Vue.component("app-del-admin", require("./pages/AppDelAdmin.vue").default);
Vue.component("user-role-admin", require("./pages/UserRoleAdmin.vue").default);
Vue.component("user-admin", require("./pages/UserAdmin.vue").default);
Vue.component(
    "role-dropdown",
    require("./components/RoleDropdown.vue").default
);
Vue.component(
    "app-del-support",
    require("./components/AppDelSupport.vue").default
);

Vue.component(
    "lunch-slot-admin",
    require("./pages/LunchSlotAdmin.vue").default
);

//Components
Vue.component("lunches", require("./components/Lunches.vue").default);
Vue.component("roles", require("./components/Roles.vue").default);

//External Components
Vue.component("date-picker", require("andyh-datepicker").default);
Vue.component("time-picker", require("andyh-timepicker").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
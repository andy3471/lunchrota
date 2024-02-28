import "./bootstrap";
import Vue from "vue";
// window.Vue = Vue;

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)

// Import components directly with ES module syntax
import RotaPage from './pages/RotaPage.vue';
import RoleAdmin from './pages/RoleAdmin.vue';
import AppDelAdmin from './pages/AppDelAdmin.vue';
import UserRoleAdmin from './pages/UserRoleAdmin.vue';
import UserAdmin from './pages/UserAdmin.vue';
import RoleDropdown from './components/RoleDropdown.vue';
import AppDelSupport from './components/AppDelSupport.vue';
import LunchSlotAdmin from './pages/LunchSlotAdmin.vue';
import LunchesSelector from './components/LunchSelector.vue';
import RoleSelector from './components/RoleSelector.vue';
import DatePicker from 'andyh-datepicker';
import TimePicker from 'andyh-timepicker';

//Pages
Vue.component("RotaPage", RotaPage);
Vue.component("RoleAdmin", RoleAdmin);
Vue.component("AppDelAdmin", AppDelAdmin);
Vue.component("UserRoleAdmin", UserRoleAdmin);
Vue.component("UserAdmin", UserAdmin);
Vue.component("RoleDropdown", RoleDropdown);
Vue.component("AppDelSupport", AppDelSupport);
Vue.component("LunchSlotAdmin", LunchSlotAdmin);

//Components
Vue.component("LunchesSelector", LunchesSelector);
Vue.component("RoleSelector", RoleSelector);

//External Components
Vue.component("DatePicker", DatePicker);
Vue.component("TimePicker", TimePicker);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// eslint-disable-next-line no-unused-vars
const app = new Vue({
    el: "#app"
});

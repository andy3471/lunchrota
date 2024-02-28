import "./bootstrap";
import Vue from 'vue/dist/vue.esm.js';
// window.Vue = Vue;

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)

// Import components directly with ES module syntax
import RotaPage from './pages/RotaPage.vue';
import UserRoleAdmin from './pages/UserRoleAdmin.vue';
import RoleDropdown from './components/RoleDropdown.vue';
import LunchesSelector from './components/LunchSelector.vue';
import RoleSelector from './components/RoleSelector.vue';
import DatePicker from 'andyh-datepicker';
import TimePicker from 'andyh-timepicker';

//Pages
Vue.component("RotaPage", RotaPage);
Vue.component("UserRoleAdmin", UserRoleAdmin);
Vue.component("RoleDropdown", RoleDropdown);


//Components
Vue.component("LunchesSelector", LunchesSelector);
Vue.component("RoleSelector", RoleSelector);

//External Components
Vue.component("DatePicker", DatePicker);
Vue.component("TimePicker", TimePicker);


window.app = new Vue({
    el: "#app"
});

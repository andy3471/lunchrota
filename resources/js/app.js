import "./bootstrap";
import Vue from 'vue/dist/vue.esm.js';
// window.Vue = Vue;

import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)

// Import components directly with ES module syntax
import RotaPage from './pages/RotaPage.vue';
import LunchesSelector from './components/LunchSelector.vue';
import DatePicker from 'andyh-datepicker';
import TimePicker from 'andyh-timepicker';

//Pages
Vue.component("RotaPage", RotaPage);

//Components
Vue.component("LunchesSelector", LunchesSelector);

//External Components
Vue.component("DatePicker", DatePicker);
Vue.component("TimePicker", TimePicker);


window.app = new Vue({
    el: "#app"
});

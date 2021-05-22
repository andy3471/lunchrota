import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import BootstrapVue from 'bootstrap-vue'


Vue.use(plugin)
Vue.use(BootstrapVue)
InertiaProgress.init()

Vue.prototype.$route = route

const el = document.getElementById('app')

        Vue.component(
            "role-dropdown",
            require("./Components/RoleDropdown.vue").default
        );
        Vue.component(
            "app-del-support",
            require("./Components/AppDelSupport.vue").default
        );

        //Components
        Vue.component("lunches", require("./Components/Lunches.vue").default);
        Vue.component("roles", require("./Components/Roles.vue").default);

        //External Components
        Vue.component("date-picker", require("andyh-datepicker").default);
        Vue.component("time-picker", require("andyh-timepicker").default);

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(el)

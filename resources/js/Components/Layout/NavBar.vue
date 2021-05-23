<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark">
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>

                    <li class="nav-item">
                        <inertia-link :href="$route('home')" class="nav-link">Home</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link :href="$route('about')" class="nav-link">About</inertia-link>
                    </li>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown text="Admin" right>
                        <b-dropdown-item :href="$route('admin.users')">Users</b-dropdown-item>
                        <b-dropdown-item :href="$route('admin.lunch_slots')">Lunch Slots</b-dropdown-item>
                        <b-dropdown-item :href="$route('admin.roles')" v-if="$page.props.config.roles_enabled">Roles</b-dropdown-item>
                        <b-dropdown-item :href="$route('admin.user_roles')" v-if="$page.props.config.roles_enabled">User Roles</b-dropdown-item>
                        <b-dropdown-item :href="$route('admin.upload')" v-if="$page.props.config.roles_enabled">Bulk Upload Roles</b-dropdown-item>
                        <b-dropdown-item :href="$route('admin.app_del')" v-if="$page.props.config.app_del_enabled">App Del</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>
                        <template #button-content>
                            <em>User</em>
                        </template>
                        <b-dropdown-item href="#">Change Password</b-dropdown-item>
                        <b-dropdown-item
                            type="submit"
                            @click="logout"
                        >
                            Sign Out
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>

                <b-navbar-nav class="ml-auto">
                    <li class="nav-item">
                        <inertia-link :href="$route('login')" class="nav-link">Login</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link :href="$route('register')" class="nav-link">Register</inertia-link>
                    </li>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>
<script>
export default {
    methods: {
        logout () {
            this.$inertia.post(route('logout'))
        }
    }
}
</script>

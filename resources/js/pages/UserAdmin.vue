<template>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Expired</th>
                <th>New Password</th>
            </tr>
            <tr v-if="this.loading == true">
                <td colspan="5">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
            </tr>
            <tr v-else v-for="user in filteredUsers" v-bind:key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <div class="form-check">
                        <input
                            v-model="this.admin"
                            class="form-check-input position-static"
                            type="checkbox"
                        />
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" />
                    </div>
                </td>
                <td>
                    <input type="password" class="form-control" />
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>

                    <div class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            v-model="this.showExpired"
                        />
                        <label class="form-check-label">Show Expired</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {},
    data() {
        return {
            users: [],
            loading: false,
            showExpired: false
        };
    },
    computed: {
        filteredUsers() {
            return this.users;
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            this.loading = true;
            axios
                .get("/admin/users/get")
                .then(response => [
                    (this.users = response.data),
                    (this.loading = false)
                ])
                .catch(error => {
                    (this.error = error.response.data)((this.loading = false));
                });
        }
    }
};
</script>

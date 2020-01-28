<template>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th colspan="3">
                    <h4 class="text-center">Lunches</h4>
                </th>
            </tr>
            <tr>
                <td colspan="3" v-if="error">
                    <div class="alert alert-danger">{{ this.error }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="btn-group btn-block" style="height: 46px">
                        <button
                            v-for="lunchslot in this.slots"
                            v-bind:key="lunchslot.id"
                            class="btn btn-primary lunchbtn"
                            style="width:100%;"
                            value="12:30"
                            v-on:click="setLunch(lunchslot.id, 1)"
                            v-bind:disabled="
                                loggedin == false ||
                                    lunchslot.available_today == 0 ||
                                    lunchslot.id == selectedLunch ||
                                    slotsLoading == true
                            "
                        >
                            {{ lunchslot.time }} ({{
                                lunchslot.available_today
                            }})
                        </button>
                        <button
                            class="btn btn-primary lunchbtn"
                            style="width: 20%;"
                            v-bind:disabled="
                                loggedin == false || selectedLunch == null
                            "
                            v-on:click="removeLunch()"
                        >
                            X
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <th class="col-8">Name</th>
                <th class="col-4">Lunch Slot</th>
            </tr>
            <tr v-for="user in userLunches" v-bind:key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.time }}</td>
            </tr>
            <tr v-if="this.loading == true || this.rolesLoading == true">
                <td colspan="3" class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        lunchslots: {
            required: true,
            type: Array
        },
        loggedin: {
            default: false,
            type: Boolean
        },
        initiallunch: {
            default: null,
            type: Number
        }
    },
    data() {
        return {
            slots: this.lunchslots,
            userLunches: [],
            selectedLunch: this.initiallunch,
            loading: false,
            slotsLoading: false,
            rolesLoading: false,
            error: null
        };
    },
    mounted() {
        this.getUserLunches();
    },
    methods: {
        getUserLunches() {
            this.loading = true;
            axios
                .get("/lunchslots/users")
                .then(response => [
                    (this.userLunches = response.data),
                    (this.loading = false)
                ])
                .catch(error => {
                    (this.error = error.response.data)((this.loading = false));
                });
        },
        setLunch(id, a) {
            if (this.rolesLoading == false) {
                this.rolesLoading = true;
                this.error = null;
                this.userLunches = [];
                this.slotsLoading = true;

                if (a !== 0) {
                    axios
                        .post("/lunchslots/claim", {
                            id: id
                        })
                        .then(response => [
                            (this.userLunches = response.data),
                            (this.rolesLoading = false),
                            (this.selectedLunch = id),
                            this.getSlots()
                        ])
                        .catch(error => {
                            (this.error = error.response.data)(
                                (this.loading = false)
                            );
                        });
                }
            }
        },
        removeLunch() {
            this.loading = true;
            this.error = null;
            this.userLunches = [];

            axios
                .post("/lunchslots/unclaim")
                .then(response => [
                    (this.userLunches = response.data),
                    (this.loading = false),
                    (this.selectedLunch = null),
                    this.getSlots()
                ])
                .catch(error => {
                    (this.error = error.response.data)((this.loading = false));
                });
        },
        getSlots() {
            this.slotsLoading = true;
            axios
                .get("/lunchslots/")
                .then(response => [
                    (this.slots = response.data),
                    (this.slotsLoading = false)
                ])
                .catch(error => {
                    (this.error = error.response.data)(
                        (this.slotsLoading = false)
                    );
                });
        }
    }
};
</script>

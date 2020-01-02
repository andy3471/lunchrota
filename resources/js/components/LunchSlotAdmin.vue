<template>
    <div>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class="col-7">Time</th>
                    <th class="col-4">Available</th>
                    <th class="col-1"></th>
                </tr>
                <tr
                    v-for="lunchSlot in this.lunchSlots"
                    v-bind:key="lunchSlot.id"
                >
                    <td>{{ lunchSlot.time }}</td>
                    <td>
                        <input type="number" min="0" class="form-control" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary">
                            Save
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            v-on:click="deleteSlot(lunchSlot.id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <vue-timepicker format="HH:mm" :minute-interval="15"></vue-timepicker>
                    </td>
                    <td>
                        <input type="number" min="0" class="form-control" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary">
                            Add
                        </button>
                    </td>
                </tr>

                <tr v-if="this.loading == true">
                    <td colspan="3">
                        <div
                            class="spinner-border spinner-border-sm"
                            role="status"
                        >
                            <span class="sr-only">Loading...</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import VueTimepicker from "vue2-timepicker";

export default {
    props: {
        autoCalculatedEnabled: {
            default: false,
            type: Boolean
        }
    },
    data() {
        return {
            lunchSlots: [],
            loading: true,
            newTimeSlot: { time: null, available: null }
        };
    },
    mounted() {
        this.getLunchSlots();
    },
    methods: {
        getLunchSlots() {
            this.loading = true;
            axios
                .get("/admin/lunches/get")
                .then(response => [
                    (this.lunchSlots = response.data),
                    (this.loading = false)
                ])
                .catch(error => {
                    (this.error = error.response.data)((this.loading = false));
                });
        },
        createLunchSlot() {},
        deleteSlot(l) {
            this.loading = true;

            axios
                .post("/admin/lunches/destroy", {
                    id: l
                })
                .then(response => [(this.loading = false)])
                .catch(function(error) {
                    console.log(error);
                });
        }
    }
};
</script>

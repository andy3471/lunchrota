<template>
  <div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th class="col-7">Time</th>
          <th class="col-4">Available</th>
          <th class="col-1"></th>
        </tr>
        <tr v-for="(lunchSlot, index) in this.lunchSlots" v-bind:key="lunchSlot.id">
          <td>{{ lunchSlot.time }}</td>
          <td>
            <input type="number" min="0" class="form-control" v-model.number="lunchSlot.available" />
          </td>
          <td>
            <button type="button" class="btn btn-danger" v-on:click="deleteSlot(index)">Delete</button>
          </td>
        </tr>
        <tr v-if="this.loading == true">
          <td colspan="3">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <input
              type="text"
              class="form-control"
              v-model="newSlot.time"
              @keyup.enter="createSlot()"
            />
            <!-- <vue-timepicker format="HH:mm" :minute-interval="15" v-model="newTimeSlot.time"></vue-timepicker> -->
          </td>
          <td>
            <input
              type="number"
              min="0"
              class="form-control"
              v-model.number="newSlot.available"
              @keyup.enter="createSlot()"
            />
          </td>
          <td>
            <button type="button" class="btn btn-primary" @click="createSlot()">Add</button>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <button type="button" class="btn btn-primary" @click="postSlots()">Save</button>
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
      newSlot: { time: null, available: null }
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
    createSlot() {
      if (this.newSlot.available !== null && this.newSlot.time !== null) {
        this.lunchSlots.push(this.newSlot);
        this.newSlot = { time: null, available: null };
      }
    },
    deleteSlot(i) {
      this.lunchSlots.splice(i);
    },
    postSlots() {
      console.log(this.lunchSlots);
      if (this.loading == false) {
        this.loading = true;
        //Make Post Request
      }
    }
  }
};
</script>

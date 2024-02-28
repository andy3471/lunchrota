<template>
  <div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th>Time</th>
          <th
            v-if="lunchcalculated == false"
            style="width: 30%"
          >
            Available
          </th>
          <th style="width: 5%" />
        </tr>
        <tr
          v-for="(lunchSlot, index) in lunchSlots"
          :key="lunchSlot.id"
        >
          <td>{{ lunchSlot.time }}</td>
          <td v-if="lunchcalculated == false">
            <input
              v-model.number="lunchSlot.available"
              type="number"
              min="0"
              class="form-control"
            >
          </td>
          <td>
            <div class="text-right">
              <button
                type="button"
                class="btn btn-danger btn-sm"
                @click="deleteSlot(index)"
              >
                Delete
              </button>
            </div>
          </td>
        </tr>
        <tr v-if="loading == true">
          <td
            colspan="3"
            class="text-center"
          >
            <div
              class="spinner-border spinner-border-sm"
              role="status"
            >
              <span class="sr-only">Loading...</span>
            </div>
          </td>
        </tr>
        <tr v-if="!loading == true">
          <td>
            <time-picker
              v-model="newSlot.time"
              :min-interval="5"
            />
          </td>
          <td v-if="lunchcalculated == false">
            <input
              v-model.number="newSlot.available"
              type="number"
              min="0"
              class="form-control"
              @keyup.enter="createSlot()"
            >
          </td>
          <td>
            <div class="text-right">
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="createSlot()"
              >
                Add
              </button>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="text-right">
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="postSlots()"
              >
                Save
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    lunchcalculated: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      lunchSlots: [],
      loading: true,
      newSlot: { id: 0, time: "00:00", available: 0 }
    };
  },
  mounted() {
    this.getLunchSlots();
  },
  methods: {
    getLunchSlots() {
      this.loading = true;
      axios
        .get("./lunches/get")
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
        this.newSlot = { id: 0, time: "00:00", available: 0 };
      }
    },
    deleteSlot(i) {
      this.lunchSlots.splice(i, 1);
    },
    postSlots() {
      if (this.loading == false) {
        this.loading = true;

        axios
          .post("./lunches", {
            slots: this.lunchSlots
          })
          .then(response => [
            (this.lunchSlots = response.data),
            (this.loading = false),
            this.makeToast("success", "Saved", "Lunch Slots Saved")
          ])
          .catch(function(error) {
            this.makeToast("warning", "Error", error);
          });
      }
    },
    makeToast(variant, title, content) {
      this.$bvToast.toast(content, {
        title: title,
        variant: variant,
        solid: true
      });
    }
  }
};
</script>

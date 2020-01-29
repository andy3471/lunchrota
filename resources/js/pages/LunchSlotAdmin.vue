<template>
  <div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th class="col-7">Time</th>
          <th v-if="this.lunchcalculated == false" class="col-4">Available</th>
          <th class="col-1"></th>
        </tr>
        <tr v-for="(lunchSlot, index) in this.lunchSlots" v-bind:key="lunchSlot.id">
          <td>{{ lunchSlot.time }}</td>
          <td v-if="lunchcalculated == false">
            <input type="number" min="0" class="form-control" v-model.number="lunchSlot.available" />
          </td>
          <td>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              v-on:click="deleteSlot(index)"
            >Delete</button>
          </td>
        </tr>
        <tr v-if="this.loading == true">
          <td colspan="3" class="text-center">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </td>
        </tr>
        <tr v-if="!this.loading == true">
          <td>
            <time-picker v-model="newSlot.time" :minInterval="5"></time-picker>
          </td>
          <td v-if="this.lunchcalculated == false">
            <input
              type="number"
              min="0"
              class="form-control"
              v-model.number="newSlot.available"
              @keyup.enter="createSlot()"
            />
          </td>
          <td>
            <div class="text-right">
              <button type="button" class="btn btn-primary btn-sm" @click="createSlot()">Add</button>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="text-right">
              <button type="button" class="btn btn-primary btn-sm" @click="postSlots()">Save</button>
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
          .post("/admin/lunches", {
            slots: this.lunchSlots
          })
          .then(response => [
            (this.lunchSlots = response.data),
            (this.loading = false),
            (this.makeToast('success', 'Saved', 'Lunch Slots Saved'))
          ])
          .catch(function(error) {
            this.makeToast('warning', 'Error', error);
          });
      }
    },
    makeToast(variant, title, content) {
      this.$bvToast.toast(content, {
        title: title,
        variant: variant,
        solid: true
      })
    }
  }
};
</script>

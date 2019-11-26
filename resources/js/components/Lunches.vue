<template>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th colspan="3">
          <h4 class="text-center">Lunches</h4>
        </th>
      </tr>
      <tr>
        <td colspan="3">
          <div class="btn-group btn-block" style="height: 46px">
            <button
              v-for="lunchslot in this.lunchslots"
              v-bind:key="lunchslot.id"
              class="btn btn-primary lunchbtn"
              style="width:100%;"
              value="12:30"
              v-on:click="setLunch(lunchslot.id, 1)"
            >{{ lunchslot.time }}</button>
            <button
              class="btn btn-primary lunchbtn"
              style="width: 20%;"
              v-on:click="removeLunch()"
            >X</button>
          </div>
        </td>
      </tr>
      <tr>
        <th>Person</th>
        <th>Lunch Slot</th>
      </tr>
      <tr>
        <td>Phill Renyard</td>
        <td>12:30</td>
      </tr>
      <tr v-if="this.loading == true">
        <td colspan="3">
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
    }
  },
  data() {
    return {
      userLunches: [],
      loading: false
    };
  },
  mounted() {},
  methods: {
    setLunch(id, a) {
      this.loading = true;
      if (a !== 0) {
        axios
          .post("/lunchslots/store", {
            id: id
          })
          .then(response => [
            (this.lunchSlots = response.data),
            (this.loading = false)
          ])
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    removeLunch() {
      this.loading = true;
      console.log("removelunch");
      axios
        .post("/lunchslots/destroy")
        .then(response => [
          (this.lunchSlots = response.data),
          (this.loading = false)
        ])
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>

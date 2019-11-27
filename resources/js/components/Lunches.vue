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
              v-bind:disabled="loggedin == false"
            >{{ lunchslot.time }}</button>
            <button
              class="btn btn-primary lunchbtn"
              style="width: 20%;"
              v-bind:disabled="loggedin == false"
              v-on:click="removeLunch()"
            >X</button>
          </div>
        </td>
      </tr>
      <tr>
        <th>Name</th>
        <th>Lunch Slot</th>
      </tr>
      <tr v-for="user in userLunches" v-bind:key="user.id">
        <td>{{ user.name }}</td>
        <td>{{ user.time }}</td>
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
    },
    loggedin: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      userLunches: [],
      loading: false
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
        .catch(function(error) {
          console.log(error);
        });
    },
    setLunch(id, a) {
      this.loading = true;
      this.userLunches = [];

      if (a !== 0) {
        axios
          .post("/lunchslots/claim", {
            id: id
          })
          .then(response => [
            (this.userLunches = response.data),
            (this.loading = false)
          ])
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    removeLunch() {
      this.loading = true;
      this.userLunches = [];

      axios
        .post("/lunchslots/unclaim")
        .then(response => [
          (this.userLunches = response.data),
          (this.loading = false)
        ])
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>

<template>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th colspan="3">
          <h4 class="text-center">
            Lunches
          </h4>
        </th>
      </tr>
      <tr />
      <tr>
        <td colspan="3">
          <div
            class="btn-group btn-block"
            style="height: 46px"
          >
            <button
              v-for="lunchslot in slots"
              :key="lunchslot.id"
              class="btn btn-primary lunchbtn"
              style="width:100%;"
              value="12:30"
              :disabled="
                loggedin == false ||
                  lunchslot.id == selectedLunch ||
                  slotsLoading == true ||
                  !(appdel || !available) && (lunchslot.available_today == 0)
              "
              @click="setLunch(lunchslot.id, 1)"
            >
              {{ lunchslot.time }} ({{
                lunchslot.available_today
              }})
            </button>
            <button
              class="btn btn-primary lunchbtn"
              style="width: 20%;"
              :disabled="
                loggedin == false || selectedLunch == null
              "
              @click="removeLunch()"
            >
              X
            </button>
          </div>
        </td>
      </tr>
      <tr>
        <th style="width: 66%">
          Name
        </th>
        <th style="width: 34%">
          Lunch Slot
        </th>
      </tr>
      <tr
        v-for="user in userLunches"
        :key="user.id"
      >
        <td>{{ user.name }}</td>
        <td>{{ user.time }}</td>
      </tr>
      <tr v-if="loading == true || usersLoading == true">
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
    },
    appdel: {
      default: true,
      type: Boolean
    },
    available: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      slots: this.lunchslots,
      userLunches: [],
      selectedLunch: this.initiallunch,
      loading: false,
      slotsLoading: false,
      usersLoading: false,
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
        .get("./lunchslots/users")
        .then(response => [
          (this.userLunches = response.data),
          (this.loading = false)
        ])
        .catch(error => {
          (this.error = error.response.data)((this.loading = false));
        });
    },
    setLunch(id, a) {
      if (this.usersLoading == false) {
        this.usersLoading = true;
        this.userLunches = [];
        this.slotsLoading = true;

        if (a !== 0) {
          axios
            .post("./lunchslots/claim", {
              id: id
            })
            .then(response => [
              (this.userLunches = response.data),
              (this.usersLoading = false),
              (this.selectedLunch = id),
              this.getSlots()
            ])
            .catch(error => {
              this.makeToast("danger", "Error", error.response.data);
              this.usersLoading = false;
              this.getSlots();
            });
        }
      }
    },
    removeLunch() {
      this.usersLoading = true;
      this.userLunches = [];

      axios
        .post("./lunchslots/unclaim")
        .then(response => [
          (this.userLunches = response.data),
          (this.usersLoading = false),
          (this.selectedLunch = null),
          this.getSlots()
        ])
        .catch(error => {
          this.makeToast("danger", "Error", error.response.data);
          this.usersLoading = false;
          this.getSlots();
        });
    },
    getSlots() {
      this.slotsLoading = true;
      axios
        .get("./lunchslots")
        .then(response => [
          (this.slots = response.data),
          (this.slotsLoading = false)
        ])
        .catch(error => {
          (this.error = error.response.data)((this.slotsLoading = false));
        });
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

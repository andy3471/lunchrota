<template>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 20%">
          Name
        </th>
        <th style="width: 25%">
          Email
        </th>
        <th style="width: 8%">
          Scheduled
        </th>
        <th
          v-if="appdelenabled"
          style="width: 8%"
        >
          App Del
        </th>
        <th style="width: 8%">
          Admin
        </th>
        <th style="width: 8%">
          Expired
        </th>
        <th style="width: 16%">
          New Password
        </th>
      </tr>
      <tr v-if="loading == true">
        <td
          colspan="5"
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
      <tr
        v-for="user in filteredUsers"
        v-else
        :key="user.id"
      >
        <td>
          <input
            v-model="user.name"
            type="text"
            class="form-control"
          >
        </td>
        <td>
          <input
            v-model="user.email"
            type="email"
            class="form-control"
            data-lpignore="true"
          >
        </td>
        <td>
          <div class="form-check">
            <input
              v-model="user.scheduled"
              class="form-check-input position-static"
              type="checkbox"
            >
          </div>
        </td>
        <td v-if="appdelenabled">
          <div class="form-check">
            <input
              v-model="user.app_del"
              class="form-check-input position-static"
              type="checkbox"
            >
          </div>
        </td>
        <td>
          <div class="form-check">
            <input
              v-model="user.admin"
              class="form-check-input position-static"
              type="checkbox"
            >
          </div>
        </td>
        <td>
          <div class="form-check">
            <input
              v-model="user.deleted"
              class="form-check-input"
              type="checkbox"
            >
          </div>
        </td>
        <td>
          <input
            v-model="user.new_password"
            data-lpignore="true"
            type="password"
            class="form-control"
          >
        </td>
      </tr>
      <tr>
        <td colspan="7">
          <div class="container">
            <div class="row">
              <div class="col">
                <input
                  v-model="showExpired"
                  type="checkbox"
                  class="form-check-input"
                >
                <label class="form-check-label">Show Expired</label>
              </div>
              <div class="col">
                <div class="form-check" />
                <div class="text-right">
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="postUsers()"
                  >
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: {
    appdelenabled: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      users: [],
      loading: false,
      showExpired: false,
      errors: []
    };
  },
  computed: {
    filteredUsers() {
      if (this.showExpired) {
        return this.users;
      } else {
        return this.users.filter(function(e) {
          return e.deleted == false;
        });
      }
    }
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      this.loading = true;
      axios
        .get("./users/get")
        .then(response => [
          (this.users = response.data),
          (this.loading = false),
          this.users.forEach(function(e) {
            e.new_password = "";
          })
        ])
        .catch(error => {
          console.log(error.response.data), (this.loading = false);
        });
    },
    postUsers() {
      if (this.loading == false) {
        this.loading = true;
        this.errors = [];

        axios
          .post("./users", {
            users: this.users
          })
          .then(response => [
            (this.users = response.data),
            (this.loading = false),
            this.makeToast("success", "Saved", "Users have been updated")
          ])
          .catch(error => {
            this.errors = $.map(error.response.data.errors, function(
              value,
            ) {
              return [value];
            });
            this.errors.forEach(error =>
              this.makeToast("danger", "Error", error[0])
            );
            this.loading = false;
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

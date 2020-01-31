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
        <td colspan="5" class="text-center">
          <div class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </td>
      </tr>
      <tr v-else v-for="user in filteredUsers" v-bind:key="user.id">
        <td>
          <input type="text" class="form-control" v-model="user.name" />
        </td>
        <td>
          <input type="email" class="form-control" data-lpignore="true" v-model="user.email" />
        </td>
        <td>
          <div class="form-check">
            <input v-model="user.admin" class="form-check-input position-static" type="checkbox" />
          </div>
        </td>
        <td>
          <div class="form-check">
            <input v-model="user.deleted" class="form-check-input" type="checkbox" />
          </div>
        </td>
        <td>
          <input
            v-model="user.new_password"
            data-lpignore="true"
            type="password"
            class="form-control"
          />
        </td>
      </tr>
      <tr>
        <td colspan="5">
          <div class="container">
            <div class="row">
              <div class="col">
                <input type="checkbox" class="form-check-input" v-model="showExpired" />
                <label class="form-check-label">Show Expired</label>
              </div>
              <div class="col">
                <div class="form-check"></div>
                <div class="text-right">
                  <button type="button" class="btn btn-primary" @click="postUsers()">Save</button>
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
  props: {},
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
        .get("/admin/users/get")
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
          .post("/admin/users", {
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
              index
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

<template>
  <div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th style="width: 60%">Role</th>
          <th style="width: 30%">Available</th>
          <th style="width: 10%"></th>
        </tr>
        <tr v-for="(role, index) in this.roles" v-bind:key="role.id">
          <td>{{ role.name }}</td>
          <td>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" v-model="role.available" />
            </div>
          </td>
          <td>
            <button
              type="button"
              class="btn btn-danger btn-sm"
              v-on:click="deleteRole(index)"
            >Delete</button>
          </td>
        </tr>
        <tr v-if="this.loading == true" class="text-center">
          <td colspan="3">
            <div class="spinner-border spinner-border-sm" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </td>
        </tr>
        <tr v-else>
          <td>
            <input
              type="text"
              class="form-control"
              v-model="newRole.name"
              @keyup.enter="createRole()"
            />
          </td>
          <td>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" v-model.number="newRole.available" />
            </div>
          </td>
          <td>
            <div class="text-right">
              <button type="button" class="btn btn-primary btn-sm" @click="createRole()">Add</button>
            </div>
          </td>
        </tr>
        <tr v-if="!this.loading == true">
          <td colspan="3">
            <div class="text-right">
              <button type="button" class="btn btn-primary btn-sm" @click="postRoles()">Save</button>
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
    autoCalculatedEnabled: {
      default: false,
      type: Boolean
    }
  },
  data() {
    return {
      roles: [],
      loading: true,
      newRole: { id: 0, name: null, available: 0 }
    };
  },
  mounted() {
    this.getRoles();
  },
  methods: {
    getRoles() {
      this.loading = true;
      axios
        .get("./roles/get")
        .then(response => [
          (this.roles = response.data),
          (this.loading = false)
        ])
        .catch(error => {
          (this.error = error.response.data)((this.loading = false));
        });
    },
    createRole() {
      if (this.newRole.name !== null) {
        this.roles.push(this.newRole);
        this.newRole = { id: 0, name: null, available: 0 };
      }
    },
    deleteRole(i) {
      this.roles.splice(i, 1);
    },
    postRoles() {
      if (this.loading == false) {
        this.loading = true;

        axios
          .post("./roles", {
            roles: this.roles
          })
          .then(response => [
            (this.roles = response.data),
            (this.loading = false),
            this.makeToast("success", "Saved", "Roles Saved")
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

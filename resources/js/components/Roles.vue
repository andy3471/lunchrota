<template>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th colspan="3">
          <h4 class="text-center">Roles</h4>
        </th>
      </tr>
      <tr>
        <th class="col-5">Name</th>
        <th class="col-4">Role</th>
        <th class="col-3">Type</th>
      </tr>
      <tr
        v-for="user in userRoles"
        v-bind:key="user.id"
        v-bind:class="{ unavailable: (user.available == 0)}"
      >
        <td>{{ user.name }}</td>
        <td>{{ user.role }}</td>
        <td v-if="user.available == 1">Available</td>
        <td v-else>Unavailable</td>
      </tr>
      <tr v-if="this.loading == true">
        <td colspan="3" class="text-center">
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
    date: {
      required: true,
      type: Date,
      default: new Date()
    },
    csrf: {
      reqiured: true,
      type: String
    }
  },
  data() {
    return {
      userRoles: [],
      loading: true
    };
  },
  mounted() {
    this.getRoles();
  },
  methods: {
    getRoles() {
      this.userRoles = [];
      this.loading = true;
      axios
        .get("./roles", {
          params: {
            date: this.date
          }
        })
        .then(response => [
          (this.userRoles = response.data),
          (this.loading = false)
        ])
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  watch: {
    date: function() {
      this.getRoles();
    }
  }
};
</script>

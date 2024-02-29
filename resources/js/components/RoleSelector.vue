<template>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th colspan="3">
          <h4 class="text-center">
            Roles
          </h4>
        </th>
      </tr>
      <tr>
        <th style="width: 40%">
          Name
        </th>
        <th style="width: 30%">
          Role
        </th>
        <th style="width: 20%">
          Type
        </th>
      </tr>
      <tr
        v-for="user in userRoles"
        :key="user.id"
        :class="{ unavailable: (user.available == 0)}"
      >
        <td>{{ user.name }}</td>
        <td>{{ user.role }}</td>
        <td v-if="user.available == 1">
          Available
        </td>
        <td v-else>
          Unavailable
        </td>
      </tr>
      <tr v-if="loading">
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
    date: {
      required: true,
      type: Date,
      default: new Date()
    },
    csrf: {
      required: true,
      type: String,
      default: ''
    }
  },
  data() {
    return {
      userRoles: [],
      loading: true
    };
  },
  watch: {
    date: function() {
      this.getRoles();
    }
  },
  mounted() {
    this.getRoles();
  },
  methods: {
    getRoles() {
      this.userRoles = [];
      this.loading = true;
      axios
        .get("./api/roles", {
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
  }
};
</script>

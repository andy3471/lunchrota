<template>
  <div class="dropdown">
    <button
      type="button"
      class="btn btn-primary dropdown-toggle"
      data-toggle="dropdown"
      id="dropdown9"
      changed="0"
    >
      {{this.selectedRole}}
      <div v-if="this.loading" class="spinner-border spinner-border-sm text-light" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </button>
    <div class="dropdown-menu scrollable-menu">
      <a
        class="dropdown-item"
        v-for="role in roles"
        v-bind:key="role.id"
        v-bind:value="role.id"
        v-on:click="selectRole(role.id)"
      >{{ role.name }}</a>
      <a class="dropdown-item" v-on:click="selectRole('0')">None</a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    csrf: {
      required: true
    },
    roles: {
      required: true,
      default: []
    },
    userid: {
      required: true,
      default: null
    },
    date: {
      required: true
    }
  },
  data() {
    return {
      selectedRole: null,
      loading: true
    };
  },
  mounted() {
    this.getRole();
  },
  methods: {
    getRole: function() {
      this.selectedRole = null;
      this.loading = true;
      axios
        .get("/roles/get", {
          params: {
            date: this.date,
            user_id: this.userid
          }
        })
        .then(response => [
          (this.selectedRole = response.data),
          (this.loading = false)
        ])
        .catch(function(error) {
          console.log(error);
        });
    },
    selectRole: function(role) {
      this.selectedRole = null;
      this.loading = true;
      axios
        .post("/roles/post", {
          date: this.date,
          user_id: this.userid,
          role: role
        })
        .then(response => [
          (this.selectedRole = response.data),
          (this.loading = false)
        ])
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  watch: {
    date: function() {
      this.getRole();
    }
  }
};
</script>

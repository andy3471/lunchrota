<template>
  <div class="dropdown">
    <button
      type="button"
      class="btn btn-primary dropdown-toggle"
      data-toggle="dropdown"
      id="dropdown9"
      changed="0"
    >{{this.selectedRole}}</button>
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
      selectedRole: "None"
    };
  },
  mounted() {
    this.getRole();
  },
  methods: {
    getRole: function() {
      axios
        .get("/roles/get", {
          params: {
            date: this.date,
            user_id: this.userid
          }
        })
        .then(response => (this.selectedRole = response.data))
        .catch(function(error) {
          console.log(error);
        });
    },
    selectRole: function(role) {
      axios
        .post("/roles/post", {
          date: this.date,
          user_id: this.userid,
          role: role
        })
        .then(response => (this.selectedRole = response.data))
        .catch(function(error) {
          console.log(error);
        });
      this.selectedRole = role.name;
    }
  },
  watch: {
    date: function() {
      console.log("changes");
      this.getRole();
    }
  }
};
</script>

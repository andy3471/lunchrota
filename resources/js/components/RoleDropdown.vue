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
        v-on:click="selectRole(role)"
      >{{ role.name }}</a>
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
  mounted() {},
  methods: {
    selectRole: function(role) {
      this.selectedRole = role.name;
    }
  }
};
</script>

<template>
  <div class="dropdown">
    <button
      id="dropdown9"
      type="button"
      class="btn btn-primary dropdown-toggle"
      data-toggle="dropdown"
      changed="0"
    >
      {{ selectedRole }}
      <div
        v-if="loading"
        class="spinner-border spinner-border-sm text-light"
        role="status"
      >
        <span class="sr-only">Loading...</span>
      </div>
    </button>
    <div class="dropdown-menu scrollable-menu">
      <a
        v-for="role in roles"
        :key="role.id"
        class="dropdown-item"
        :value="role.id"
        @click="selectRole(role.id)"
      >{{ role.name }}</a>
      <a
        class="dropdown-item"
        @click="selectRole('0')"
      >None</a>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  props: {
    roles: {
      required: true,
      type: Array,
      default () {
        return [];
      }
    },
    userid: {
      required: true,
      type: Number,
      default: null
    },
    date: {
      required: true,
      type: Date
    }
  },
  data() {
    return {
      selectedRole: null,
      loading: true
    };
  },
  watch: {
    date: function() {
      this.getRole();
    }
  },
  mounted() {
    this.getRole();
  },
  methods: {
    getRole: function() {
      this.selectedRole = null;
      this.loading = true;
      axios
        .get("./userroles/get", {
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
        .post("./userroles/post", {
          date: this.date,
          user_id: this.userid,
          role: role
        })
        .then(response => [
          (this.selectedRole = response.data),
          (this.loading = false),
          this.makeToast("success", "Saved", "Role Saved")
        ])
        .catch(function(error) {
          this.makeToast("warning", "Error", error);
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

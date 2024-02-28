<template>
  <div>
    <div
      v-if="loading"
      class="spinner-border spinner-border-sm text-dark"
      role="status"
    >
      <span class="sr-only">Loading...</span>
    </div>
    <div
      v-else
      class="form-check"
    >
      <input
        v-model="onSupport"
        class="form-check-input"
        type="checkbox"
        @click="setSupport()"
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
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
      loading: true,
      onSupport: false
    };
  },
  watch: {
    date: function() {
      this.getSupport();
    }
  },
  mounted() {
    this.getSupport();
  },
  methods: {
    getSupport: function() {
      this.loading = true;
      axios
        .get("./appdel/get", {
          params: {
            date: this.date,
            user_id: this.userid
          }
        })
        .then(response => [
          (this.onSupport = response.data),
          (this.loading = false)
        ])
        .catch(function(error) {
          console.log(error);
        });
    },
    setSupport: function() {
      this.loading = true;
      axios
        .post("./appdel/post", {
          date: this.date,
          user_id: this.userid,
          on_support: !this.onSupport
        })
        .then(response => [
          (this.onSupport = response.data),
          (this.loading = false),
          this.makeToast("success", "Saved", "Support Day Saved")
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

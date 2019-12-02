<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 order-lg-1" v-if="rolesenabled">
        <roles :date="date"></roles>
      </div>

      <div class="col-lg-4 order-lg-2" v-if="rolesenabled">
        <date-picker :date="date" @change-date="changeDate"></date-picker>
      </div>

      <div class="col-lg-4 order-lg-3">
        <lunches :lunchslots="lunchslots" :loggedin="loggedin" :initialLunch="initialLunch"></lunches>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    lunchslots: {
      default: false,
      type: Array
    },
    loggedin: {
      default: false,
      type: Boolean
    },
    rolesenabled: {
      type: Boolean,
      default: false
    },
    initialLunch: {
      default: null,
      type: Number
    }
  },
  data() {
    return {
      date: new Date()
    };
  },
  mounted() {},
  methods: {
    changeDate(e) {
      this.date = e;
    }
  }
};
</script>

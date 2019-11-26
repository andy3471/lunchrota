<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 order-lg-1">
        <roles :date="date"></roles>
      </div>

      <div class="col-lg-4 order-lg-2">
        <date-picker :date="date" @change-date="changeDate"></date-picker>
      </div>

      <div class="col-lg-4 order-lg-3">
        <lunches :lunchslots="lunchslots"></lunches>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    lunchslots: {
      required: true,
      type: Array
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

<template>
  <div>
      <input type="text" class="form-control" v-on:click="openDropdown()">
      <div class="timedropdown" v-if="this.dropdownOpen">
          <ul class="timeselect hours">
            <li class="header">HH</li>
            <li v-for="(hour, index) in this.hours" 
                v-bind:key="index"
                v-bind:class="{ selected: (hour == selectedHour) }"
                v-on:click="selectHour(hour)"
            >{{hour}}</li>
          </ul>
            <ul class="timeselect minutes">
              <li class="header">MM</li>
              <li v-for="(min, index) in this.mins" 
                  v-bind:key="index"
                  v-bind:class="{ selected: (min == selectedMin) }"
                  v-on:click="selectMin(min)"
                  >{{min}}</li>
          </ul>
      </div>
  </div>
</template>

<script>
export default {
  props: {
  },
  data() {
    return {
      dropdownOpen: false,
      hours: [],
      mins: [],
      selectedHour: null,
      selectedMin: null
    };
  },
  mounted() {
      this.calculateHoursList();
      this.calculateMinutesList();
      document.addEventListener("click", this.handleClickOutside);
  },
  destroyed() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  methods: {
    calculateHoursList() {
      for (let i = 0; i < 24; i++) {
        this.hours.push(i)
      }
    },
    handleClickOutside(evt) {
      if (!this.$el.contains(evt.target)) {
        this.dropdownOpen = false;
      }
    },
    calculateMinutesList() {
      for (let i = 0; i < 60; i++) {
        this.mins.push(i)
      }
    },
    selectHour(h) {
      console.log(h);
      this.selectedHour = h;
    },
    selectMin(m) {
      console.log(m);
      this.selectedMin = m;
    },
    openDropdown() {
      this.dropdownOpen = true;
    },
  }
};
</script>

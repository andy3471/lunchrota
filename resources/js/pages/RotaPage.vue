<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div
        v-if="rolesEnabled"
        class="col-lg-4 order-lg-1"
      >
        <role-selector :date="date" />
      </div>

      <div
        v-if="rolesEnabled"
        class="col-lg-4 order-lg-2"
      >
        <date-picker
          v-model="date"
          color="#fec107"
        />
      </div>

      <div class="col-lg-4 order-lg-3">
        <lunches-selector
          :lunch-slots="lunchSlots"
          :logged-in="loggedIn"
          :initial-lunch="initialLunch"
          :available="available"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        lunchSlots: {
            default () {
                return [];
            },
            type: Array
        },
        loggedIn: {
            default: false,
            type: Boolean
        },
        rolesEnabled: {
            type: Boolean,
            default: false
        },
        initialLunch: {
            type: Number,
            default: null
        },
        available: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            date: new Date()
        };
    }
};
</script>

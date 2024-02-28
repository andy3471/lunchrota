<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div
        v-if="rolesenabled"
        class="col-lg-4 order-lg-1"
      >
        <role-selector :date="date" />
      </div>

      <div
        v-if="rolesenabled"
        class="col-lg-4 order-lg-2"
      >
        <date-picker
          v-model="date"
          color="#fec107"
        />
      </div>

      <div class="col-lg-4 order-lg-3">
        <lunches-selector
          :lunchslots="lunchslots"
          :loggedin="loggedin"
          :initiallunch="initiallunch"
          :available="available"
          :appdel="appdel"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        lunchslots: {
            default () {
                return [];
            },
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
        initiallunch: {
            type: Number,
            default: null
        },
        appdel: {
            type: Boolean,
            default: false
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
    },
    mounted() {},
    methods: {
    }
};
</script>

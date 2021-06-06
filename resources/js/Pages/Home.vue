<template>
  <main-layout>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-4 order-lg-1" v-if="$page.props.config.roles_enabled">
          <roles :date="date"></roles>
        </div>
        <div class="col-lg-4 order-lg-2" v-if="$page.props.config.roles_enabled">
          <date-picker
            v-model="date"
            :color="$page.props.config.accent_color"
          ></date-picker>
        </div>
        <div class="col-lg-4 order-lg-3">
          <lunches
            :lunchslots="lunchslots"
            :loggedin="$page.props.auth.logged_in"
            :initiallunch="$page.props.config.initiallunch"
            :available="available"
            :appdel="appdel"
          ></lunches>
        </div>
      </div>
    </div>
  </main-layout>
</template>

<script>
import MainLayout from '../Layouts/MainLayout'

export default {
  components: { MainLayout },
  props: {
    lunchslots: {
      type: Array
    },
    loggedin: {
      default: false,
      type: Boolean
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
  data () {
    return {
      date: new Date()
    }
  },
  mounted () {},
  methods: {
  }
}
</script>

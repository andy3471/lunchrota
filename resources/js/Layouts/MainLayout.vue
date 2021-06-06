<template>
  <div :style="cssVars">
    <nav-bar />
    <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark" :style="style">
      <template #lead>
        <h1>
          {{ $page.props.config.name }}
        </h1>
        <h6 v-if="$page.props.config.support_code">
          <a>
            {{ $page.props.dsp_today.code }} |
          </a>
          <a v-if="$page.props.dsp_today.password">
            {{  $page.props.dsp_today.password }} |
          </a>
          <a v-if="$page.props.dsp_today.password2">
            {{  $page.props.dsp_today.password2 }}
          </a>
        </h6>
        <h6 v-if="$page.props.config.app_del_enabled && ($page.props.appdels_today.length > 0)">
          App Del Today:
          <a v-for="(appdel, index) in $page.props.appdels_today" :key="index">
            {{ nameWithComma(index) }}
          </a>
        </h6>
      </template>
    </b-jumbotron>
    <main class="py-4">
      <slot></slot>
    </main>
  </div>
</template>
<script>
import NavBar from '../Components/Layout/NavBar'

export default {
  components: { NavBar },
  computed: {
    style () {
      return 'background-color: ' + this.$page.props.config.accent_color + ' !important'
    }
  },
  methods: {
    makeToast (variant, title, content) {
      this.$bvToast.toast(content, {
        title: title,
        variant: variant,
        solid: true
      })
    },
    cssVars () {
      return {
        '--color': this.$page.props.config.accent_color
      }
    },
    nameWithComma (index) {
      console.log(index)
      if (index !== this.$page.props.appdels_today.length - 1) {
        return `${this.$page.props.appdels_today[index].name},`
      } else {
        return this.$page.props.appdels_today[index].name
      }
    }
  },
  mounted () {
    this.makeToast('success', 'Success', this.$page.props.flash.messages)
  }
}
</script>
<style scoped lang="scss">
$color: var(--color);

.jumbotron {
    //background-color: $color !important;
    border: none !important;
    border-bottom: 1px solid #dee2e6 !important;
    padding: 2em;
    margin-bottom: 0px;
}
</style>

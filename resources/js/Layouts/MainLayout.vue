<template>
    <div :style="cssVars">
        <nav-bar />
        <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark" :style="style">
            <template #lead>
                <h1>
                    {{ $page.props.config.name }}
                </h1>
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

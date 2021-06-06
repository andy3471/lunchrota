<template>
  <div>
    <inertia-link :href="href" class="dropdown-item">
      <slot />
    </inertia-link>
  </div>
</template>
<script>
export default {
  props: {
    href: {
      type: String
    }
  }
}
</script>

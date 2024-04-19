<script setup lang="ts">
const props = defineProps<{ class?: string }>()
</script>

<template>
  <div :class="props.class">
    <img :class="props.class" src="/bghmc-square-200.png" alt="BGHMC round logo" />
  </div>
</template>

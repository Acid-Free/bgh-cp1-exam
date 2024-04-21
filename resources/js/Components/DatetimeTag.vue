<script setup lang="ts">
const props = defineProps<{ date?: string; time?: string }>()
</script>

<template>
  <div class="flex w-fit items-end gap-2 rounded-md bg-gray-50 p-1">
    <span class="text-sm font-medium">{{ date }}</span>
    <span class="text-xs">{{ time }}</span>
  </div>
</template>

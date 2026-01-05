<script setup lang="ts">
// No specific logic needed for this simple display block
</script>

<template>
  <div class="my-custom-block p-4 bg-blue-100 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-blue-800">
      テーマ側ブロック（editor）
    </h2>
    <p class="text-gray-700 mt-2">
      <slot />
    </p>
  </div>
</template>

<style scoped>
/* Component specific styles can go here if needed, but UnoCSS handles most. */
</style>

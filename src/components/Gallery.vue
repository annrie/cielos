<script setup lang="ts">
import { computed } from 'vue'

interface GalleryImage {
  id: number
  src: string
  width: number
  height: number
  full_src: string
  caption: string
  alt: string
  orientation: string
  link: string
}

const props = defineProps<{
  galleryData: GalleryImage[]
  columnsSmall: number
  columnsMedium: number
  columns: number
}>()

const gridClasses = computed(() => {
  return `grid grid-cols-${props.columnsSmall} md:grid-cols-${props.columnsMedium} lg:grid-cols-${props.columns} gap-4`
})
</script>

<template>
  <div :class="gridClasses">
    <div v-for="image in galleryData" :key="image.id" class="flex flex-col items-center">
      <a :href="image.full_src" target="_blank" rel="noopener noreferrer" class="block w-full">
        <img
          :src="image.src"
          :alt="image.alt"
          :width="image.width"
          :height="image.height"
          class="w-full h-auto rounded-lg shadow-md" :class="[image.orientation === 'portrait' ? 'object-contain' : 'object-cover']"
        >
      </a>
      <p v-if="image.caption" class="mt-2 text-sm text-[var(--c-muted)] text-center">
        {{ image.caption }}
      </p>
    </div>
  </div>
</template>

<style scoped>
/* Add any component-specific styles here if needed. */
</style>

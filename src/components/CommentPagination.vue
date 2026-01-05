<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
  currentPage: number
  totalPages: number
  links: string[]
}>()

const processedLinks = computed(() => {
  return props.links.map((link) => {
    const parser = new DOMParser()
    const doc = parser.parseFromString(link, 'text/html')
    const aTag = doc.querySelector('a')
    const spanTag = doc.querySelector('span')

    if (aTag) {
      return {
        text: aTag.textContent,
        href: aTag.getAttribute('href'),
        isCurrent: false,
        isDisabled: false,
        isEllipsis: false,
        isPrevNext: aTag.classList.contains('prev') || aTag.classList.contains('next'),
      }
    }
    else if (spanTag) {
      return {
        text: spanTag.textContent,
        href: null,
        isCurrent: spanTag.classList.contains('current'),
        isDisabled: spanTag.classList.contains('dots'),
        isEllipsis: spanTag.classList.contains('dots'),
        isPrevNext: false,
      }
    }
    return null
  }).filter(Boolean)
})
</script>

<template>
  <nav v-if="totalPages > 1" aria-label="Comment Pagination" class="pager">
    <template v-for="(link, index) in processedLinks" :key="index">
      <a
        v-if="link && link.href && !link.isCurrent && !link.isDisabled"
        :href="link.href"
        class="pager-link"
      >
        {{ link.text }}
      </a>
      <span
        v-else-if="link && link.isCurrent"
        class="pager-link-current"
        aria-current="page"
      >
        {{ link.text }}
      </span>
      <span
        v-else-if="link && link.isDisabled"
        class="pager-gap"
      >
        {{ link.text }}
      </span>
    </template>
  </nav>
</template>

<style scoped>
/* Add any component-specific styles here if needed. */
</style>

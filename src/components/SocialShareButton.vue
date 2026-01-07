<script setup lang="ts">
import { computed, onMounted } from 'vue'

const props = defineProps<{
  platform: string
  url: string
  title: string
}>()

const shareUrl = computed(() => {
  switch (props.platform) {
    case 'hatena':
      return `http://b.hatena.ne.jp/entry/${encodeURIComponent(props.url)}?title=${encodeURIComponent(props.title)}`
    case 'twitter':
      return `https://twitter.com/intent/tweet?url=${encodeURIComponent(props.url)}&text=${encodeURIComponent(props.title)}&via=muraie_jin`
    case 'facebook':
      return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(props.url)}`
    default:
      return '#'
  }
})

const buttonText = computed(() => {
  switch (props.platform) {
    case 'hatena':
      return 'はてなブックマーク'
    case 'twitter':
      return 'ツイート'
    case 'facebook':
      return 'シェア'
    default:
      return 'Share'
  }
})

const buttonClass = computed(() => {
  switch (props.platform) {
    case 'hatena':
      return 'bg-blue-600 hover:bg-blue-700'
    case 'twitter':
      return 'bg-blue-400 hover:bg-blue-500'
    case 'facebook':
      return 'bg-blue-800 hover:bg-blue-900'
    default:
      return 'bg-[var(--c-muted)] hover:bg-[var(--c-fg)]'
  }
})

onMounted(() => {
  // Dynamically load external scripts if necessary
  // For Hatena, Twitter, Facebook, their share buttons often work with just a link.
  // If specific widgets are needed, their scripts would be loaded here.
  // Example for Twitter: if (props.platform === 'twitter' && !document.getElementById('twitter-wjs')) {
  //   const script = document.createElement('script');
  //   script.id = 'twitter-wjs';
  //   script.src = 'https://platform.twitter.com/widgets.js';
  //   document.head.appendChild(script);
  // }
})
</script>

<template>
  <a
    :href="shareUrl"
    target="_blank"
    rel="noopener noreferrer"
    class="inline-flex items-center justify-center px-4 py-2 rounded-md text-white font-semibold shadow-md" :class="[buttonClass]"
  >
    <i v-if="platform === 'hatena'" class="i-logos-hatena-bookmark" />
    <i v-else-if="platform === 'twitter'" class="i-logos-twitter" />
    <i v-else-if="platform === 'facebook'" class="i-logos-facebook" />
    <span class="ml-2">{{ buttonText }}</span>
  </a>
</template>

<style scoped>
/* Add any component-specific styles here if needed. */
</style>

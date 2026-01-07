<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

const showButton = ref(false)

function handleScroll() {
  showButton.value = window.scrollY > 200 // Show button after scrolling 200px
}

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
  <transition name="fade">
    <button
      v-if="showButton"
      class="fixed bottom-4 right-4 w-12 h-12 flex-center rounded-full bg-[var(--c-primary)] text-white shadow-lg dark:shadow-xl hover:bg-[var(--c-primary-dark)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] focus:ring-opacity-75 z-50"
      aria-label="トップへ戻る"
      @click="scrollToTop"
    >
      <i class="fas fa-arrow-up" />
    </button>
  </transition>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

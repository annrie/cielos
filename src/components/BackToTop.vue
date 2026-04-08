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
  handleScroll()
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
      class="back-to-top-btn fixed bottom-4 right-4 w-12 h-12 flex-center rounded-full bg-[var(--c-primary)] text-white shadow-lg dark:shadow-xl hover:bg-[var(--c-primary-dark)] focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] focus:ring-opacity-75 z-[70]"
      aria-label="トップへ戻る"
      @click="scrollToTop"
    >
      <svg
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
        style="display:block;width:35px;height:35px;max-width:none;max-height:none;min-width:35px;min-height:35px;flex:0 0 35px;"
      >
        <path
          d="M12 5L6 11M12 5L18 11M12 5V19"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
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

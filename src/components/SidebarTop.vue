<script setup lang="ts">
interface Post {
  date: string
  formatted_date: string
  title: string
  permalink: string
  excerpt: string
  thumbnail_url: string
  thumbnail_alt: string
  thumbnail_title: string
}

interface SidebarCategory {
  category_slug: string
  category_name: string
  category_link: string
  posts: Post[]
}

const props = defineProps<{
  sidebarData: SidebarCategory[]
}>()
</script>

<template>
  <div
    v-for="category in props.sidebarData" :id="`${category.category_slug}-info`" :key="category.category_slug"
    class="news-list p-4 mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg"
  >
    <h2 class="text-xl font-bold mb-4 pb-2 border-b-2 border-gray-200 dark:border-gray-700 dark:text-white">
      {{ category.category_name }}
    </h2>
    <!--div class="info-wrap info-wrap-style"-->
      <div
        v-for="post in category.posts" :key="post.permalink"
        class="info-wrap info-wrap-style p-3 mb-4 border border-gray-200 dark:border-gray-700 rounded-md"
      >
        <!-- Date -->
        <time class="entry-date text-sm text-gray-600 dark:text-gray-400 block mb-1" :datetime="post.date">{{ post.formatted_date }}</time>
        <!-- Title -->
        <h3 class="text-lg font-semibold leading-tight w-full mb-2">
          <a :href="post.permalink" class="dark:text-white" v-html="post.title" />
        </h3>
        <!-- Excerpt and Thumbnail Container -->
        <div class="flex items-start gap-4">
          <!-- Thumbnail -->
          <div class="flex-shrink-0 w-24 h-24 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
            <a :href="post.permalink">
              <img
                v-if="post.thumbnail_url" :src="post.thumbnail_url" :alt="post.thumbnail_alt"
                :title="post.thumbnail_title" class="w-full h-full object-cover"
              >
              <div v-else class="w-full h-full flex items-center justify-center">
                <i class="i-carbon-image text-gray-400 dark:text-gray-500 text-2xl" />
              </div>
            </a>
          </div>
          <!-- Excerpt -->
          <div class="text-sm text-gray-700 dark:text-gray-300 flex-grow" v-html="post.excerpt" />
        </div>
      </div>
    <!--/div-->
    <div class="text-right mt-4">
      <span class="link-text link-text-style">
        <a :href="category.category_link" class="link-text-button-style">
          <i class="i-fa6-solid-arrow-right mr-1" /> {{ category.category_name }}一覧
        </a>
      </span>
    </div>
  </div>
</template>

<style scoped>
/* Add any component-specific styles here if needed, though UnoCSS should handle most. */
</style>

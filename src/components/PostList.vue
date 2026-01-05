<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref, watch } from 'vue'

const props = withDefaults(defineProps<{
  page?: number
  showTitle?: boolean
  layout?: 'grid' | 'list'
  termId?: string
  termType?: string
}>(), {
  page: 1,
  showTitle: true,
  layout: 'grid',
  termId: '',
  termType: '',
})

interface Post {
  id: number
  link: string
  title: { rendered: string }
  date: string
  modified: string
  excerpt: { rendered: string }
  featured_media_url?: string
  formatted_date?: string
  formatted_modified?: string
  categories?: Array<{ name: string; link: string }>
  tags?: Array<{ name: string; link: string }>
}

const posts = ref<Post[]>([])
const blogCategoryLink = ref('/archives/category/blog/') // Set a static link

async function fetchPosts(page: number = 1) {
  try {
    // APIパラメータを構築
    const params: Record<string, any> = {
      _embed: 'wp:featuredmedia,wp:term',
      per_page: 10,
      page,
    }

    // termId と termType に基づいてフィルタリング
    if (props.termId && props.termType) {
      if (props.termType === 'category') {
        params.categories = props.termId
      } else if (props.termType === 'tag') {
        params.tags = props.termId
      }
      // 他のカスタムタクソノミーは別途対応が必要
    } else {
      // デフォルト: フロントページ用（コラム、備忘録）
      params.categories = '3,5'
    }

    const response = await axios.get<Post[]>('/wp-json/wp/v2/posts', { params })

    posts.value = response.data.map((post) => {
      const excerptHtml = post.excerpt.rendered
      const excerptText = excerptHtml ? excerptHtml.replace(/<[^>]+>/g, '') : ''
      const limit = 60
      const truncatedExcerpt = excerptText.length > limit
        ? `${excerptText.substring(0, limit)}...`
        : excerptText

      // カテゴリとタグを抽出
      const categories = post._embedded?.['wp:term']?.[0]?.map((term: any) => ({
        name: term.name,
        link: term.link,
      })) || []

      const tags = post._embedded?.['wp:term']?.[1]?.map((term: any) => ({
        name: term.name,
        link: term.link,
      })) || []

      return {
        id: post.id,
        link: post.link,
        title: post.title,
        date: post.date,
        modified: (post as any).modified,
        excerpt: { rendered: truncatedExcerpt },
        featured_media_url: post._embedded?.['wp:featuredmedia']?.[0]?.source_url,
        formatted_date: (post as any).formatted_date,
        formatted_modified: (post as any).formatted_modified,
        categories,
        tags,
      }
    })
  }
  catch (error) {
    console.error('Error fetching posts:', error)
  }
}

function formatDate(dateString: string) {
  const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(dateString).toLocaleDateString(undefined, options)
}

onMounted(() => {
  fetchPosts(props.page)
})

watch(() => props.page, (newPage) => {
  fetchPosts(newPage)
})
</script>

<template>
  <div>
    <!-- タイトルセクション（showTitle が true の場合のみ表示） -->
    <div v-if="showTitle" class="flex justify-between items-center latest-columns-title-style mb-10">
      <h2 id="latest-columns-title">
        <a :href="blogCategoryLink" class="block text-inherit no-underline">
          <i class="fas fa-edit fa-lg mr-3" aria-hidden="true" />新着コラム
        </a>
      </h2>
      <span class="hidden sm:block">
        <a :href="blogCategoryLink" class="text-sm archive-link-button-style">
          <i class="fas fa-arrow-right" />コラム一覧
        </a>
      </span>
    </div>

    <!-- グリッドレイアウト -->
    <div v-if="layout === 'grid'" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <article v-for="post in posts" :key="post.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800">
        <h3 class="update-title !text-2xl">
          <a :href="post.link" :title="post.title.rendered" class="dark:text-white no-underline">
            {{ post.title.rendered }}
          </a>
        </h3>
        <time class="entry-date dark:text-gray-400" :datetime="post.date.split('T')[0]">
          {{ post.formatted_date }}
        </time>
        <div class="grid grid-cols-12 gap-x-4">
          <div class="col-span-12 lg:col-span-6 flex justify-center">
            <a v-if="post.featured_media_url" :href="post.link">
              <figure class="w-full">
                <img :src="post.featured_media_url" :alt="post.title.rendered" :title="post.title.rendered" class="w-full h-auto rounded-md border border-gray-200 dark:border-gray-700" loading="lazy" decoding="async">
              </figure>
            </a>
          </div>
          <div class="col-span-12 lg:col-span-6 flex flex-col">
            <div class="dark:text-gray-300" v-html="post.excerpt.rendered" />
            <span class="mt-auto self-end">
              <a :href="post.link" class="dark:text-blue-400">
                <i class="fas fa-arrow-right" /> 続きを読む
              </a>
            </span>
          </div>
        </div>
      </article>
    </div>

    <!-- リストレイアウト（1カラム、横並び） -->
    <div v-else class="mt-6">
      <article v-for="post in posts" :key="post.id" class="mb-8 last:mb-0 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 overflow-hidden">
        <div class="flex flex-col lg:flex-row">
          <!-- サムネイル（モバイル:上、デスクトップ:左） -->
          <div class="w-full lg:w-1/4 flex-shrink-0">
            <a v-if="post.featured_media_url" :href="post.link" class="block">
              <img
                :src="post.featured_media_url"
                :alt="post.title.rendered"
                :title="post.title.rendered"
                class="w-full h-48 lg:h-full object-cover"
                loading="lazy" decoding="async"
              >
            </a>
          </div>

          <!-- コンテンツ（モバイル:下、デスクトップ:右） -->
          <div class="flex-1 p-6">
            <h3 class="text-xl font-bold mb-2">
              <a :href="post.link" :title="post.title.rendered" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                {{ post.title.rendered }}
              </a>
            </h3>

            <!-- 作成日・修正日 -->
            <div class="flex flex-col lg:flex-row lg:gap-4 gap-1 text-sm text-gray-600 dark:text-gray-400 mb-3">
              <div class="flex items-center gap-2">
                <i class="fas fa-calendar-plus" aria-hidden="true" />
                <time :datetime="post.date.split('T')[0]">{{ post.formatted_date || formatDate(post.date) }}</time>
              </div>
              <div v-if="post.modified && post.modified !== post.date" class="flex items-center gap-2">
                <i class="fas fa-calendar-check" aria-hidden="true" />
                <time :datetime="post.modified.split('T')[0]">{{ post.formatted_modified || formatDate(post.modified) }}</time>
              </div>
            </div>

            <div class="text-gray-700 dark:text-gray-300 mb-4" v-html="post.excerpt.rendered" />

            <!-- カテゴリ・タグ -->
            <div class="mb-4 space-y-2">
              <div v-if="post.categories && post.categories.length > 0" class="flex items-center gap-2 flex-wrap">
                <i class="fas fa-folder text-gray-500" aria-hidden="true" />
                <a
                  v-for="category in post.categories"
                  :key="category.name"
                  :href="category.link"
                  class="inline-block px-2 py-1 text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-600"
                >
                  {{ category.name }}
                </a>
              </div>
              <div v-if="post.tags && post.tags.length > 0" class="flex items-center gap-2 flex-wrap">
                <i class="fas fa-tags text-gray-500" aria-hidden="true" />
                <a
                  v-for="tag in post.tags"
                  :key="tag.name"
                  :href="tag.link"
                  class="inline-block px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded hover:bg-blue-200 dark:hover:bg-blue-800"
                >
                  {{ tag.name }}
                </a>
              </div>
            </div>

            <div class="flex justify-end">
              <a :href="post.link" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 dark:bg-blue-400 text-white dark:text-gray-900 rounded hover:bg-blue-700 hover:text-white dark:hover:bg-blue-500 dark:hover:text-white transition-colors text-sm font-medium">
                続きを読む
                <i class="fas fa-arrow-right" aria-hidden="true" />
              </a>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<style scoped>
/* ここにPostListコンポーネント固有のスタイルを追加 */
</style>

<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref } from 'vue'

interface Post {
  id: number
  link: string
  title: { rendered: string }
  excerpt: { rendered: string }
  featured_media_url?: string
}

const posts = ref<Post[]>([])

// ジャンル固有の色マッピング（ページIDベース）
const genreColors: Record<number, string> = {
  2412: 'rgba(77, 28, 255, 0.85)',    // SF
  2414: 'rgba(153, 102, 153, 0.85)',  // 冒険・サスペンス
  2416: 'rgba(237, 24, 30, 0.85)',    // ミステリー
  2418: 'rgba(47, 139, 32, 0.85)',    // 時代・伝奇
  2544: 'rgba(0, 0, 0, 0.85)',        // ホラー・奇妙な味
  2805: 'rgba(14, 165, 233, 0.85)',   // 短編・連作集
}

function getGenreColor(postId: number): string {
  return genreColors[postId] || 'rgba(100, 116, 139, 0.85)' // デフォルト: slate-500
}

async function fetchPosts() {
  try {
    const response = await axios.get<Post[]>('/wp-json/wp/v2/pages', {
      params: {
        _embed: 'wp:featuredmedia',
        parent: 2410,
        per_page: 10,
        orderby: 'menu_order',
        order: 'asc',
      },
    })

    //    console.log('Machaki Pickup API Response:', response.data);

    posts.value = response.data.map(post => ({
      id: post.id,
      link: post.link,
      title: post.title,
      excerpt: post.excerpt,
      featured_media_url: post.featured_image_url,
    }))
  }
  catch (error) {
    console.error('Error fetching posts:', error)
  }
}

onMounted(() => {
  fetchPosts()
})
</script>

<template>
    <div class="flex justify-between items-center machaki-group-title-style mb-10">
      <h2 id="machaki-group-title" class="m-0">
<a href="/machaki/" id="machaki-title-link" class="no-underline">
<i class="fas fa-university fa-lg mr-2" aria-hidden="true" />僭越図書館<span class="hidden lg:inline"> - 山田正紀 Bibliography</span>
        </a>
      </h2>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <article v-for="post in posts" :key="post.id" class="p-0 lg:p-4 border border-gray-200 dark:border-gray-700 rounded-lg flex flex-col bg-white dark:bg-gray-800 overflow-hidden">
        <!-- デスクトップ用タイトル（モバイルでは非表示） -->
        <h3 class="hidden lg:block sub-title font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-2">
          <a :href="post.link" class="text-2xl dark:text-white no-underline"><i class="fas fa-leaf fa-sm mr-2" />{{ post.title.rendered }}</a>
        </h3>
        <div class="flex-grow">
          <a :href="post.link" class="block relative">
            <!-- 画像コンテナ -->
            <figure class="mb-0 lg:mb-2 relative">
              <img :src="post.featured_media_url || '/wp-content/themes/cielos/public/images/noimg.png'" :alt="post.title.rendered" :title="post.title.rendered" class="rounded-none lg:rounded-md h-48 w-full object-cover" loading="lazy" decoding="async">
              <!-- モバイル用オーバーレイタイトル -->
              <span
                class="lg:hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-6 py-3 text-white font-bold text-2xl rounded-full whitespace-nowrap shadow-lg"
                :style="{ backgroundColor: getGenreColor(post.id) }"
              >
                {{ post.title.rendered }}
              </span>
            </figure>
          </a>
          <p class="text-sm dark:text-gray-300 px-4 lg:px-0 py-2 lg:py-0" v-html="post.excerpt.rendered" />
        </div>
        <div class="text-right mt-auto px-4 pb-4 lg:px-0 lg:pb-0">
          <a :href="post.link" class="dark:text-blue-400"><i class="fas fa-space-shuttle" /> 詳しく見る</a>
        </div>
      </article>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

/**
 * Pagination.vue
 * - "次" ボタンが /page/41 になる問題を根治（必ず数値化して加算）
 * - 1ページ目も /page/1/ を維持（カテゴリ home.php 用）
 * - 省エネで読みやすい HTML + UnoCSS クラス
 */

const props = withDefaults(defineProps<{
  /** 現在のページ（1始まり）。文字列で来てもOK */
  currentPage: number | string
  /** 総ページ数（1以上） */
  totalPages: number
  /** ページURLのひな型。例: '/category/news/page/%#%/' （必ず '%#%' を含める） */
  base: string
  /** 現在ページの前後に表示するページ数 */
  around?: number
  /** 先頭/末尾付近に常に表示するページ数 */
  edges?: number
  /** 最初/最後ボタンを表示するか */
  showFirstLast?: boolean
  /** 前へ/次へボタンを表示するか */
  showPrevNext?: boolean
  /** <nav> の aria-label */
  ariaLabel?: string
  /** 1ページ目だけ基底URLに戻すか（falseで /page/1 を使わない） */
  keepPageOne?: boolean
}>(), {
  around: 2,
  edges: 1,
  showFirstLast: true,
  showPrevNext: true,
  ariaLabel: 'Pagination',
  keepPageOne: true,
})

/** 指定ページのURLを返す（1ページ目も /page/1/ を維持。上記keepPageOneで調整） */
function pageUrl(n: number | string) {
  const page = Number(n)
  if (page <= 1 && !props.keepPageOne) {
    // よくある WordPress 形式: '/.../page/%#%/' → 基底へ
    if (props.base.includes('page/%#%/'))
      return props.base.replace('page/%#%/', '')
    if (props.base.includes('page/%#%'))
      return props.base.replace('page/%#%', '')
    // 最後の保険
    return props.base.replace('%#%', '')
  }
  return props.base.replace('%#%', String(page))
}

/** 現在ページ（計算用に数値化） */
const cur = computed(() => {
  const n = Number(props.currentPage)
  if (Number.isNaN(n) || n < 1)
    return 1
  if (props.totalPages && n > props.totalPages)
    return props.totalPages
  return n
})

const hasPrev = computed(() => cur.value > 1)
const hasNext = computed(() => cur.value < props.totalPages)

const prevHref = computed(() => (hasPrev.value ? pageUrl(cur.value - 1) : ''))
const nextHref = computed(() => (hasNext.value ? pageUrl(cur.value + 1) : ''))

/** 可視ページ配列を生成（省メモリ＆読みやすさ重視） */
const items = computed(() => {
  const total = Math.max(1, Number(props.totalPages || 1))

  // モバイルではさらに省略（画面幅に応じて調整）
  const isMobile = typeof window !== 'undefined' && window.innerWidth < 640
  const around = isMobile ? 1 : Math.max(0, Number(props.around || 0))
  const edges = isMobile ? 1 : Math.max(0, Number(props.edges || 0))

  const set = new Set<number>()
  // 先頭エッジ
  for (let i = 1; i <= Math.min(edges, total); i++) set.add(i)
  // 末尾エッジ
  for (let i = Math.max(1, total - edges + 1); i <= total; i++) set.add(i)
  // 現在ページの前後
  for (let i = Math.max(1, cur.value - around); i <= Math.min(total, cur.value + around); i++) set.add(i)

  const arr = Array.from(set).sort((a, b) => a - b)

  // 間を埋める（離れているところは省略記号）
  type Entry = { type: 'page', n: number, href: string, current: boolean } | { type: 'ellipsis', key: string }
  const out: Entry[] = []
  let prev: number | null = null
  for (const n of arr) {
    if (prev !== null && n - prev > 1)
      out.push({ type: 'ellipsis', key: `gap-${prev}-${n}` })
    out.push({ type: 'page', n, href: pageUrl(n), current: n === cur.value })
    prev = n
  }
  return out
})
</script>

<template>
  <nav v-if="totalPages > 1" :aria-label="ariaLabel" class="w-full">
    <ul class="flex flex-wrap items-center justify-center gap-2 py-4">
      <li v-if="showFirstLast" class="contents">
        <a v-if="cur > 1" :href="pageUrl(1)" aria-label="First page" class="px-3 py-2 rounded-md border border-[var(--c-border)] hover:bg-[var(--c-bg)] transition">«</a>
        <span v-else class="px-3 py-2 rounded-md border border-transparent text-[var(--c-muted)] select-none">«</span>
      </li>

      <li v-if="showPrevNext" class="contents">
        <a v-if="hasPrev" :href="prevHref" aria-label="Previous page" rel="prev" class="px-3 py-2 rounded-md border border-[var(--c-border)] hover:bg-[var(--c-bg)] transition">‹</a>
        <span v-else class="px-3 py-2 rounded-md border border-transparent text-[var(--c-muted)] select-none">‹</span>
      </li>

      <li v-for="it in items" :key="it.type === 'ellipsis' ? it.key : `p-${it.n}`">
        <template v-if="it.type === 'ellipsis'">
          <span class="px-2 text-[var(--c-muted)] select-none">…</span>
        </template>
        <template v-else>
          <a v-if="!it.current" :href="it.href" class="min-w-[2.25rem] text-center px-3 py-2 rounded-md border border-[var(--c-border)] hover:bg-[var(--c-bg)] transition">{{ it.n }}</a>
          <span v-else aria-current="page" class="min-w-[2.25rem] text-center px-3 py-2 rounded-md bg-[var(--c-fg)] text-[var(--c-fg-inv)] border border-[var(--c-fg)]">{{ it.n }}</span>
        </template>
      </li>

      <li v-if="showPrevNext" class="contents">
        <a v-if="hasNext" :href="nextHref" aria-label="Next page" rel="next" class="px-3 py-2 rounded-md border border-[var(--c-border)] hover:bg-[var(--c-bg)] transition">›</a>
        <span v-else class="px-3 py-2 rounded-md border border-transparent text-[var(--c-muted)] select-none">›</span>
      </li>

      <li v-if="showFirstLast" class="contents">
        <a v-if="cur < totalPages" :href="pageUrl(totalPages)" aria-label="Last page" class="px-3 py-2 rounded-md border border-[var(--c-border)] hover:bg-[var(--c-bg)] transition">»</a>
        <span v-else class="px-3 py-2 rounded-md border border-transparent text-[var(--c-muted)] select-none">»</span>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
/* モバイルでも押しやすいように最小幅を確保 */
</style>

import { createApp } from 'vue'
import App from './App.vue'
import BackToTop from './components/BackToTop.vue'
import CommentPagination from './components/CommentPagination.vue'
import Gallery from './components/Gallery.vue'
import Pagination from './components/Pagination.vue'
import PostList from './components/PostList.vue'
import SidebarBooks from './components/SidebarBooks.vue'
import SidebarFull from './components/SidebarFull.vue'
import SidebarTop from './components/SidebarTop.vue'
import SocialShareButton from './components/SocialShareButton.vue'
import SvgImage from './components/SvgImage.vue'
// Hero Showcase Components
import HeroAuroraWave from './components/hero/HeroAuroraWave.vue'
import HeroCinematic from './components/hero/HeroCinematic.vue'
import HeroGeometric from './components/hero/HeroGeometric.vue'
import HeroGlassmorphism from './components/hero/HeroGlassmorphism.vue'
import HeroGradientMesh from './components/hero/HeroGradientMesh.vue'
import HeroInteractiveCards from './components/hero/HeroInteractiveCards.vue'
import HeroMinimalZen from './components/hero/HeroMinimalZen.vue'
import HeroParallaxLayers from './components/hero/HeroParallaxLayers.vue'
import HeroScrollReveal from './components/hero/HeroScrollReveal.vue'
import HeroSplitDiagonal from './components/hero/HeroSplitDiagonal.vue'
import HeroTypography from './components/hero/HeroTypography.vue'

import 'virtual:uno.css'
import 'animate.css'
import './assets/css/index.css'
// Vanilla JS utilities (side-effect imports)
import './assets/js/lang-tabs.js'
import './assets/js/sidebar-icons.js'
// 開発時のみ UnoCSS DevTools を読み込む
if (import.meta.env.DEV) {
  // @ts-ignore
  import('virtual:unocss-devtools')
}
// if (import.meta.env.DEV) {
//  // @ts-ignore
//  import('virtual:unocss-devtools')
// }

// === [UNOMoon SVG Common Utils] BEGIN ======================================
export const isProd = import.meta.env.PROD
// eslint-disable-next-line @typescript-eslint/no-unused-vars
export function log(..._a: any[]) {
  // Debug logging disabled in production build
}

// Shadow DOM に安全にマウント（影DOMでレガシー上書きを無効化）
export function getMountPoint(host: HTMLElement): HTMLElement {
  // 既に shadowRoot があれば再利用
  const shadow = host.shadowRoot || host.attachShadow?.({ mode: 'open' })
  if (shadow) {
    // host 直下のゴミを隠す
    host.textContent = ''
    // 一度だけスタイル注入
    if (!shadow.querySelector('style[data-cielos]')) {
      const s = document.createElement('style')
      s.setAttribute('data-cielos', '')
      s.textContent = `:host{display:block}`
      shadow.appendChild(s)
    }
    // マウント用 div を確保
    let mount = shadow.querySelector<HTMLElement>('div[data-cielos-mount]')
    if (!mount) {
      mount = document.createElement('div')
      mount.setAttribute('data-cielos-mount', '')
      shadow.appendChild(mount)
    }
    return mount
  }
  // fallback: 通常DOM（必要なら）
  return host
}

// /wp/v2/media の結果を使い回す簡易キャッシュ
const mediaCache = new Map<number, Promise<string>>()
export function lookupMediaSourceUrl(id: number): Promise<string> {
  if (!mediaCache.has(id)) {
    const url = withBust(`/wp-json/wp/v2/media/${id}`)
    log('[SVG] lookup media:', url)
    mediaCache.set(
      id,
      fetch(url, { credentials: 'same-origin', cache: isProd ? 'default' : 'no-store' })
        .then((r) => {
          log('[SVG] media response', r.status, r.statusText)
          if (!r.ok)
            throw new Error(`media ${r.status}`)
          return r.json()
        })
        .then((j) => {
          const src = j?.source_url || ''
          if (!src)
            throw new Error('media source_url not found')
          log('[SVG] media source_url', src)
          return src
        }),
    )
  }
  return mediaCache.get(id)!
}
// === [UNOMoon SVG Common Utils] END ========================================

// Vueアプリを作成
const app = createApp(App)

// （開発中だけ）URLにキャッシュバスターを付与
export function withBust(url: string): string {
  if (isProd)
    return url
  return url.includes('?') ? `${url}&_=${Date.now()}` : `${url}?_=${Date.now()}`
}

type Mode = 'inline' | 'background'

export async function mountSvg(hostEl: HTMLElement) {
  // 影DOMのマウントポイントを確保
  const mountEl = getMountPoint(hostEl)

  // data-* を拾う（class は .vue-svg-image）
  const srcAttr = (hostEl.getAttribute('data-src') || '').trim()
  const idAttr = hostEl.getAttribute('data-id')
  const id = idAttr ? Number.parseInt(idAttr, 10) : Number.NaN
  const mode = (hostEl.getAttribute('data-mode') as Mode) || 'inline'
  const fit = (hostEl.getAttribute('data-fit') as 'contain' | 'cover' | 'auto') || undefined
  const position = hostEl.getAttribute('data-position') || undefined
  const repeat = (hostEl.getAttribute('data-repeat') as any) || undefined

  try {
    // A/C: data-src があればそのまま
    if (srcAttr) {
      log('[SVG] route=A: data-src directly', { src: srcAttr, el: hostEl })
      hostEl.setAttribute('data-svg-route', 'data-src')
      const src = withBust(srcAttr)
      createApp(SvgImage, { src, mode, fit, position, repeat }).mount(mountEl)
      return
    }

    // B/D: data-id → /wp/v2/media から source_url を解決して直URLで描画
    if (!Number.isNaN(id)) {
      log('[SVG] route=B: lookup media', { id, el: hostEl })
      hostEl.setAttribute('data-svg-route', 'media-src')
      const fileUrl = await lookupMediaSourceUrl(id)
      const src = withBust(fileUrl)
      createApp(SvgImage, { src, mode, fit, position, repeat }).mount(mountEl)
      return
    }

    // どちらも無い
    hostEl.setAttribute('data-svg-route', 'none')
    mountEl.textContent = 'SVG load error: no src/id'
  }
  catch (e) {
    console.error('[SVG] mount failed', e)
    mountEl.textContent = 'SVG load error'
  }
}
// === [UNOMoon SVG Mount] END ===============================================

// === [UNOMoon SVG Boot] BEGIN ==============================================
function boot() {
  document.querySelectorAll<HTMLElement>('.vue-svg-image').forEach((el) => {
    // 重複マウント防止
    if (el.hasAttribute('data-vue-mounted'))
      return
    el.setAttribute('data-vue-mounted', '1')
    // 非同期でもOK
    Promise.resolve().then(() => mountSvg(el))
  })
}
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', boot)
}
else {
  boot()
}
// === [UNOMoon SVG Boot] END ================================================

// Mount CommentPagination component if data is available
const commentPaginationEl = document.getElementById('cielos-comment-pagination')
if (commentPaginationEl && typeof window.cielosCommentPagination !== 'undefined') {
  createApp(CommentPagination, {
    currentPage: window.cielosCommentPagination.currentPage,
    totalPages: window.cielosCommentPagination.totalPages,
    links: window.cielosCommentPagination.links,
  }).mount(commentPaginationEl)
}

// Mount Gallery components
document.querySelectorAll('div[id^="cielos-gallery-"]').forEach((el) => {
  const galleryData = JSON.parse(el.dataset.galleryData || '[]')
  const columnsSmall = Number.parseInt(el.dataset.columnsSmall || '2')
  const columnsMedium = Number.parseInt(el.dataset.columnsMedium || '4')
  const columns = Number.parseInt(el.dataset.columns || '3')

  createApp(Gallery, {
    galleryData,
    columnsSmall,
    columnsMedium,
    columns,
  }).mount(el)
})

// Mount BackToTop component
createApp(BackToTop).mount('#cielos-back-to-top')

// Mount SocialShareButton components
document.querySelectorAll('.cielos-social-share-button').forEach((el) => {
  const platform = el.dataset.platform || ''
  const url = el.dataset.url || ''
  const title = el.dataset.title || ''

  createApp(SocialShareButton, {
    platform,
    url,
    title,
  }).mount(el)
})

// Mount PostList component
const postListElement = document.getElementById('post-list-app')
if (postListElement) {
  const page = Number.parseInt(window.cielosPagination?.currentPage || '1')
  const showTitle = postListElement.dataset.showTitle !== 'false' // デフォルト true
  const layout = (postListElement.dataset.layout as 'grid' | 'list') || 'grid' // デフォルト grid
  const termId = postListElement.dataset.termId || ''
  const termType = postListElement.dataset.termType || ''

  createApp(PostList, {
    page,
    showTitle,
    layout,
    termId,
    termType,
  }).mount(postListElement)
}

// Mount Pagination component
const paginationElement = document.getElementById('pagination-app')
if (paginationElement && typeof window.cielosPagination !== 'undefined') {
  createApp(Pagination, {
    currentPage: window.cielosPagination.currentPage,
    totalPages: window.cielosPagination.totalPages,
    base: window.cielosPagination.base,
  }).mount(paginationElement)
}

// Mount SidebarTop component if data is available
if (typeof window.sidebarTopData !== 'undefined') {
  createApp(SidebarTop, {
    sidebarData: window.sidebarTopData,
  }).mount('#sidebar-top-vue-app')
}

// Mount SidebarFull component
const sidebarFullAppElement = document.getElementById('sidebar-full-vue-app')
if (sidebarFullAppElement) {
  createApp(SidebarFull).mount(sidebarFullAppElement)
}

// Mount SidebarBooks component
const sidebarBooksAppElement = document.getElementById('sidebar-books-vue-app')
if (sidebarBooksAppElement) {
  createApp(SidebarBooks).mount(sidebarBooksAppElement)
}

// Mount SidebarGeneral component if data is available
// if (typeof window.sidebarGeneralData !== 'undefined') {
//  createApp(SidebarGeneral, {
//    sidebarData: window.sidebarGeneralData,
//  }).mount('#sidebar-general-vue-app');
// }

document.addEventListener('DOMContentLoaded', () => {
  // Mobile Menu Toggle - nav-control.jsで処理されるため、ここでは不要

  // Handle external links
  document.querySelectorAll('a[rel="external"], a[rel="nofollow external"], a[rel="external nofollow"]').forEach((anchor) => {
    anchor.setAttribute('target', '_blank')
  })

  // Bibliography page: Fix counter-reset for ol[start]
  const biblioPages = ['post-3136', 'post-4279', 'post-3395', 'post-3467']
  const isBiblioPage = biblioPages.some(id => document.getElementById(id))
  if (isBiblioPage) {
    document.querySelectorAll<HTMLOListElement>('.entry-content ol[start]').forEach((ol) => {
      const startAttr = ol.getAttribute('start')
      if (startAttr) {
        const start = Number.parseInt(startAttr, 10)
        if (!Number.isNaN(start)) {
          ol.style.counterReset = `item ${start - 1}`
        }
      }
    })
  }
})

// removed legacy theme block
;


if ('serviceWorker' in navigator && import.meta.env.DEV) {
  navigator.serviceWorker.getRegistrations().then((regs) => {
    regs.forEach(reg => reg.unregister())
  })
}

// Mount Hero Showcase Components
const heroComponentMap: Record<string, any> = {
  'gradient-mesh': HeroGradientMesh,
  'split-diagonal': HeroSplitDiagonal,
  'glassmorphism': HeroGlassmorphism,
  'typography': HeroTypography,
  'parallax-layers': HeroParallaxLayers,
  'minimal-zen': HeroMinimalZen,
  'interactive-cards': HeroInteractiveCards,
  'cinematic': HeroCinematic,
  'geometric': HeroGeometric,
  'scroll-reveal': HeroScrollReveal,
  'aurora-wave': HeroAuroraWave,
}

document.querySelectorAll<HTMLElement>('.hero-showcase-mount').forEach((el) => {
  const heroType = el.dataset.heroType || ''
  const component = heroComponentMap[heroType]
  if (component) {
    createApp(component, {
      siteName: el.dataset.siteName || '',
      tagline: el.dataset.tagline || '',
      themeUri: el.dataset.themeUri || '',
    }).mount(el)
  }
})


// マウント
app.mount('#app')

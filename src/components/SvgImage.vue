<script setup lang="ts">
import { onMounted, ref } from 'vue'

// ⭐ 追加: mode（'inline' or 'background'）
const props = defineProps<{
  src?: string
  id?: number
  endpoint?: string
  mode?: 'inline' | 'background'
  fit?: 'contain' | 'cover' | 'auto' // 任意: 背景のフィット
  position?: string // 任意: 'center', 'left top' など
  repeat?: 'no-repeat' | 'repeat' | 'repeat-x' | 'repeat-y'
}>()
const svg = ref('')
const error = ref<string | null>(null)

// URL は onMounted の中で決める（src優先、なければ endpoint/id）

function decodeEntities(s: string) {
  const el = document.createElement('textarea')
  el.innerHTML = s
  return el.value
}

function normalizeSvgPayload(txt: string, contentType = ''): string {
  const t = txt.trim()
  if (contentType.toLowerCase().includes('image/svg+xml'))
    return t
  if (/<svg[\s>]/i.test(t))
    return t

  if (t.startsWith('{')) {
    try {
      const j = JSON.parse(t)
      let raw = j?.svg_content ?? j?.svg ?? j?.data ?? ''
      if (typeof raw !== 'string' || !raw)
        return ''
      raw = decodeEntities(raw)
        .replace(/\\r\\n/g, '\n')
        .replace(/\\n/g, '\n')
        .replace(/\\t/g, '\t')
        .replace(/\\"/g, '"')
        .replace(/\\\//g, '/')
        .replace(/\\\\/g, '\\')
      if (raw.includes('&lt;') || raw.includes('&gt;') || raw.includes('&quot;'))
        raw = decodeEntities(raw)
      return /<svg[\s>]/i.test(raw) ? raw.trim() : ''
    }
    catch {}
  }
  return ''
}

onMounted(async () => {
  try {
    const base = (props.endpoint?.trim() || '/wp-json/cielos/v1/svg-raw').replace(/\/$/, '')
    const url1 = props.src?.trim() || (props.id ? `${base}/${props.id}` : '')
    if (!url1)
      throw new Error('no src/id')

    const fetchTxt = async (u: string) => {
      const r = await fetch(u, { credentials: 'same-origin' })
      if (!r.ok)
        throw new Error(`${r.status} ${r.statusText}`)
      return { text: await r.text(), ct: (r.headers.get('content-type') || '').toLowerCase() }
    }
    const hasSvg = (s: string) => /<svg[\s>]/i.test(s)
    // 先頭の BOM・空白・制御文字（U+0000〜U+001F）を落としてから <svg を探す
    // eslint-disable-next-line no-control-regex -- 制御文字を取り除くための意図した範囲指定
    const stripHead = (s: string) => s.replace(/^\uFEFF/, '').replace(/^[\s\u0000-\u001F]+/, '')

    let svgStr = ''

    // 1) svg-raw or data-src
    {
      const { text, ct } = await fetchTxt(url1)
      const s = normalizeSvgPayload(text, ct)
      const raw = stripHead(text)
      if (hasSvg(s))
        svgStr = s
      else if (ct.includes('image/svg+xml') && hasSvg(raw))
        svgStr = raw
    }

    // 2) fallback: 旧JSON /svg/{id}
    if (!svgStr && props.id) {
      const url2 = `/wp-json/cielos/v1/svg/${props.id}`
      const { text, ct } = await fetchTxt(url2)
      const s = normalizeSvgPayload(text, ct)
      if (hasSvg(s))
        svgStr = s
    }

    // 3) fallback: WPコア /wp/v2/media/{id} → source_url → 直URL fetch
    if (!svgStr && props.id) {
      const url3 = `/wp-json/wp/v2/media/${props.id}`
      const r = await fetch(url3, { credentials: 'same-origin' })
      if (r.ok) {
        const j = await r.json()
        const fileUrl = (j && (j.source_url || (j.media_details && j.media_details.file))) || ''
        if (fileUrl) {
          const { text, ct } = await fetchTxt(fileUrl)
          const s = normalizeSvgPayload(text, ct)
          const raw = stripHead(text)
          if (hasSvg(s))
            svgStr = s
          else if (ct.includes('image/svg+xml') && hasSvg(raw))
            svgStr = raw
        }
      }
    }

    if (!svgStr)
      throw new Error('not svg / unknown payload')
    svg.value = svgStr
  }
  catch (e: any) {
    error.value = e?.message || String(e)
    console.error('[SvgImage] fetch failed:', e)
  }
})
</script>

<template>
  <div v-if="svg" v-html="svg" />
  <p v-else-if="error" class="opacity-70">
    SVG load error: {{ error }}
  </p>
</template>

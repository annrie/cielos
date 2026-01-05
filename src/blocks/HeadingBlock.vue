<script setup lang="ts">
import { ref, computed, onMounted, watch, type CSSProperties } from 'vue'

const props = defineProps<{
	content?: string
	level?: number
	styleVariant?: string
	placeholder?: string
	customClassName?: string
	customStyle?: CSSProperties
}>()

const emit = defineEmits<{
	'update:content': [value: string]
}>()

const headingRef = ref<HTMLElement | null>(null)
const TagName = computed(() => `h${props.level || 2}`)

// styleVariant + customClassName を結合
const headingClass = computed(() => {
	const base = props.styleVariant || 'heading10'
	const custom = props.customClassName || ''
	return custom ? `${base} ${custom}` : base
})

// heading06-label span を除去してクリーンな content を取得
const cleanContent = computed(() => {
	if (!props.content) return ''
	return props.content.replace(/<span[^>]*class="heading06-label"[^>]*>([\s\S]*?)<\/span>/gi, '$1')
})

// 初回マウント時にコンテンツを設定
onMounted(() => {
	if (headingRef.value && props.content) {
		headingRef.value.textContent = cleanContent.value
	}
})

// 外部からの content 変更を監視（ブロック切り替え時など）
watch(() => props.content, (newVal) => {
	if (headingRef.value) {
		const clean = newVal ? newVal.replace(/<span[^>]*class="heading06-label"[^>]*>([\s\S]*?)<\/span>/gi, '$1') : ''
		if (clean !== headingRef.value.textContent) {
			headingRef.value.textContent = clean
		}
	}
})

const onInput = (e: Event) => {
	const target = e.target as HTMLElement
	emit('update:content', target.textContent || '')
}
</script>

<template>
	<!-- heading06 の場合は span.heading06-label でラップ -->
	<component
		v-if="styleVariant === 'heading06'"
		:is="TagName"
		:class="headingClass"
		:style="customStyle"
	>
		<span
			ref="headingRef"
			class="heading06-label"
			contenteditable="true"
			@input="onInput"
			:data-placeholder="placeholder || '見出しを入力...'"
		/>
	</component>
	<component
		v-else
		:is="TagName"
		ref="headingRef"
		:class="headingClass"
		:style="customStyle"
		contenteditable="true"
		@input="onInput"
		:data-placeholder="placeholder || '見出しを入力...'"
	/>
</template>

<style scoped>
/* プレースホルダー表示用 */
[contenteditable]:empty:before {
	content: attr(data-placeholder);
	color: var(--c-muted, #999);
	pointer-events: none;
}

[contenteditable]:focus {
	outline: 2px solid var(--c-accent, #3b82f6);
	outline-offset: 2px;
}
</style>

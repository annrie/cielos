<script setup lang="ts">
const styles = [
{ value: 'heading01', label: 'スタイル 01' },
{ value: 'heading02', label: 'スタイル 02' },
{ value: 'heading03', label: 'スタイル 03' },
{ value: 'heading03-2', label: 'スタイル 03-2' },
{ value: 'heading04', label: 'スタイル 04' },
{ value: 'heading04-2', label: 'スタイル 04-2' },
{ value: 'heading04-3', label: 'スタイル 04-3' },
{ value: 'heading05', label: 'スタイル 05' },
{ value: 'heading06', label: 'スタイル 06' },
{ value: 'heading07', label: 'スタイル 07' },
{ value: 'heading08', label: 'スタイル 08' },
{ label: 'Heading 08-2', value: 'スタイル heading08-2' },
{ value: 'heading09', label: 'スタイル 09' },
{ value: 'heading10', label: 'スタイル 10' },
{ value: 'heading10-2', label: 'スタイル 10-2' },
{ value: 'heading10-3', label: 'スタイル 10-3' },
{ value: 'heading11', label: 'スタイル 11' },
{ value: 'heading12', label: 'スタイル 12' },
{ value: 'heading13', label: 'スタイル 13' },
{ value: 'heading13-2', label: 'スタイル 13-2' },
{ value: 'heading13-3', label: 'スタイル 13-3' },
{ value: 'heading13-4', label: 'スタイル 13-4' },
{ value: 'heading13-5', label: 'スタイル 13-5' },
{ value: 'heading13-6', label: 'スタイル 13-6' },
{ value: 'heading13-7', label: 'スタイル 13-7' },
{ value: 'heading13-8', label: 'スタイル 13-8' },
{ value: 'heading13-9', label: 'スタイル 13-9' },
]

defineProps<{
	modelValue: string
}>()

defineEmits<{
	'update:modelValue': [value: string]
}>()
</script>

<template>
<select
:value="modelValue"
@change="$emit('update:modelValue', ($event.target as HTMLSelectElement).value)"
class="heading-style-selector"
>
<option v-for="style in styles" :key="style.value" :value="style.value">
{{ style.label }}
</option>
</select>
</template>

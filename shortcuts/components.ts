/**
 * Cielos Component Shortcuts
 * Nuxt/Docus 風のモダンなUIコンポーネント
 */
import type { UserShortcuts } from 'unocss'

export const componentShortcuts: UserShortcuts = [
  // ===== ボタン =====
  // Primary Button
  [
    'btn',
    `inline-flex items-center justify-center
     bg-[var(--btn-bg)] text-[var(--btn-fg)]
     px-[var(--btn-px)] py-[var(--btn-py)]
     rounded-[var(--btn-radius)]
     font-[var(--btn-font-weight)]
     shadow-[var(--btn-shadow)]
     transition-all duration-150 ease-out
     hover:bg-[var(--btn-hover-bg)]
     hover:shadow-[var(--btn-shadow-hover)]
     focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] focus:ring-offset-2
     disabled:opacity-50 disabled:cursor-not-allowed`,
  ],

  // Outline Button
  [
    'btn-outline',
    `inline-flex items-center justify-center
     bg-[var(--btn-outline-bg)] text-[var(--btn-outline-fg)]
     border border-[var(--btn-outline-border)]
     px-[var(--btn-px)] py-[var(--btn-py)]
     rounded-[var(--btn-radius)]
     font-[var(--btn-font-weight)]
     transition-all duration-150 ease-out
     hover:bg-[var(--btn-outline-hover-bg)] hover:text-[var(--btn-outline-hover-fg)]
     focus:outline-none focus:ring-2 focus:ring-[var(--c-primary)] focus:ring-offset-2
     disabled:opacity-50 disabled:cursor-not-allowed`,
  ],

  // Accent Button (CTA)
  [
    'btn-accent',
    `inline-flex items-center justify-center
     bg-[var(--btn-accent-bg)] text-[var(--btn-accent-fg)]
     px-[var(--btn-px)] py-[var(--btn-py)]
     rounded-[var(--btn-radius)]
     font-[var(--btn-font-weight)]
     shadow-[var(--btn-shadow)]
     transition-all duration-150 ease-out
     hover:bg-[var(--btn-accent-hover-bg)]
     hover:shadow-[var(--btn-shadow-hover)]
     focus:outline-none focus:ring-2 focus:ring-[var(--c-accent)] focus:ring-offset-2
     disabled:opacity-50 disabled:cursor-not-allowed`,
  ],

  // Small Button
  ['btn-sm', 'text-sm px-3 py-1.5'],

  // Large Button
  ['btn-lg', 'text-lg px-6 py-3'],

  // ===== カード =====
  [
    'card',
    `bg-[var(--card-bg)]
     border border-[var(--card-border)]
     rounded-[var(--card-radius)]
     shadow-[var(--card-shadow)]
     p-[var(--card-padding)]
     transition-all duration-200 ease-out`,
  ],

  // Hover effect for clickable cards
  [
    'card-hover',
    `hover:shadow-[var(--card-shadow-hover)]
     hover:-translate-y-0.5`,
  ],

  // Card without padding (for custom layouts)
  ['card-flush', 'p-0'],

  // ===== バッジ =====
  [
    'badge',
    `inline-flex items-center
     bg-[var(--badge-bg)] text-[var(--badge-fg)]
     px-[var(--badge-px)] py-[var(--badge-py)]
     rounded-[var(--badge-radius)]
     text-[var(--badge-fs)]
     font-medium`,
  ],

  [
    'badge-accent',
    `inline-flex items-center
     bg-[var(--badge-accent-bg)] text-[var(--badge-accent-fg)]
     px-[var(--badge-px)] py-[var(--badge-py)]
     rounded-[var(--badge-radius)]
     text-[var(--badge-fs)]
     font-medium`,
  ],

  [
    'badge-outline',
    `inline-flex items-center
     bg-transparent text-[var(--c-primary)]
     border border-[var(--c-primary)]
     px-[var(--badge-px)] py-[var(--badge-py)]
     rounded-[var(--badge-radius)]
     text-[var(--badge-fs)]
     font-medium`,
  ],

  // ===== 入力フィールド =====
  [
    'input',
    `w-full
     bg-[var(--input-bg)]
     border border-[var(--input-border)]
     rounded-[var(--input-radius)]
     px-[var(--input-px)] py-[var(--input-py)]
     text-[var(--c-fg)]
     placeholder:text-[var(--c-muted)]
     transition-all duration-150
     focus:outline-none
     focus:border-[var(--input-focus-border)]
     focus:ring-2 focus:ring-[var(--input-focus-ring)]
     disabled:opacity-50 disabled:cursor-not-allowed`,
  ],

  // ===== リンク =====
  [
    'link',
    `text-[var(--link-fg)]
     decoration-[var(--link-decoration)]
     hover:text-[var(--link-hover-fg)]
     hover:underline
     transition-colors duration-150`,
  ],

  // ===== コンテナ =====
  [
    'container-page',
    `w-full max-w-[var(--container-w)] mx-auto px-4 md:px-6`,
  ],

  // ===== プローズ（本文） =====
  [
    'prose-base',
    `font-[var(--font-sans)]
     text-[var(--prose-fs)]
     leading-[var(--prose-lh)]
     tracking-[var(--prose-tracking)]
     text-[var(--c-fg)]`,
  ],

  // ===== 見出し共通 =====
  [
    'heading-base',
    `font-[var(--font-sans)]
     font-[var(--heading-weight)]
     leading-[var(--heading-lh)]
     tracking-[var(--heading-tracking)]
     text-[var(--c-fg)]`,
  ],
]

/**
 * ショートカット名を抽出するヘルパー
 */
export function namesFromComponentShortcuts(): string[] {
  return componentShortcuts
    .filter((s): s is [string, string] => Array.isArray(s) && typeof s[0] === 'string')
    .map(([name]) => name)
}

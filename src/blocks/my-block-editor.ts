import { registerBlockType } from '@wordpress/blocks'
import { createElement, useEffect, useRef } from '@wordpress/element'
import { BlockControls, InspectorControls, useBlockProps } from '@wordpress/block-editor'
import { PanelBody, SelectControl, ToolbarGroup, ToolbarDropdownMenu, FontSizePicker } from '@wordpress/components'
import { createApp, h } from 'vue'
import HeadingBlock from './HeadingBlock.vue'

// UnoCSS スタイル（ブロックエディタ用）
import 'virtual:uno.css'
// トークン（CSS カスタムプロパティ）
import '../assets/css/tokens.css'
// 見出しスタイル参照（UnoCSS にクラスを含めるため）
import './heading-styles.css'
// MyBlock スタイル（エディタ用）
import './my-block-styles.css'

const HEADING_LEVELS = [1, 2, 3, 4, 5, 6]

// スタイルバリエーション
const STYLE_OPTIONS = [
	{ label: 'Heading 01（上下破線-切り取り線）', value: 'heading01' },
	{ label: 'Heading 02（傾き-テープ）', value: 'heading02' },
	{ label: 'Heading 03（傾き全幅-リボン）', value: 'heading03' },
	{ label: 'Heading 03-2（折り返し）', value: 'heading03-2' },
	{ label: 'Heading 04（角丸下三角-吹き出し）', value: 'heading04' },
	{ label: 'Heading 04-2（下三角塗り潰し）', value: 'heading04-2' },
	{ label: 'Heading 04-3（下三角-枠つき）', value: 'heading04-3' },
	{ label: 'Heading 05（装飾）', value: 'heading05' },
	{ label: 'Heading 06（文字下線-付箋）', value: 'heading06' },
	{ label: 'Heading 07（角丸なし左窪み-Depository）', value: 'heading07' },
	{ label: 'Heading 08（左装飾Gracias）', value: 'heading08' },
	{ label: 'Heading 08-2（左装飾Gracias+penアイコン）', value: 'heading08-2' },
	{ label: 'Heading 09（左旗）', value: 'heading09' },
	{ label: 'Heading 10（ピンマーク）', value: 'heading10' },
	{ label: 'Heading 10-2（ピンマーク2）', value: 'heading10-2' },
	{ label: 'Heading 10-3（ピンマーク3）', value: 'heading10-3' },
	{ label: 'Heading 11（下ボーダー）', value: 'heading11' },
	{ label: 'Heading 12（ワンポイント）', value: 'heading12' },
	{ label: 'Heading 13（シンプル）', value: 'heading13' },
	{ label: 'Heading 13-2（シンプル2）', value: 'heading13-2' },
	{ label: 'Heading 13-3（枠シンプル）', value: 'heading13-3' },
	{ label: 'Heading 13-4（枠シンプル2）', value: 'heading13-4' },
	{ label: 'Heading 13-5（枠シンプル3）', value: 'heading13-5' },
	{ label: 'Heading 13-6（枠塗り潰し）', value: 'heading13-6' },
	{ label: 'Heading 13-7（枠シンプル4）', value: 'heading13-7' },
	{ label: 'Heading 13-8（枠塗り潰し2-傾き）', value: 'heading13-8' },
	{ label: 'Heading 13-9（枠シンプル5-下線のみ）', value: 'heading13-9' },
]

// フォントサイズプリセット（FontSizePicker用）
const FONT_SIZES = [
	{ name: '小', slug: 'small', size: 14 },
	{ name: '標準', slug: 'normal', size: 16 },
	{ name: '中', slug: 'medium', size: 20 },
	{ name: '大', slug: 'large', size: 24 },
	{ name: '特大', slug: 'x-large', size: 32 },
	{ name: '巨大', slug: 'huge', size: 48 },
]

// 統一見出しブロックを登録
registerBlockType('uno/theme-heading', {
	title: 'Uno テーマ見出し',
	description: 'スタイル選択可能な見出しブロック（テーマ版）',
	icon: 'heading',
	category: 'text',
	keywords: ['heading', 'title', '見出し', 'uno'],

	attributes: {
		content: {
			type: 'string',
			source: 'html',
			selector: 'h1,h2,h3,h4,h5,h6',
		},
		level: {
			type: 'number',
			default: 2,
		},
		styleVariant: {
			type: 'string',
			default: 'heading10',
		},
		fontSize: {
			type: 'number',
		},
	},

	edit: (props: any) => {
		const { attributes, setAttributes } = props
		const containerRef = useRef<HTMLDivElement | null>(null)
		const appRef = useRef<ReturnType<typeof createApp> | null>(null)

		// useBlockProps で高度な設定のクラス・スタイルを取得
		const blockProps = useBlockProps()

		// Vue アプリをマウント/再マウントする関数
		const mountVueApp = () => {
			if (appRef.current) {
				appRef.current.unmount()
			}
			appRef.current = createApp({
				render() {
					// fontSize を customStyle にマージ
					const mergedStyle = {
						...(blockProps.style || {}),
						...(attributes.fontSize ? { fontSize: `${attributes.fontSize}px` } : {}),
					}
					return h(HeadingBlock, {
						content: attributes.content,
						level: attributes.level,
						styleVariant: attributes.styleVariant,
						// 高度な設定のカスタムクラスを渡す
						customClassName: attributes.className || '',
						// 高度な設定のスタイル（フォントサイズ等）を渡す
						customStyle: mergedStyle,
						'onUpdate:content': (value: string) => {
							setAttributes({ content: value })
						},
					})
				},
			})
			if (containerRef.current) {
				appRef.current.mount(containerRef.current)
			}
		}

		// 初回マウント
		useEffect(() => {
			if (containerRef.current && !appRef.current) {
				mountVueApp()
			}
			return () => {
				if (appRef.current) {
					appRef.current.unmount()
					appRef.current = null
				}
			}
		}, [])

		// level, styleVariant, className, style, fontSize 変更時に再マウント
		useEffect(() => {
			if (appRef.current && containerRef.current) {
				mountVueApp()
			}
		}, [attributes.level, attributes.styleVariant, attributes.className, attributes.fontSize, JSON.stringify(blockProps.style)])

		return createElement(
			'div',
			null,
			// 右パネル（InspectorControls）
			createElement(
				InspectorControls,
				null,
				createElement(
					PanelBody,
					{ title: '見出し設定', initialOpen: true },
					createElement(SelectControl, {
						label: 'スタイル',
						value: attributes.styleVariant,
						options: STYLE_OPTIONS,
						onChange: (value: string) => setAttributes({ styleVariant: value }),
					})
				),
				createElement(
					PanelBody,
					{ title: 'フォントサイズ', initialOpen: false },
					createElement(FontSizePicker, {
						fontSizes: FONT_SIZES,
						value: attributes.fontSize,
						onChange: (newFontSize: number | undefined) => setAttributes({ fontSize: newFontSize }),
						withSlider: true,
					})
				)
			),
			// ツールバー（見出しレベル選択）
			createElement(
				BlockControls,
				null,
				createElement(
					ToolbarGroup,
					null,
					createElement(ToolbarDropdownMenu, {
						icon: 'heading',
						label: '見出しレベル',
						controls: HEADING_LEVELS.map((lvl) => ({
							title: `H${lvl}`,
							isActive: attributes.level === lvl,
							onClick: () => setAttributes({ level: lvl }),
						})),
					})
				)
			),
			// Vue コンテナ
			createElement('div', {
				ref: containerRef,
				className: `wp-block-uno-heading`,
			})
		)
	},

	save: ({ attributes }: any) => {
		const TagName = `h${attributes.level}` as keyof JSX.IntrinsicElements
		// useBlockProps.save でタイポグラフィ等のスタイルを取得
		const blockProps = useBlockProps.save({
			className: attributes.styleVariant,
			style: attributes.fontSize ? { fontSize: `${attributes.fontSize}px` } : {},
		})

		// heading06 の場合は span.heading06-label でラップ
		if (attributes.styleVariant === 'heading06') {
			// 既存の heading06-label span を除去（二重ラップ防止）
			const cleanContent = attributes.content
				? attributes.content.replace(/<span[^>]*class="heading06-label"[^>]*>([\s\S]*?)<\/span>/gi, '$1')
				: ''
			return createElement(
				TagName,
				blockProps,
				createElement('span', {
					className: 'heading06-label',
					dangerouslySetInnerHTML: { __html: cleanContent }
				})
			)
		}

		return createElement(
			TagName,
			blockProps,
			attributes.content
		)
	},
})

import MyBlock from './MyBlock.vue'
registerBlockType('uno/my-block', {
  title: 'Cielos Theme Block',
  icon: 'smiley',
  category: 'widgets',
  edit: (props) => {
    const containerRef = useRef(null)
    const appRef = useRef(null)

    useEffect(() => {
      if (containerRef.current && !appRef.current) {
        // Vue アプリをマウント
        appRef.current = createApp({
          render() {
            return h(MyBlock, {}, () => props.attributes.content || '')
          },
        })
        appRef.current.mount(containerRef.current)
      }

      return () => {
        // クリーンアップ
        if (appRef.current) {
          appRef.current.unmount()
          appRef.current = null
        }
      }
    }, [])

    return createElement('div', { ref: containerRef })
  },
  save: (props) => {
    return createElement(
      'div',
      { className: 'my-custom-block p-4 bg-blue-100 rounded-lg shadow-md' },
      createElement('h2', { className: 'text-xl font-bold text-blue-800' }, 'テーマ側 Block(frontend)'),
      createElement('p', { className: 'text-gray-700 mt-2' }, props.attributes.content)
    )
  },
  attributes: {
    content: {
      type: 'string',
      source: 'html',
      selector: '.my-custom-block p',
    },
  },
})

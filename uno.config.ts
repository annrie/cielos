import {presetHeroPatterns} from '@julr/unocss-preset-heropatterns'
import presetTagify from '@unocss/preset-tagify'
import {createLocalFontProcessor} from '@unocss/preset-web-fonts/local'
import {createRemToPxProcessor} from '@unocss/preset-wind4/utils'
import transformerAttributifyJsx from '@unocss/transformer-attributify-jsx'
import transformerCompileClass from '@unocss/transformer-compile-class'
import {animatedUno} from 'animated-unocss'
import {createRequire} from 'node:module'
import {
  defineConfig,
  presetAttributify,
  presetIcons,
  presetTypography,
  presetWebFonts,
  presetWind4,
  transformerDirectives,
  transformerVariantGroup,
} from 'unocss'
import {presetExtra} from 'unocss-preset-extra'
import transformerAlias from 'unocss-transformer-alias'
import {preflight404,preflightA11y,preflightArchive,preflightAuthor,preflightBase,preflightBiblio,preflightBreadcrumbs,preflightChildPages,preflightComments,preflightContent,preflightDocs,preflightFooter,preflightFooterVisibilityGuard,preflightForms,preflightHeader,preflightHeaderDesktopRow,preflightHeroFeature,preflightHeroPage,preflightLayout,preflightMobileMenu,preflightNavSolid,preflightPrint,preflightRelated,preflightSearch,preflightSidebar,preflightSingle,preflightStickyFooter,preflightSyntax,preflightThemeIcons,preflightThemeTransition,preflightTop,preflightWpAdmin,tabsPreflight,tokensPreflight} from './preflight'

import compatShortcuts from './shortcuts/compat'
import {componentShortcuts, namesFromComponentShortcuts} from './shortcuts/components'
import {extrasShortcuts} from './shortcuts/extras'
import {headingShortcuts} from './shortcuts/headings'

const require = createRequire(import.meta.url)


// preflights are configured explicitly below; helper list removed

// ヘルパー：defineConfig の前あたりに1回だけ
const __resolveColor = (theme: any, key: any) => {
  const colors = theme?.colors;
  if (!colors || key == null) return String(key ?? '');
  const v = colors[key];
  if (!v) return String(key);
  if (typeof v === 'string') return v;
  if (typeof v === 'object') return v.DEFAULT ?? v[500] ?? v[600] ?? v[400] ?? Object.values(v)[0] ?? String(key);
  return String(key);
};

function namesFromShortcuts(sc: any[]): string[] {
  return sc.flatMap((s) => {
    // ["name", "..."] or ["name","...",{selector:...}]
    if (Array.isArray(s) && typeof s[0] === 'string') return [s[0]]
    return []
  })
}

const SAFE_FIXED = [
  // 動的付与されがちなものがあればここに（例）
   'dark','light',
]

function convert(c: string) { return c; }

function makeColorPalette(color: string) {
  return {
      DEFAULT: color,
      50:  `color-mix(in srgb, ${color} 5%,  white)`,
      100: `color-mix(in srgb, ${color} 10%, white)`,
      200: `color-mix(in srgb, ${color} 30%, white)`,
      300: `color-mix(in srgb, ${color} 50%, white)`,
      400: `color-mix(in srgb, ${color} 70%, white)`,
      500: color,
      600: `color-mix(in srgb, ${color} 70%, black)`,
      700: `color-mix(in srgb, ${color} 50%, black)`,
      800: `color-mix(in srgb, ${color} 30%, black)`,
      900: `color-mix(in srgb, ${color} 15%, black)`,
      950: `color-mix(in srgb, ${color} 8%,  black)`,
  };
}

function aliasScale(prefix: string, base: string) {
  return Object.fromEntries(
    [50,100,200,300,400,500,600,700,800,900,950].map(
      s => [`${prefix}-${s}`, `var(--colors-${base}-${s})`],
    ),
  );
}

/* ===== ビューポート基準を 320～1600 に変更 ===== */
const REM_BASE = 16
const VIEWPORT_MIN_WIDTH = 320
const VIEWPORT_MAX_WIDTH = 1600

function calculateClamp(minPx: number, maxPx: number): string {
  const minRem = (minPx / REM_BASE).toFixed(3)
  const maxRem = (maxPx / REM_BASE).toFixed(3)
  const slope = (maxPx - minPx) / (VIEWPORT_MAX_WIDTH - VIEWPORT_MIN_WIDTH)
  const intercept = minPx - slope * VIEWPORT_MIN_WIDTH
  const slopeVw = (slope * 100).toFixed(3)
  const interceptRem = (intercept / REM_BASE).toFixed(3)
  return `clamp(${minRem}rem, ${interceptRem}rem + ${slopeVw}vw, ${maxRem}rem)`
}

/* ===== TEXT_SCALE ===== */
const TEXT_SCALE = {
  // Body
  xxs: { min: 7,  max: 9,  lineHeight: 1.55 }, // 0.5rem = 8px
  xs:  { min: 11, max: 13, lineHeight: 1.55 }, // 0.75rem = 12px
  sm:  { min: 13, max: 15, lineHeight: 1.55 }, // 0.875rem = 14px
  base:{ min: 15, max: 18, lineHeight: 1.6  }, // 1rem = 16px
  lg:  { min: 17, max: 20, lineHeight: 1.6  }, // 1.125rem = 18px
  // Headings
  h6:  { min: 15, max: 20, lineHeight: 1.45 },
  h5:  { min: 18, max: 24, lineHeight: 1.4  },
  h4:  { min: 22, max: 28, lineHeight: 1.35 },
  h3:  { min: 28, max: 36, lineHeight: 1.3  },
  h2:  { min: 34, max: 44, lineHeight: 1.25 },
  h1:  { min: 42, max: 56, lineHeight: 1.15 },
  // Highlight
  highlight: { min: 64, max: 80, lineHeight: 1.1 },
}

function buildTextTheme(scale: typeof TEXT_SCALE) {
  const text: Record<string, any> = {}
  for (const [k, v] of Object.entries(scale)) {
    text[k] = {
      fontSize: calculateClamp(v.min, v.max),
      lineHeight: String(v.lineHeight),
    }
  }
  return text
}

function truncate_decimal(number: number, digit: number = 3): number {
  return Math.floor(number * 10 ** digit) / 10 ** digit
}

function calculateVw(number: string, base: number): string {
  const result = (Number(number) / base) * 100
  return `${truncate_decimal(result)}vw`
}

function getPropertyNames(propertyNames: string[], value: string, initialValue: Record<string, string> = {}): Record<string, string> {
  return propertyNames.reduce(
    (acc, propertyName) => {
      acc[propertyName] = value
      return acc
    },
    { ...initialValue },
  )
}

function setProperty(prefix: string, propertyNames: string[], _initialValue: Record<string, string> = {}): Array<[RegExp, (match: RegExpMatchArray) => Record<string, string>]> {
  return [
    [new RegExp(`^${prefix}-(\d+)$`), ([, d]) => getPropertyNames(propertyNames, `${d}px`)],
    [new RegExp(`^${prefix}-(\d+)ptr$`), ([, d]) => getPropertyNames(propertyNames, `${Number(d) / REM_BASE}rem`)],
    [new RegExp(`^${prefix}-(\d+(\.\d+)?)em$`), ([, d]) => getPropertyNames(propertyNames, `${d}em`)],
    [
      new RegExp(`^${prefix}-(\d+)/(\d+)em$`),
      ([, d1, d2]) => {
        const result = Number(d1) / Number(d2)
        return getPropertyNames(propertyNames, `${truncate_decimal(result)}em`)
      },
    ],
    [new RegExp(`^${prefix}-(\d+(\.\d+)?)per$`), ([, d]) => getPropertyNames(propertyNames, `${d}%`)],
    [
      new RegExp(`^${prefix}-(\d+)/(\d+)per$`),
      ([, d1, d2]) => {
        const result = (Number(d1) / Number(d2)) * 100
        return getPropertyNames(propertyNames, `${truncate_decimal(result)}%`)
      },
    ],
    [new RegExp(`^${prefix}-(\d+)ptvw$`), ([, d]) => getPropertyNames(propertyNames, calculateVw(d, BREAKPOINT_MIN_WIDTH_SM))],
    [new RegExp(`^${prefix}-(\d+)ptvw-sm$`), ([, d]) => getPropertyNames(propertyNames, calculateVw(d, BREAKPOINT_MIN_WIDTH_MD))],
    [new RegExp(`^${prefix}-(\d+)ptvw-md$`), ([, d]) => getPropertyNames(propertyNames, calculateVw(d, BREAKPOINT_MIN_WIDTH_TB))],
    [new RegExp(`^${prefix}-(\d+)ptvw-lg$`), ([, d]) => getPropertyNames(propertyNames, calculateVw(d, BREAKPOINT_MIN_WIDTH_LG))],
    [new RegExp(`^${prefix}-(\d+)ptvw-xl$`), ([, d]) => getPropertyNames(propertyNames, calculateVw(d, BREAKPOINT_MIN_WIDTH_XL))],
    [new RegExp(`^${prefix}-clamp-(\d+)-(\d+)$`), ([, d1, d2]) => getPropertyNames(propertyNames, `${calculateClamp(d1, d2)}`)],
  ]
}

const validateColors = (colorsObj) => {
  for (const [k, v] of Object.entries(colorsObj ?? {})) {
    if (v == null) throw new Error(`theme.colors["${k}"] is ${v}`);
    if (typeof v === 'object' && !Array.isArray(v)) {
      for (const [kk, vv] of Object.entries(v ?? {})) {
        if (vv == null) throw new Error(`theme.colors["${k}"]["${kk}"] is ${vv}`);
      }
    }
  }
  return colorsObj;
};
// -----------------------------------------------------------------------------------------
export default defineConfig({
//  dark: 'class',
  content: {
    pipeline: {
      include: [/\.(html|php|vue|jsx?|tsx?|mdx?|md)(\?.*)?$/],
      exclude: [
        /node_modules/,
        /\.git/,
        /dist/,
        /\.vite/,
        /vendor/,
        /uploads/,   // WP
        /cache/,
      ],
    },
    filesystem: [
      '*.php',              // テーマルートのPHPファイル（page.php, archive.php, page-machaki.phpなど）
      'app/**/*.php',
      'templates/**/*.{php,html}',
      'template-parts/**/*.php',  // template-partsディレクトリ
      'library/**/*.php',         // libraryディレクトリ
      'src/**/*.{vue,js,ts,jsx,tsx}',
      'resources/**/*.{vue,js,ts,jsx,tsx}',
      'content/**/*.{md,mdx}',
    ],
  },
  safelist: Array.from(new Set([
				'!mb-20','!mt-20',
    ...namesFromShortcuts(headingShortcuts),
				...namesFromShortcuts(extrasShortcuts),
    ...namesFromComponentShortcuts(),

    // compat は selector/regex が多いので基本は不要。文字名だけ拾うなら↓
    // ...namesFromShortcuts(compatShortcuts),
    ...SAFE_FIXED,
     'no-theme-anim',
     'w-[var(--container-w)]',  // パンクズナビとcontainerの幅統一
     // レイアウト
     'container-page', 'layout-2col', 'layout-2col-rev',
     'main-content', 'main-content-full', 'sidebar-area',
     'hero-section', 'featured-posts', 'page-section',
     // 'top-hero-title' は preflight.top.ts で定義されているため safelist 不要
     // テキストサイズ
     'text-h1','text-h2','text-h3','text-h4','text-h5','text-h6',
     'text-base','text-lg','text-xl','text-2xl','text-3xl','text-4xl','text-5xl','text-6xl','text-7xl','text-8xl','text-9xl',
     // よく使う色クラス
     'text-gray-900','dark:text-white','text-blue-600','dark:text-blue-400',
     // サイドバーウィジェットで動的に追加されるアイコン
     'i-carbon-document',  // 最近の投稿、最新情報
     'i-carbon-folder',    // カテゴリー
     'i-carbon-calendar',  // アーカイブ
     'i-carbon-book',      // 僭越図書館（固定ページ）
     'i-carbon-rss',       // RSSフィード
     'i-carbon-launch',    // 外部リンク
     'i-twemoji-classical-building', // page-machaki.php タイトル 🏛️
     // Bibliography pages (page-id-3136など) で使用されるクラス
     'grid', 'grid-cols-1', 'grid-cols-3', 'lg:grid-cols-2', 'md:grid-cols-2', 'md:grid-cols-3',
     'gap-6', 'gap-4', 'gap-8',
     'lg:hidden', 'md:hidden', 'sm:hidden',
     'print:hidden',
     'col-span-1', 'col-span-2',
  ])),
  theme: {
    breakpoint: {
      xsm: '320px',
      sm:  '375px',
      md:  '640px',
      tb:  '768px',
      lg:  '1024px',
      xl:  '1440px',
      '2xl': '1600px',
    },
    text: buildTextTheme(TEXT_SCALE),
    colors: {
      'black': { DEFAULT: '#0a0a0a' },
      'white': { DEFAULT: '#fefefe' },
      'whiteex': makeColorPalette('#fefefe'),
      'blackex': makeColorPalette('#0a0a0a'),
      'primaryex': makeColorPalette('#1779ba'),
      'secondaryex': makeColorPalette('#767676'),
      'successex': makeColorPalette('#3adb76'),
      'warningex': makeColorPalette('#ffae00'),
      'alertex': makeColorPalette('#cc4b37'),
      'jisredex': makeColorPalette('#ff4b00'),
      'jisorangeex': makeColorPalette('#f6aa00'),
      'jisyellowex': makeColorPalette('#f2e700'),
      'jisgreenex': makeColorPalette('#00b06b'),
      'jisblueex': makeColorPalette('#1971ff'),
      'jismagentaex': makeColorPalette('#999900'),
      'sf': makeColorPalette('#2563eb'),
      'adv': makeColorPalette('#669900'),
      'mys': makeColorPalette('#ed181e'),
      'horror': makeColorPalette('#0a0a0a'),
      'jedi': makeColorPalette('#4b5563'),
      'short': makeColorPalette('#84cc16'),
      'primary-head': convert('#1779ba'),
      'secondary': convert('#767676'),
      'success': convert('#3adb76'),
      'warning': convert('#ffae00'),
      'alert': convert('#cc4b37'),
      'jis-red': convert('#ff4b00'),
      'jis-orange': convert('#f6aa00'),
      'jis-yellow': convert('#f2e700'),
      'jis-green': convert('#00b06b'),
      'jis-blue': convert('#1971ff'),
      'jis-magenta': convert('#999900'),
      // ---- primary 系は Uno の sky に寄せる（お好みで 'blue' や 'indigo' に変更可）
      ...aliasScale('primary', 'sky'),
      primary:               'var(--colors-sky-500)',
      'primary-emphasis':    'var(--colors-sky-600)',
      'primary-emphasis-alt':'var(--colors-sky-700)',
      'primary-contrast':    'var(--colors-white-DEFAULT)',

      // ---- surface 系は Uno の slate に寄せる
      'surface-0': 'var(--colors-white-DEFAULT)', // 0 は独自に白へ
      ...aliasScale('surface', 'slate'),
      'bisque': { DEFAULT: '#FFE4C4' },
      'lightcyan': { DEFAULT: '#E0FFFF' },
    },
    font: {
      /* Combined sans-serif */
      'sans': '-apple-system, blinkmacsystemfont, avenir, \'Noto Sans JP\', \'Helvetica Neue\', helvetica, arial, verdana, roboto, \'YuGothic\', \'Hiragino Kaku Gothic ProN\', \'ヒラギノ角ゴ ProN W3\', \'メイリオ\', meiryo, \'MS PGothic\', \'ＭＳ Ｐゴシック\', \'M+ 1p\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'',
      // Combined serif
      'serif': '\'Noto Serif JP\', garamond, \'Times New Roman\', \'Yu Mincho\', \'游明朝\', \'YuMincho\', \'游明朝体\', \'Hiragino Mincho Pro\', \'ヒラギノ明朝 Pro W3\', \'HiraMinProN-W3\', \'Roboto Slab\', \'HGS明朝E\', \'ＭＳ Ｐ明朝\', \'MS PMincho\', serif',
      // Combined monospace
      'mono': '\'SourceHanCodeJP-Regular\', \'Myrica M\', \'MyricaM M\', \'Ricty Diminished Discord\', \'Migu 1M\', \'Rounded M+ 1m regular\', \'Rounded Mgen+ 1m regular\', \'M+ 1m\', \'VL ゴシック\', menlo, monaco, consolas, \'Liberation Mono\', \'Courier New\', monospace',
      'en': '"Source Sans Pro", Lato, Lobster, sans', // Keep existing 'en'

      // Specific Japanese fonts from _variables.scss
      'ryumin-medium-kl': '\'Ryumin Medium KL\', \'リュウミン M-KL\', serif',
      'ryumin-regular-kl': '\'Ryumin Regular KL\', \'リュウミン R-KL\', serif',
      'min-ma31': '\'Midashi Min MA31\', \'見出ミンMA31\', serif',
      'a1-mincho': '\'A1 Mincho\', \'A1明朝\', serif',

      'shin-go-regular': '\'Shin Go Regular\', \'新ゴ R\', sans-serif',
      'shin-go-medium': '\'Shin Go Medium\', \'新ゴ M\', sans-serif',
      'gothic-mb101-bold': '\'Gothic MB101 B\', sans-serif',
      'midashi-go-mb31': '\'Midashi Go MB31\', \'見出ゴMB31\', sans-serif',
      'now-gm': '\'NOW-GM\', \'ナウ-GM\', sans-serif',
      'm-plus-rounded-1c': '\'M PLUS Rounded 1c\', sans-serif',

      'jun-201': '\'Jun 201\', \'じゅん 201\', sans-serif',
      'jun-501': '\'Jun 501\', \'じゅん 501\', sans-serif',
      'shin-maru-go-regular': '\'Shin Maru Go Regular\', \'新丸ゴ R\', sans-serif',
      'kosugi-maru': '\'Kosugi Maru\', sans-serif',

      'folk-regular': '\'Folk Regular\', \'フォーク R\', sans-serif',
      'folk-medium': '\'Folk Medium\', \'フォーク M\', sans-serif',
      'maru-folk-regular': '\'Maru Folk Regular\', \'丸フォーク R\', sans-serif',
      'maru-folk-medium': '\'Maru Folk Medium\', \'丸フォーク M\', sans-serif',
      'kakumin-regular': '\'Kakumin Regular\', \'カクミン R\', sans-serif',
      'kaimin-sora-bold': '\'Kaimin Sora Bold\', \'解ミン 宙 B\', sans-serif',
      'cinema-letter': '\'Cinema Letter\', \'シネマレター\', sans-serif',
      'talking': '\'Talking\', \'トーキング\', sans-serif',
      'haruhi-gakuen': '\'Haruhi Gakuen\', \'はるひ学園\', sans-serif',
      'suzumushi': '\'Suzumushi\', \'すずむし\', sans-serif',
      'gsanserif-b': '\'GSanSerif-B\', \'G2サンセリフ-B\', sans-serif',

      'shin-maru-go-futoline': '\'Shin Maru Go Futoline\', \'新丸ゴ 太ライン\', fantasy',

      'sei-kaisho-cb1': '\'Sei Kaisho CB1\', \'正楷書CB1\', cursive',
      'reisho-101': '\'Reisho 101\', \'隷書101\', cursive',

      'ud-shin-go-regular': '\'UD Shin Go Regular\', \'UD新ゴ R\', sans-serif',
      'ud-shin-go-medium': '\'UD Shin Go Medium\', \'UD新ゴ M\', sans-serif',
      'ud-shin-go-conde90-l': '\'UD Shin Go Conde90 L\', \'UD新ゴ コンデンス90 L\', sans-serif',
      'ud-shin-go-conde90-m': "'UD Shin Go Conde90 M', 'UD新ゴ コンデンス90 M', sans-serif",
      'num': ['DIN Medium', 'Helvetica Neue', 'Arial', 'Liberation Sans', 'FreeSans', 'sans-serif'],
    },
    leading: {
      snug: '1.375',
      normal: '1.5',
      relaxed: '1.625',
      loose: '1.75',
    },
    tracking: {
      tight: '-0.01em',
      normal: '0',
      wide: '0.02em',
    },
    transitionTimingFunction: {
      DEFAULT: 'cubic-bezier(.16,1,.3,1)',
    },
    duration: {
      DEFAULT: '0.8s',
    },
    animation: {
      keyframes: {
        'custom-anime': `{
          0% { opacity: 1; }
          100% { opacity: 0; }
        }`,
      },
      durations: {
        'custom-anime': '0.8s',
      },
      timingFns: {
        'custom-anime': 'cubic-bezier(.16,1,.3,1)',
      },
      counts: {
        'custom-anime': 0,
      },
      properties: {
        'custom-anime02': {
          animation: '3s ease-in 1s 2 reverse both paused custom-anime02',
        },
      },
    },
  },
  shortcuts: [
    ...headingShortcuts,
    ...extrasShortcuts,
    ...compatShortcuts,
    ...componentShortcuts,

    // 1) 引数なし mixin → そのままshortcut（componentShortcuts に移行済み）

    // 2) 変数参照の定数系（Sass不要）
    ['container-pad', 'px-[var(--section-x)]'],
    ['header-h', 'h-[var(--header-h)]'],
    [
      'button-blue',
      'inline-block mx-auto px-4 py-1 rounded bg-blue-500 text-white dark:(text-white hover:text-dark) cursor-pointer hover:(bg-success text-dark-600)  disabled:bg-gray-600 disabled:opacity-50',
    ],

   // 3) 既存の見出しスタイル（定数）もここでOK
    [
      'latest-columns-title-style',
      `relative w-full
       bg-[image:var(--latest-bg-stack)]
       text-[var(--latest-fg)]
       text-[length:var(--latest-title-fs)]
       rounded-[var(--latest-radius)]
       border border-solid border-[var(--latest-border)]
       shadow-[var(--latest-inset)]
		px-[var(--latest-title-px)] py-[var(--latest-title-py)]       hover:bg-[image:var(--laetest-bg-stack-hover)]
		transition-colors duration-300
`,
    ],
    [
      'machaki-group-title-style',
      `relative w-full
       bg-[image:var(--machaki-bg-stack)]
       text-[var(--machaki-fg)]
       text-[length:var(--machaki-title-fs)]
       rounded-[var(--machaki-radius)]
       border border-solid border-[var(--machaki-border)]
       shadow-[var(--machaki-inset)]
       px-[var(--machaki-title-px)] py-[var(--machaki-title-py)]
       outline outline-1 outline-solid outline-[var(--machaki-outline)] outline-offset-[var(--machaki-outline-offset-y)]
       hover:bg-[image:var(--machaki-bg-stack-hover)]
       transition-colors duration-300`,
    ],
    [
      'icon-btn',
      'inline-block cursor-pointer select-none opacity-75 transition duration-200 ease-in-out hover:opacity-100 hover:text-teal-600 no-underline w-fit',
    ],
    [/^btn-(.*)$/, ([, c], { theme }) => {
      if (Object.keys(theme.colors).includes(c))
        return `bg-${c}4:10 text-${c}5 rounded`
    }],
    ['flex-center', 'flex justify-center items-center'],
    ['bg-my-20', 'bg-#e5e5e5 bg-opacity-20'],
    ['flex-col-center', 'flex items-center'],
    ['flex-row-center', 'flex justify-center'],
    ['trans-all-300-ease', 'transition-all duration-300 transition-ease'],
    ['absolute-x-center', 'absolute left-1/2 -translate-x-1/2'],
    ['absolute-y-center', 'absolute top-1/2 -translate-y-1/2'],
    ['absolute-center', 'absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2'],
    ['absolute-0', 'absolute left-0 top-0'],
    ['hw-full', 'h-full w-full'],
    ['trans-300', 'transition-all duration-300'],
    ['trans-act-scale', 'transition-transform active:scale-99'],
    ['p-com', 'px-5 py-4'],
    ['border-com', 'dark:border-#222  border border-#e5e5e5'],
    ['bg-com', 'dark:bg-#333 bg-white'],
    ['shadow-com', 'border-t-1 border-#333 shadow-md border-op-20 dark:border-op-60 dark:shadow-#333'],
	['pm-num-font', 'font-num font-bold'],
		
    // heading01〜heading13-9 は shortcuts/headings.ts で定義
    ['linkIcon', 'relative before:absolute before:top-1/2 before:right-[15px] before:w-[6px] before:h-[6px] before:content-empty before:border-t-3 before:border-t-solid before:border-t-[var(--link-icon-color,#333)] before:border-r-3 before:border-r-solid before:border-r-[var(--link-icon-color,#333)] before:transform before:rotate-45 before:-translate-y-1/2'],
    ['info-wrap-style', 'mt-[3px] border-b border-b-black/10 shadow-[rgba(255,255,255,0.5)_0_1px_0] border-l border-l-black/10 shadow-[rgba(255,255,255,0.5)_-1px_0_0] border-r border-r-black/10 shadow-[inset_rgba(255,255,255,0.5)_-1px_0_0]' ],
    ['link-text-style', 'relative block p-2 border border-black/25 rounded bg-[#98fb98] dark:bg-green-800 dark:border-white/25'],
    ['link-text-button-style', 'relative inline-block h-[calc(0.8rem*3)] px-[calc(0.8rem*3)] text-[0.8rem] font-bold leading-[calc(0.8rem*3)] text-center rounded text-[dodgerblue]/90 bg-gradient-to-t from-[#00bfff] to-[color-mix(in_srgb,#00bfff_95%,white)] border border-black/5 shadow-[rgba(0,0,0,0.05)_-1px_1px_0,rgba(255,255,255,1)_-1px_1px_0_inset] text-shadow-[1px_-1px_rgba(0,0,0,0.1)] hover:text-[dodgerblue] active:top-[1px] dark:text-blue-300/90 dark:border-white/10 dark:bg-gradient-to-t dark:from-blue-500 dark:to-blue-400 dark:hover:text-blue-200'],
    [
      'heading04-3-style',
      `relative pt-[15px] pr-[5px] pb-[12px] pl-[10px]
      mt-[30px] mx-[-10px] mb-[10px]
      text-[4rem] leading-none text-[#111] dark:text-white bg-white dark:bg-surface-800
      border-2 border-solid border-[#555] dark:border-surface-500 rounded-[3px]
      heading04-3-pseudo-white-555 dark:heading04-3-pseudo-surface-800-surface-500`,
    ],
    [
      'heading13-4-style',
      `relative py-[0.8em] pl-[1.5em] mb-[1.5em]
      text-inherit font-bold bg-transparent
      border-2 border-solid border-[#e6e6fa] dark:border-surface-500
      heading13-4-pseudo-9999d4 dark:heading13-4-pseudo-surface-700`,
    ],
    [
      'content-wrapper',
      'bg-white p-6 border border-gray-200 dark:bg-gray-800 dark:border-gray-700 pm-line-top-10-100 pm-line-bottom-10-100 pm-line-left-10-100 pm-line-right-10-100',
    ],
  ],
	layers: {
		'preflights': -2,
		'components': -1,
		'default': 1,
		'utilities': 2,
		'my-layer': 3,
	},
  presets: [
    presetWind4({
      preflights:  {
        theme: {
          process: createRemToPxProcessor(),
        },
          reset: true,
      },
      dark: 'class',
    }),
    presetAttributify(),
    presetTagify({
      prefix: 'un-',
      extraProperties: matched => matched.startsWith('i-')
        ? { display: 'inline-block' }
        : { },
    }),
    presetIcons({
      autoInstall: true,
      prefix: 'i-',
      scale: 1.1,
      extraProperties: {
        'display': 'inline-block',
        'vertical-align': 'text-bottom',
      },
      collections: {
        'carbon': async () => import('@iconify-json/carbon/icons.json').then(i => i.default),
        'tabler': () => import('@iconify-json/tabler/icons.json').then(i => i.default),
        'mdi': async () => import('@iconify-json/mdi/icons.json').then(i => i.default),
        'logos': async () => import('@iconify-json/logos/icons.json').then(i => i.default),
        'fa6-solid': () => require('@iconify-json/fa6-solid/icons.json'),
      },
    }),
    presetTypography(),
    presetHeroPatterns(),
    presetExtra(),
    animatedUno(),
    presetWebFonts({
      themeKey: 'fontFamily',
      provider: 'none',
      fonts: {
        sans: 'Noto Sans JP',
        serif: 'Noto Serif JP',
        dm: [
          { name: 'DM Mono', weights: ['400', '700'], italic: true },
          { name: 'mono', provider: 'none' },
        ],
        mono: ['Fira Code', 'Fira Mono:400,700'],
        lobster: [{ name: 'lobster', weights: ['400', '700'], italic: true }],
        lato: [
          { name: 'Lato', weights: ['400', '700'], italic: true },
          { name: 'sans-serif', provider: 'none' },
        ],
        crimson: [{ name: 'crimson pro', weights: ['400', '700'], italic: true }],
        inter: [{ name: 'inter', weights: ['400', '700'], italic: true }],
        merriweather: [{ name: 'Merriweather-Black', weights: ['400', '700'], italic: true }],
        raleway: [{ name: 'Raleway', weights: ['400', '700'], italic: true }],
        roboto: [
          { name: 'Roboto', weights: ['400', '700'], italic: true },
          { name: 'sans-serif', provider: 'none' },
        ],
      },
      processors: createLocalFontProcessor({
        cacheDir: 'node_modules/.cache/unocss/fonts',
        fontAssetsDir: 'public/fonts',
        fontServeBaseUrl: '/fonts',
      }),
    }),
  ],
  variants: [
    (matcher) => {
      if (!matcher.startsWith('hover:'))
        return matcher
      return {
        matcher: matcher.slice(6),
        selector: s => `${s}:hover`,
      }
    },
  ],
preflights: [
  // 変数・土台
  tokensPreflight(),
  preflightBase,
  preflightStickyFooter,
  preflightContent,
  preflightLayout,

  // レイアウト/ヘッダの骨組み
  preflightHeader,
  preflightWpAdmin,
  preflightNavSolid,
  preflightHeaderDesktopRow,
  preflightThemeIcons,

  // モバイル統合（PCナビを消し、#mobile-menuを制御）
  preflightMobileMenu,

  // （必要なら）PCナビ軽微修正はここまで。※残すなら Enforce より前に
  // preflightNavDesktopFix,

  // ページ別・小物（このあたりはナビに影響しない想定）
  preflightTop,
  preflightArchive,
  preflightSingle,
  preflightDocs,
  preflightBiblio,
  preflightFooter,
  preflightForms,
  preflightSearch,
  preflightComments,
  preflightBreadcrumbs,
  preflightChildPages,
  preflight404,
  preflightSidebar,
  preflightPrint,
  preflightA11y,
  preflightSyntax,
  tabsPreflight,
  preflightRelated,
  preflightAuthor,
  preflightThemeTransition,
  preflightHeroFeature,
  preflightHeroPage,
  preflightFooterVisibilityGuard,

  // ★最後：PCの「右寄せ + サブ初期非表示」を最終上書き
  // preflightNavDesktopEnforce,
].filter(Boolean),

  rules: [
    ...setProperty('m', ['margin']),
    ...setProperty('mt', ['margin-top']),
    ...setProperty('mr', ['margin-right']),
    ...setProperty('mb', ['margin-bottom']),
    ...setProperty('ml', ['margin-left']),
    ...setProperty('mx', ['margin-inline']),
    ...setProperty('my', ['margin-block']),
    ...setProperty('p', ['padding']),
    ...setProperty('pt', ['padding-top']),
    ...setProperty('pr', ['padding-right']),
    ...setProperty('pb', ['padding-bottom']),
    ...setProperty('pl', ['padding-left']),
    ...setProperty('px', ['padding-inline']),
    ...setProperty('py', ['padding-block']),
    ...setProperty('text', ['font-size']),
    ...setProperty('gap', ['gap']),
    ...setProperty('gap-x', ['column-gap']),
    ...setProperty('gap-y', ['row-gap']),
    ...setProperty('h', ['height']),
    ...setProperty('min-h', ['min-height']),
    ...setProperty('max-h', ['max-height']),
    ...setProperty('w', ['width']),
    ...setProperty('min-w', ['min-width']),
    ...setProperty('max-w', ['max-width']),
    ...setProperty('border', ['border-width']),
    ...setProperty('border-t', ['border-top-width']),
    ...setProperty('border-r', ['border-right-width']),
    ...setProperty('border-b', ['border-bottom-width']),
    ...setProperty('border-l', ['border-left-width']),
    ...setProperty('rounded', ['border-radius']),
    ...setProperty('rounded-t', ['border-top-left-radius', 'border-top-right-radius']),
    ...setProperty('rounded-r', ['border-top-right-radius', 'border-bottom-right-radius']),
    ...setProperty('rounded-b', ['border-bottom-right-radius', 'border-bottom-left-radius']),
    ...setProperty('rounded-l', ['border-top-left-radius', 'border-bottom-left-radius']),
    ...setProperty('rounded-tl', ['border-top-left-radius']),
    ...setProperty('rounded-tr', ['border-top-right-radius']),
    ...setProperty('rounded-br', ['border-bottom-right-radius']),
    ...setProperty('rounded-bl', ['border-bottom-left-radius']),
    ...setProperty('top', ['top']),
    ...setProperty('right', ['right']),
    ...setProperty('bottom', ['bottom']),
    ...setProperty('left', ['left']),
    ...setProperty('inset', ['inset']),
    ...setProperty('translate-y', ['--un-translate-y'], { transform: 'translateX(var(--un-translate-x)) translateY(var(--un-translate-y)) translateZ(var(--un-translate-z)) rotate(var(--un-rotate)) rotateX(var(--un-rotate-x)) rotateY(var(--un-rotate-y)) rotateZ(var(--un-rotate-z)) skewX(var(--un-skew-x)) skewY(var(--un-skew-y)) scaleX(var(--un-scale-x)) scaleY(var(--un-scale-y)) scaleZ(var(--un-scale-z))' }),
    ...setProperty('translate-x', ['--un-translate-x'], { transform: 'translateX(var(--un-translate-x)) translateY(var(--un-translate-y)) translateZ(var(--un-translate-z)) rotate(var(--un-rotate)) rotateX(var(--un-rotate-x)) rotateY(var(--un-rotate-y)) rotateZ(var(--un-rotate-z)) skewX(var(--un-skew-x)) skewY(var(--un-skew-y)) scaleX(var(--un-scale-x)) scaleY(var(--un-scale-y)) scaleZ(var(--un-scale-z))' }),
    [/^tracking-(\d+)$/, ([, d]) => ({ 'letter-spacing': `${Number(d) / 1000}em` })],

   // 4) Sassの “引数あり mixin” を動的ルール化

    // 例: emboss-box-<x>-<y>-<alpha> → box-shadow に変換
    [/^emboss-box-(\d+)-(\d+)-(\d+)$/, ([, x, y, a]) => {
      const alpha = (+a / 100).toFixed(2)
      return {
        'box-shadow': `rgba(0,0,0,${alpha}) -${x}px ${y}px, #fff -${x}px ${y}px inset`,
      }
    }],

    // 例: pm-ts-000-10 → text-shadow
    [/^pm-ts-(\d+)-(\d+)-(\d+)$/, ([, r, g, b]) => ({
      'text-shadow': `${+r}px -${+g}px rgba(0,0,0,${(+b/100).toFixed(2)})`,
    })],

    // "ズル線" rules
    [
      /^pm-line-top-(\d+)-(\d+)$/,
      ([, black, white]) => ({
        'border-top': `1px solid rgba(0, 0, 0, ${Number.parseInt(black) / 100})`,
        'box-shadow': `rgba(255, 255, 255, ${Number.parseInt(white) / 100}) 0 1px 0 inset`,
      }),
    ],
    [
      /^pm-line-left-(\d+)-(\d+)$/,
      ([, black, white]) => ({
        'border-left': `1px solid rgba(0, 0, 0, ${Number.parseInt(black) / 100})`,
        'box-shadow': `rgba(255, 255, 255, ${Number.parseInt(white) / 100}) -1px 0 0`,
      }),
    ],
    [
      /^pm-line-right-(\d+)-(\d+)$/,
      ([, black, white]) => ({
        'border-right': `1px solid rgba(0, 0, 0, ${Number.parseInt(black) / 100})`,
        'box-shadow': `rgba(255, 255, 255, ${Number.parseInt(white) / 100}) -1px 0 0 inset`,
      }),
    ],
    [
      /^pm-line-bottom-(\d+)-(\d+)$/,
      ([, black, white]) => ({
        'border-bottom': `1px solid rgba(0, 0, 0, ${Number.parseInt(black) / 100})`,
        'box-shadow': `rgba(255, 255, 255, ${Number.parseInt(white) / 100}) 0 1px 0`,
      }),
    ],
    // "ズルテキストシャドウ" rules
    [
      /^pm-ts-000-(\d+)$/,
      ([, op]) => ({
        'text-shadow': `1px -1px rgba(0, 0, 0, ${Number.parseInt(op) / 100})`,
      }),
    ],
    [
      /^dark:pm-ts-000-(\d+)$/,
      ([, op]) => ({
        'text-shadow': `1px -1px rgba(255, 255, 255, ${Number.parseInt(op) / 100})`,
      }),
    ],
    [
      /^pm-ts-fff-(\d+)$/,
      ([, op]) => ({
        'text-shadow': `-1px 1px rgba(255, 255, 255, ${Number.parseInt(op) / 100})`,
      }),
    ],
    // "ズルグラデーション" rules
    [
      /^pm-gradient-top-lighten-(\w+)-(\w+)$/,
      ([, fromColor, toColor]) => ({
        'background-image': `linear-gradient(to top, var(--un-color-${fromColor}) 0%, var(--un-color-${toColor}) 100%)`,
      }),
    ],
    [
      /^pm-gradient-top-darken-(\w+)-(\w+)$/,
      ([, fromColor, toColor]) => ({
        'background-image': `linear-gradient(to top, var(--un-color-${fromColor}) 0%, var(--un-color-${toColor}) 100%)`,
      }),
    ],
    // "ズルbox-shadow" rules
    [
      /^pm-box-(\d+)$/,
      ([, shadow]) => ({
        'box-shadow': `rgba(0, 0, 0, ${Number.parseInt(shadow) / 100}) 0 0 2px`,
      }),
    ],
    [
      /^rich-box-(\d+)$/,
      ([, shadow]) => ({
        'box-shadow': `rgba(0, 0, 0, ${Number.parseInt(shadow) / 100}) 0 0 0 20px inset`,
      }),
    ],
    [
      /^dark:emboss-box-(\d+)-(\d+)-(\d+)$/,
      ([, border, shadow, highlight]) => ({
        'border': `1px solid rgba(255, 255, 255, ${Number.parseInt(border) / 100})`,
        'box-shadow': `rgba(255, 255, 255, ${Number.parseInt(shadow) / 100}) -1px 1px 0, rgba(0, 0, 0, ${Number.parseInt(highlight) / 100}) -1px 1px 0 inset`,
      }),
    ],
    // Rule for heading04-3 pseudo-elements
    // Example usage: heading04-3-pseudo-white-555
    [
      /^heading04-3-pseudo-(.+)-(.+)$/,
      ([, bg, borderColor], { theme }) => {
        const bgColor = __resolveColor(theme, bg);
        const bdrColor = __resolveColor(theme, borderColor);
        return {
          // 必要なら left の調整も変数で
          // '--h043-left-after': '33px',
          // '--h043-left-before': '30px',
          '--h043-bg':  bgColor,
          '--h043-bdr': bdrColor,
          };
        },
    ],
    // Rule for heading04-3 pseudo-elements (dark mode)
    // Example usage: dark:heading04-3-pseudo-surface-800-surface-500
    [
      /^dark:heading04-3-pseudo-(.+)-(.+)$/,
      ([, bg, borderColor], { theme }) => {
        const bgColor = __resolveColor(theme, bg);
        const bdrColor = __resolveColor(theme, borderColor);
        return {
          '--h043-bg':  bgColor,
          '--h043-bdr': bdrColor,
          };
        },
    ],
    // Rule for heading13-4 pseudo-element
    // Example usage: heading13-4-pseudo-9999d4
    [
      /^heading13-4-pseudo-(.+)$/,
      ([, bg], { theme }) => {
        const bgColor = __resolveColor(theme, bg);
        return {
          // '--h134-left': '0.5em', '--h134-w': '8px', '--h134-h': '30px', '--h134-radius': '2px', // ←必要なら可変に
          '--h134-bg': bgColor,
          };
        },
    ],
    // Rule for heading13-4 pseudo-element (dark mode)
    // Example usage: dark:heading13-4-pseudo-surface-700
    [
      /^dark:heading13-4-pseudo-(.+)$/,
      ([, bg], { theme }) => {
        const bgColor = __resolveColor(theme, bg);
        return {
          '--h134-bg': bgColor,
        };
      },
    ],
    // ── 基本4方向 ───────────────────────────────────────────
    [/^pm-balloon-bottom-(\d+)-(.+)-(\d+)$/, ([, size, color, left], { theme }) => {
      const s = Number(size), l = Number(left);
      const c = __resolveColor(theme, color);
      return {
        '--pm-bottom': `-${s * 2}px`,
        '--pm-left': `${l}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-top': `${s}px solid ${c}`,
      };
    }],

    [/^pm-balloon-top-(\d+)-(.+)-(\d+)$/, ([, size, color, left], { theme }) => {
      const s = Number(size), l = Number(left);
      const c = __resolveColor(theme, color);
      return {
        '--pm-top': `-${s * 2}px`,
        '--pm-left': `${l}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-bottom': `${s}px solid ${c}`,
      };
    }],

    [/^pm-balloon-left-(\d+)-(.+)-(\d+)$/, ([, size, color, top], { theme }) => {
      const s = Number(size), t = Number(top);
      const c = __resolveColor(theme, color);
      return {
        '--pm-top': `${t}px`,
        '--pm-left': `-${s * 2}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-right': `${s}px solid ${c}`,
      };
    }],

    [/^pm-balloon-right-(\d+)-(.+)-(\d+)$/, ([, size, color, top], { theme }) => {
      const s = Number(size), t = Number(top);
      const c = __resolveColor(theme, color);
      return {
        '--pm-top': `${t}px`,
        '--pm-right': `-${s * 2}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-left': `${s}px solid ${c}`,
      };
    }],

    // ── ボーダー付き（外側＝::before, 内側＝::after） ───────
    [/^pm-balloon-top-border-(\d+)-(.+)-(\d+)-(.+)-(\d+)$/, ([, size, color, left, borderColor, border], { theme }) => {
      const s = Number(size), b = Number(border), s2 = s + b, l = Number(left);
      const c = __resolveColor(theme, color);
      const bc = __resolveColor(theme, borderColor);
      return {
        // 内側（after）
        '--pm-top': `-${s * 2}px`,
        '--pm-left': `${l}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-bottom': `${s}px solid ${c}`,
        // 外側（before）
        '--pm2-top': `-${s2 * 2}px`,
        '--pm2-left': `${l - b}px`,
        '--pm2-border': `${s2}px solid ${bc}`,
        '--pm2-border-bottom': `${s}px solid ${c}`,
      };
    }],

    [/^pm-balloon-bottom-border-(\d+)-(.+)-(\d+)-(.+)-(\d+)$/, ([, size, color, left, borderColor, border], { theme }) => {
      const s = Number(size), b = Number(border), s2 = s + b, l = Number(left);
      const c = __resolveColor(theme, color);
      const bc = __resolveColor(theme, borderColor);
      return {
        // 内側（after）
        '--pm-bottom': `-${s * 2}px`,
        '--pm-left': `${l}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-top': `${s}px solid ${c}`,
        // 外側（before）
        '--pm2-bottom': `-${s2 * 2}px`,
        '--pm2-left': `${l - b}px`,
        '--pm2-border': `${s2}px solid ${bc}`,
        '--pm2-border-top': `${s}px solid ${c}`,
      };
    }],

    [/^pm-balloon-left-border-(\d+)-(.+)-(\d+)-(.+)-(\d+)$/, ([, size, color, top, borderColor, border], { theme }) => {
      const s = Number(size), b = Number(border), s2 = s + b, t = Number(top);
      const c = __resolveColor(theme, color);
      const bc = __resolveColor(theme, borderColor);
      return {
        // 内側（after）
        '--pm-top': `${t}px`,
        '--pm-left': `-${s * 2}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-right': `${s}px solid ${c}`,
        // 外側（before）
        '--pm2-top': `${t - b}px`,
        '--pm2-left': `-${s2 * 2}px`,
        '--pm2-border': `${s2}px solid ${bc}`,
        '--pm2-border-right': `${s}px solid ${c}`,
      };
    }],

    [/^pm-balloon-right-border-(\d+)-(.+)-(\d+)-(.+)-(\d+)$/, ([, size, color, top, borderColor, border], { theme }) => {
      const s = Number(size), b = Number(border), s2 = s + b, t = Number(top);
      const c = __resolveColor(theme, color);
      const bc = __resolveColor(theme, borderColor);
      return {
        // 内側（after）
        '--pm-top': `${t}px`,
        '--pm-right': `-${s * 2}px`,
        '--pm-border': `${s}px solid transparent`,
        '--pm-border-left': `${s}px solid ${c}`,
        // 外側（before）
        '--pm2-top': `${t - b}px`,
        '--pm2-right': `-${s2 * 2}px`,
        '--pm2-border': `${s2}px solid ${bc}`,
        '--pm2-border-left': `${s}px solid ${c}`,
      };
    }],
  // 見出しブロック内の a（通常）
  ['latest-title-link', { color: 'rgb(47 79 79 / 0.9)', 'text-decoration': 'none' },
    { layer: 'my-layer', selector: '.latest-columns-title-style a' } ],
  // ダーク通常
  ['latest-title-link-dark', { color: '#fff' },
    { layer: 'my-layer', selector: '.dark .latest-columns-title-style a' } ],
  // 状態
  ['latest-title-link-hover', { color: '#2563eb', 'text-decoration': 'underline' },
    { layer: 'my-layer', selector: '.latest-columns-title-style a:hover, .latest-columns-title-style a:focus-visible' } ],
  ['latest-title-link-visited', { color: '#7c3aed' },
    { layer: 'my-layer', selector: '.latest-columns-title-style a:visited' } ],
  ['latest-title-link-active', { color: '#dc2626' },
    { layer: 'my-layer', selector: '.latest-columns-title-style a:active' } ],

  // machaki 用（必要なら色違いで複製）
  ['machaki-title-link', { color: 'rgb(47 79 79 / 0.9)', 'text-decoration': 'none' },
    { layer: 'my-layer', selector: '.machaki-group-title-style a' } ],
  ['machaki-title-link-dark', { color: '#fff' },
    { layer: 'my-layer', selector: '.dark .machaki-group-title-style a' } ],
  ['machaki-title-link-hover', { color: '#16a34a', 'text-decoration': 'underline' },
    { layer: 'my-layer', selector: '.machaki-group-title-style a:hover, .machaki-group-title-style a:focus-visible' } ],
  ['machaki-title-link-visited', { color: '#7c3aed' },
    { layer: 'my-layer', selector: '.machaki-group-title-style a:visited' } ],
  ['machaki-title-link-active', { color: '#dc2626' },
    { layer: 'my-layer', selector: '.machaki-group-title-style a:active' } ],
  // #machaki-pickup に当てる本来のmixin相当（例）
  ['machaki-pickup-style', {
    // ここに本来のSCSSから移したプロパティを書く
    // 例: 'scroll-margin-top': '6rem', '--gap':'1rem', など
  }, { layer: 'my-layer', selector: '#machaki-pickup' }],

  // #latest-columns も同様
  ['latest-columns-style', {
    // 必要なプロパティを移植
  }, { layer: 'my-layer', selector: '#latest-columns' }],
  ],
  transformers: [
    transformerDirectives({ applyVariable: ['--at-apply', '--uno-apply', '--uno'] }),
    transformerVariantGroup(),
    transformerCompileClass(),
    transformerAttributifyJsx({
          exclude: [/node_modules/],
    }),
    transformerAlias(),
  ],
})

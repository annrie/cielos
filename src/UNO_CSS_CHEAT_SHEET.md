# UNO.CSS チートシート

UNO.CSSの主要なユーティリティクラス（予約語）の包括的なリファレンスです。

## 目次

1. [レイアウト](#レイアウト)
2. [フレックスボックス](#フレックスボックス)
3. [グリッド](#グリッド)
4. [間隔（スペーシング）](#間隔スペーシング)
5. [サイズ](#サイズ)
6. [タイポグラフィ](#タイポグラフィ)
7. [カラー](#カラー)
8. [背景](#背景)
9. [ボーダー](#ボーダー)
10. [効果（エフェクト）](#効果エフェクト)
11. [インタラクティブ](#インタラクティブ)
12. [トランジション・アニメーション](#トランジションアニメーション)
13. [フィルター](#フィルター)
14. [変換（Transform）](#変換transform)
15. [位置（Position）](#位置position)

## レイアウト

### Display
```css
/* Display */
block            /* display: block */
inline-block     /* display: inline-block */
inline           /* display: inline */
flex             /* display: flex */
inline-flex      /* display: inline-flex */
grid             /* display: grid */
inline-grid      /* display: inline-grid */
table            /* display: table */
table-cell       /* display: table-cell */
table-row        /* display: table-row */
hidden           /* display: none */

/* Visibility */
visible          /* visibility: visible */
invisible        /* visibility: hidden */

/* Overflow */
overflow-auto    /* overflow: auto */
overflow-hidden  /* overflow: hidden */
overflow-visible /* overflow: visible */
overflow-scroll  /* overflow: scroll */
overflow-x-auto  /* overflow-x: auto */
overflow-y-auto  /* overflow-y: auto */
overflow-x-hidden /* overflow-x: hidden */
overflow-y-hidden /* overflow-y: hidden */
```

### Position
```css
/* Position */
static           /* position: static */
fixed            /* position: fixed */
absolute         /* position: absolute */
relative         /* position: relative */
sticky           /* position: sticky */

/* Top, Right, Bottom, Left */
top-0            /* top: 0 */
top-1            /* top: 0.25rem */
top-2            /* top: 0.5rem */
top-4            /* top: 1rem */
top-auto         /* top: auto */
top-1/2          /* top: 50% */
top-full         /* top: 100% */

right-0          /* right: 0 */
right-1          /* right: 0.25rem */
right-auto       /* right: auto */

bottom-0         /* bottom: 0 */
bottom-1         /* bottom: 0.25rem */
bottom-auto      /* bottom: auto */

left-0           /* left: 0 */
left-1           /* left: 0.25rem */
left-auto        /* left: auto */

/* Z-index */
z-0              /* z-index: 0 */
z-10             /* z-index: 10 */
z-20             /* z-index: 20 */
z-30             /* z-index: 30 */
z-40             /* z-index: 40 */
z-50             /* z-index: 50 */
z-auto           /* z-index: auto */
```

## フレックスボックス

### Flex Container
```css
/* Flex Direction */
flex-row         /* flex-direction: row */
flex-row-reverse /* flex-direction: row-reverse */
flex-col         /* flex-direction: column */
flex-col-reverse /* flex-direction: column-reverse */

/* Flex Wrap */
flex-wrap        /* flex-wrap: wrap */
flex-wrap-reverse /* flex-wrap: wrap-reverse */
flex-nowrap      /* flex-wrap: nowrap */

/* Justify Content */
justify-start    /* justify-content: flex-start */
justify-end      /* justify-content: flex-end */
justify-center   /* justify-content: center */
justify-between  /* justify-content: space-between */
justify-around   /* justify-content: space-around */
justify-evenly   /* justify-content: space-evenly */

/* Align Items */
items-start      /* align-items: flex-start */
items-end        /* align-items: flex-end */
items-center     /* align-items: center */
items-baseline   /* align-items: baseline */
items-stretch    /* align-items: stretch */

/* Align Content */
content-start    /* align-content: flex-start */
content-end      /* align-content: flex-end */
content-center   /* align-content: center */
content-between  /* align-content: space-between */
content-around   /* align-content: space-around */
content-evenly   /* align-content: space-evenly */
```

### Flex Items
```css
/* Flex */
flex-1           /* flex: 1 1 0% */
flex-auto        /* flex: 1 1 auto */
flex-initial     /* flex: 0 1 auto */
flex-none        /* flex: none */

/* Flex Grow */
flex-grow        /* flex-grow: 1 */
flex-grow-0      /* flex-grow: 0 */

/* Flex Shrink */
flex-shrink      /* flex-shrink: 1 */
flex-shrink-0    /* flex-shrink: 0 */

/* Align Self */
self-auto        /* align-self: auto */
self-start       /* align-self: flex-start */
self-end         /* align-self: flex-end */
self-center      /* align-self: center */
self-stretch     /* align-self: stretch */
self-baseline    /* align-self: baseline */

/* Order */
order-1          /* order: 1 */
order-2          /* order: 2 */
order-first      /* order: -9999 */
order-last       /* order: 9999 */
order-none       /* order: 0 */
```

## グリッド

### Grid Container
```css
/* Grid Template Columns */
grid-cols-1      /* grid-template-columns: repeat(1, minmax(0, 1fr)) */
grid-cols-2      /* grid-template-columns: repeat(2, minmax(0, 1fr)) */
grid-cols-3      /* grid-template-columns: repeat(3, minmax(0, 1fr)) */
grid-cols-4      /* grid-template-columns: repeat(4, minmax(0, 1fr)) */
grid-cols-5      /* grid-template-columns: repeat(5, minmax(0, 1fr)) */
grid-cols-6      /* grid-template-columns: repeat(6, minmax(0, 1fr)) */
grid-cols-12     /* grid-template-columns: repeat(12, minmax(0, 1fr)) */
grid-cols-none   /* grid-template-columns: none */

/* Grid Template Rows */
grid-rows-1      /* grid-template-rows: repeat(1, minmax(0, 1fr)) */
grid-rows-2      /* grid-template-rows: repeat(2, minmax(0, 1fr)) */
grid-rows-3      /* grid-template-rows: repeat(3, minmax(0, 1fr)) */
grid-rows-4      /* grid-template-rows: repeat(4, minmax(0, 1fr)) */
grid-rows-6      /* grid-template-rows: repeat(6, minmax(0, 1fr)) */
grid-rows-none   /* grid-template-rows: none */

/* Gap */
gap-0            /* gap: 0px */
gap-1            /* gap: 0.25rem */
gap-2            /* gap: 0.5rem */
gap-3            /* gap: 0.75rem */
gap-4            /* gap: 1rem */
gap-5            /* gap: 1.25rem */
gap-6            /* gap: 1.5rem */
gap-8            /* gap: 2rem */

gap-x-0          /* column-gap: 0px */
gap-x-1          /* column-gap: 0.25rem */
gap-x-2          /* column-gap: 0.5rem */

gap-y-0          /* row-gap: 0px */
gap-y-1          /* row-gap: 0.25rem */
gap-y-2          /* row-gap: 0.5rem */
```

### Grid Items
```css
/* Grid Column Start / End */
col-auto         /* grid-column: auto */
col-span-1       /* grid-column: span 1 / span 1 */
col-span-2       /* grid-column: span 2 / span 2 */
col-span-3       /* grid-column: span 3 / span 3 */
col-span-full    /* grid-column: 1 / -1 */
col-start-1      /* grid-column-start: 1 */
col-start-2      /* grid-column-start: 2 */
col-end-1        /* grid-column-end: 1 */
col-end-2        /* grid-column-end: 2 */

/* Grid Row Start / End */
row-auto         /* grid-row: auto */
row-span-1       /* grid-row: span 1 / span 1 */
row-span-2       /* grid-row: span 2 / span 2 */
row-span-3       /* grid-row: span 3 / span 3 */
row-span-full    /* grid-row: 1 / -1 */
row-start-1      /* grid-row-start: 1 */
row-start-2      /* grid-row-start: 2 */
row-end-1        /* grid-row-end: 1 */
row-end-2        /* grid-row-end: 2 */
```

## 間隔（スペーシング）

### Padding
```css
/* All sides */
p-0              /* padding: 0px */
p-1              /* padding: 0.25rem */
p-2              /* padding: 0.5rem */
p-3              /* padding: 0.75rem */
p-4              /* padding: 1rem */
p-5              /* padding: 1.25rem */
p-6              /* padding: 1.5rem */
p-8              /* padding: 2rem */
p-10             /* padding: 2.5rem */
p-12             /* padding: 3rem */
p-16             /* padding: 4rem */
p-20             /* padding: 5rem */
p-24             /* padding: 6rem */
p-32             /* padding: 8rem */

/* Horizontal */
px-0             /* padding-left: 0px; padding-right: 0px */
px-1             /* padding-left: 0.25rem; padding-right: 0.25rem */
px-2             /* padding-left: 0.5rem; padding-right: 0.5rem */
px-4             /* padding-left: 1rem; padding-right: 1rem */

/* Vertical */
py-0             /* padding-top: 0px; padding-bottom: 0px */
py-1             /* padding-top: 0.25rem; padding-bottom: 0.25rem */
py-2             /* padding-top: 0.5rem; padding-bottom: 0.5rem */
py-4             /* padding-top: 1rem; padding-bottom: 1rem */

/* Individual sides */
pt-0             /* padding-top: 0px */
pr-0             /* padding-right: 0px */
pb-0             /* padding-bottom: 0px */
pl-0             /* padding-left: 0px */
pt-1             /* padding-top: 0.25rem */
pr-1             /* padding-right: 0.25rem */
pb-1             /* padding-bottom: 0.25rem */
pl-1             /* padding-left: 0.25rem */
```

### Margin
```css
/* All sides */
m-0              /* margin: 0px */
m-1              /* margin: 0.25rem */
m-2              /* margin: 0.5rem */
m-3              /* margin: 0.75rem */
m-4              /* margin: 1rem */
m-5              /* margin: 1.25rem */
m-6              /* margin: 1.5rem */
m-8              /* margin: 2rem */
m-10             /* margin: 2.5rem */
m-12             /* margin: 3rem */
m-16             /* margin: 4rem */
m-auto           /* margin: auto */

/* Horizontal */
mx-0             /* margin-left: 0px; margin-right: 0px */
mx-1             /* margin-left: 0.25rem; margin-right: 0.25rem */
mx-2             /* margin-left: 0.5rem; margin-right: 0.5rem */
mx-4             /* margin-left: 1rem; margin-right: 1rem */
mx-auto          /* margin-left: auto; margin-right: auto */

/* Vertical */
my-0             /* margin-top: 0px; margin-bottom: 0px */
my-1             /* margin-top: 0.25rem; margin-bottom: 0.25rem */
my-2             /* margin-top: 0.5rem; margin-bottom: 0.5rem */
my-4             /* margin-top: 1rem; margin-bottom: 1rem */

/* Individual sides */
mt-0             /* margin-top: 0px */
mr-0             /* margin-right: 0px */
mb-0             /* margin-bottom: 0px */
ml-0             /* margin-left: 0px */
mt-1             /* margin-top: 0.25rem */
mr-1             /* margin-right: 0.25rem */
mb-1             /* margin-bottom: 0.25rem */
ml-1             /* margin-left: 0.25rem */

/* Negative margins */
-m-1             /* margin: -0.25rem */
-m-2             /* margin: -0.5rem */
-mt-1            /* margin-top: -0.25rem */
-mr-1            /* margin-right: -0.25rem */
-mb-1            /* margin-bottom: -0.25rem */
-ml-1            /* margin-left: -0.25rem */
```

### Space Between
```css
/* Space between children */
space-x-0        /* margin-left: 0px (for children) */
space-x-1        /* margin-left: 0.25rem (for children) */
space-x-2        /* margin-left: 0.5rem (for children) */
space-x-4        /* margin-left: 1rem (for children) */
space-x-reverse  /* flex-direction: row-reverse */

space-y-0        /* margin-top: 0px (for children) */
space-y-1        /* margin-top: 0.25rem (for children) */
space-y-2        /* margin-top: 0.5rem (for children) */
space-y-4        /* margin-top: 1rem (for children) */
space-y-reverse  /* flex-direction: column-reverse */
```

## サイズ

### Width
```css
/* Fixed widths */
w-0              /* width: 0px */
w-1              /* width: 0.25rem */
w-2              /* width: 0.5rem */
w-3              /* width: 0.75rem */
w-4              /* width: 1rem */
w-5              /* width: 1.25rem */
w-6              /* width: 1.5rem */
w-8              /* width: 2rem */
w-10             /* width: 2.5rem */
w-12             /* width: 3rem */
w-16             /* width: 4rem */
w-20             /* width: 5rem */
w-24             /* width: 6rem */
w-32             /* width: 8rem */
w-40             /* width: 10rem */
w-48             /* width: 12rem */
w-56             /* width: 14rem */
w-64             /* width: 16rem */

/* Percentage widths */
w-1/2            /* width: 50% */
w-1/3            /* width: 33.333333% */
w-2/3            /* width: 66.666667% */
w-1/4            /* width: 25% */
w-2/4            /* width: 50% */
w-3/4            /* width: 75% */
w-1/5            /* width: 20% */
w-2/5            /* width: 40% */
w-3/5            /* width: 60% */
w-4/5            /* width: 80% */
w-1/6            /* width: 16.666667% */
w-5/6            /* width: 83.333333% */
w-1/12           /* width: 8.333333% */
w-11/12          /* width: 91.666667% */
w-full           /* width: 100% */

/* Viewport widths */
w-screen         /* width: 100vw */

/* Auto widths */
w-auto           /* width: auto */
w-min            /* width: min-content */
w-max            /* width: max-content */
w-fit            /* width: fit-content */
```

### Height
```css
/* Fixed heights */
h-0              /* height: 0px */
h-1              /* height: 0.25rem */
h-2              /* height: 0.5rem */
h-3              /* height: 0.75rem */
h-4              /* height: 1rem */
h-5              /* height: 1.25rem */
h-6              /* height: 1.5rem */
h-8              /* height: 2rem */
h-10             /* height: 2.5rem */
h-12             /* height: 3rem */
h-16             /* height: 4rem */
h-20             /* height: 5rem */
h-24             /* height: 6rem */
h-32             /* height: 8rem */
h-40             /* height: 10rem */
h-48             /* height: 12rem */
h-56             /* height: 14rem */
h-64             /* height: 16rem */

/* Percentage heights */
h-1/2            /* height: 50% */
h-1/3            /* height: 33.333333% */
h-2/3            /* height: 66.666667% */
h-1/4            /* height: 25% */
h-3/4            /* height: 75% */
h-1/5            /* height: 20% */
h-4/5            /* height: 80% */
h-1/6            /* height: 16.666667% */
h-5/6            /* height: 83.333333% */
h-full           /* height: 100% */

/* Viewport heights */
h-screen         /* height: 100vh */

/* Auto heights */
h-auto           /* height: auto */
h-min            /* height: min-content */
h-max            /* height: max-content */
h-fit            /* height: fit-content */
```

### Min/Max Width & Height
```css
/* Min Width */
min-w-0          /* min-width: 0px */
min-w-full       /* min-width: 100% */
min-w-min        /* min-width: min-content */
min-w-max        /* min-width: max-content */
min-w-fit        /* min-width: fit-content */

/* Max Width */
max-w-0          /* max-width: 0rem */
max-w-xs         /* max-width: 20rem */
max-w-sm         /* max-width: 24rem */
max-w-md         /* max-width: 28rem */
max-w-lg         /* max-width: 32rem */
max-w-xl         /* max-width: 36rem */
max-w-2xl        /* max-width: 42rem */
max-w-3xl        /* max-width: 48rem */
max-w-4xl        /* max-width: 56rem */
max-w-5xl        /* max-width: 64rem */
max-w-6xl        /* max-width: 72rem */
max-w-7xl        /* max-width: 80rem */
max-w-full       /* max-width: 100% */
max-w-screen-sm  /* max-width: 640px */
max-w-screen-md  /* max-width: 768px */
max-w-screen-lg  /* max-width: 1024px */
max-w-screen-xl  /* max-width: 1280px */

/* Min Height */
min-h-0          /* min-height: 0px */
min-h-full       /* min-height: 100% */
min-h-screen     /* min-height: 100vh */

/* Max Height */
max-h-0          /* max-height: 0px */
max-h-full       /* max-height: 100% */
max-h-screen     /* max-height: 100vh */
```

## タイポグラフィ

### Font Family
```css
font-sans        /* font-family: ui-sans-serif, system-ui, sans-serif */
font-serif       /* font-family: ui-serif, Georgia, serif */
font-mono        /* font-family: ui-monospace, monospace */
```

### Font Size
```css
text-xs          /* font-size: 0.75rem; line-height: 1rem */
text-sm          /* font-size: 0.875rem; line-height: 1.25rem */
text-base        /* font-size: 1rem; line-height: 1.5rem */
text-lg          /* font-size: 1.125rem; line-height: 1.75rem */
text-xl          /* font-size: 1.25rem; line-height: 1.75rem */
text-2xl         /* font-size: 1.5rem; line-height: 2rem */
text-3xl         /* font-size: 1.875rem; line-height: 2.25rem */
text-4xl         /* font-size: 2.25rem; line-height: 2.5rem */
text-5xl         /* font-size: 3rem; line-height: 1 */
text-6xl         /* font-size: 3.75rem; line-height: 1 */
text-7xl         /* font-size: 4.5rem; line-height: 1 */
text-8xl         /* font-size: 6rem; line-height: 1 */
text-9xl         /* font-size: 8rem; line-height: 1 */
```

### Font Weight
```css
font-thin        /* font-weight: 100 */
font-extralight  /* font-weight: 200 */
font-light       /* font-weight: 300 */
font-normal      /* font-weight: 400 */
font-medium      /* font-weight: 500 */
font-semibold    /* font-weight: 600 */
font-bold        /* font-weight: 700 */
font-extrabold   /* font-weight: 800 */
font-black       /* font-weight: 900 */
```

### Line Height
```css
leading-3        /* line-height: .75rem */
leading-4        /* line-height: 1rem */
leading-5        /* line-height: 1.25rem */
leading-6        /* line-height: 1.5rem */
leading-7        /* line-height: 1.75rem */
leading-8        /* line-height: 2rem */
leading-9        /* line-height: 2.25rem */
leading-10       /* line-height: 2.5rem */
leading-none     /* line-height: 1 */
leading-tight    /* line-height: 1.25 */
leading-snug     /* line-height: 1.375 */
leading-normal   /* line-height: 1.5 */
leading-relaxed  /* line-height: 1.625 */
leading-loose    /* line-height: 2 */
```

### Letter Spacing
```css
tracking-tighter /* letter-spacing: -0.05em */
tracking-tight   /* letter-spacing: -0.025em */
tracking-normal  /* letter-spacing: 0em */
tracking-wide    /* letter-spacing: 0.025em */
tracking-wider   /* letter-spacing: 0.05em */
tracking-widest  /* letter-spacing: 0.1em */
```

### Text Align
```css
text-left       /* text-align: left */
text-center     /* text-align: center */
text-right      /* text-align: right */
text-justify    /* text-align: justify */
text-start      /* text-align: start */
text-end        /* text-align: end */
```

### Text Transform
```css
uppercase       /* text-transform: uppercase */
lowercase       /* text-transform: lowercase */
capitalize      /* text-transform: capitalize */
normal-case     /* text-transform: none */
```

### Text Decoration
```css
underline       /* text-decoration-line: underline */
overline        /* text-decoration-line: overline */
line-through    /* text-decoration-line: line-through */
no-underline    /* text-decoration-line: none */
```

## カラー

### Text Color
```css
/* Grays */
text-black      /* color: rgb(0 0 0) */
text-white      /* color: rgb(255 255 255) */
text-gray-50    /* color: rgb(249 250 251) */
text-gray-100   /* color: rgb(243 244 246) */
text-gray-200   /* color: rgb(229 231 235) */
text-gray-300   /* color: rgb(209 213 219) */
text-gray-400   /* color: rgb(156 163 175) */
text-gray-500   /* color: rgb(107 114 128) */
text-gray-600   /* color: rgb(75 85 99) */
text-gray-700   /* color: rgb(55 65 81) */
text-gray-800   /* color: rgb(31 41 55) */
text-gray-900   /* color: rgb(17 24 39) */

/* Colors */
text-red-500    /* color: rgb(239 68 68) */
text-yellow-500 /* color: rgb(245 158 11) */
text-green-500  /* color: rgb(34 197 94) */
text-blue-500   /* color: rgb(59 130 246) */
text-indigo-500 /* color: rgb(99 102 241) */
text-purple-500 /* color: rgb(168 85 247) */
text-pink-500   /* color: rgb(236 72 153) */

/* All color variants available: 50, 100, 200, 300, 400, 500, 600, 700, 800, 900 */
text-red-50     /* Lightest */
text-red-100
text-red-200
text-red-300
text-red-400
text-red-500    /* Default */
text-red-600
text-red-700
text-red-800
text-red-900    /* Darkest */
```

### Background Color
```css
/* Grays */
bg-black        /* background-color: rgb(0 0 0) */
bg-white        /* background-color: rgb(255 255 255) */
bg-gray-50      /* background-color: rgb(249 250 251) */
bg-gray-100     /* background-color: rgb(243 244 246) */
bg-gray-500     /* background-color: rgb(107 114 128) */
bg-gray-900     /* background-color: rgb(17 24 39) */

/* Colors */
bg-red-500      /* background-color: rgb(239 68 68) */
bg-yellow-500   /* background-color: rgb(245 158 11) */
bg-green-500    /* background-color: rgb(34 197 94) */
bg-blue-500     /* background-color: rgb(59 130 246) */
bg-indigo-500   /* background-color: rgb(99 102 241) */
bg-purple-500   /* background-color: rgb(168 85 247) */
bg-pink-500     /* background-color: rgb(236 72 153) */

/* Transparency */
bg-transparent  /* background-color: transparent */
bg-current      /* background-color: currentColor */

/* Opacity variants */
bg-red-500/10   /* background-color: rgb(239 68 68 / 0.1) */
bg-red-500/20   /* background-color: rgb(239 68 68 / 0.2) */
bg-red-500/50   /* background-color: rgb(239 68 68 / 0.5) */
bg-red-500/75   /* background-color: rgb(239 68 68 / 0.75) */
bg-red-500/90   /* background-color: rgb(239 68 68 / 0.9) */
```

## 背景

### Background Size
```css
bg-auto         /* background-size: auto */
bg-cover        /* background-size: cover */
bg-contain      /* background-size: contain */
```

### Background Position
```css
bg-bottom       /* background-position: bottom */
bg-center       /* background-position: center */
bg-left         /* background-position: left */
bg-left-bottom  /* background-position: left bottom */
bg-left-top     /* background-position: left top */
bg-right        /* background-position: right */
bg-right-bottom /* background-position: right bottom */
bg-right-top    /* background-position: right top */
bg-top          /* background-position: top */
```

### Background Repeat
```css
bg-repeat       /* background-repeat: repeat */
bg-no-repeat    /* background-repeat: no-repeat */
bg-repeat-x     /* background-repeat: repeat-x */
bg-repeat-y     /* background-repeat: repeat-y */
bg-repeat-round /* background-repeat: round */
bg-repeat-space /* background-repeat: space */
```

### Background Attachment
```css
bg-fixed        /* background-attachment: fixed */
bg-local        /* background-attachment: local */
bg-scroll       /* background-attachment: scroll */
```

### Background Clip
```css
bg-clip-border  /* background-clip: border-box */
bg-clip-padding /* background-clip: padding-box */
bg-clip-content /* background-clip: content-box */
bg-clip-text    /* background-clip: text */
```

### Background Origin
```css
bg-origin-border  /* background-origin: border-box */
bg-origin-padding /* background-origin: padding-box */
bg-origin-content /* background-origin: content-box */
```

### Gradient
```css
/* Linear gradients */
bg-gradient-to-t    /* background-image: linear-gradient(to top, var(--un-gradient-stops)) */
bg-gradient-to-tr   /* background-image: linear-gradient(to top right, var(--un-gradient-stops)) */
bg-gradient-to-r    /* background-image: linear-gradient(to right, var(--un-gradient-stops)) */
bg-gradient-to-br   /* background-image: linear-gradient(to bottom right, var(--un-gradient-stops)) */
bg-gradient-to-b    /* background-image: linear-gradient(to bottom, var(--un-gradient-stops)) */
bg-gradient-to-bl   /* background-image: linear-gradient(to bottom left, var(--un-gradient-stops)) */
bg-gradient-to-l    /* background-image: linear-gradient(to left, var(--un-gradient-stops)) */
bg-gradient-to-tl   /* background-image: linear-gradient(to top left, var(--un-gradient-stops)) */

/* Gradient color stops */
from-purple-400     /* --un-gradient-from: #c084fc */
via-pink-500        /* --un-gradient-via: #ec4899 */
to-red-500          /* --un-gradient-to: #ef4444 */
```

## ボーダー

### Border Width
```css
border          /* border-width: 1px */
border-0        /* border-width: 0px */
border-2        /* border-width: 2px */
border-4        /* border-width: 4px */
border-8        /* border-width: 8px */

border-x        /* border-left-width: 1px; border-right-width: 1px */
border-y        /* border-top-width: 1px; border-bottom-width: 1px */
border-t        /* border-top-width: 1px */
border-r        /* border-right-width: 1px */
border-b        /* border-bottom-width: 1px */
border-l        /* border-left-width: 1px */

border-t-0      /* border-top-width: 0px */
border-r-0      /* border-right-width: 0px */
border-b-0      /* border-bottom-width: 0px */
border-l-0      /* border-left-width: 0px */
```

### Border Color
```css
border-black        /* border-color: rgb(0 0 0) */
border-white        /* border-color: rgb(255 255 255) */
border-gray-200     /* border-color: rgb(229 231 235) */
border-gray-300     /* border-color: rgb(209 213 219) */
border-red-500      /* border-color: rgb(239 68 68) */
border-blue-500     /* border-color: rgb(59 130 246) */
border-transparent  /* border-color: transparent */
border-current      /* border-color: currentColor */

/* Individual sides */
border-t-black      /* border-top-color: rgb(0 0 0) */
border-r-black      /* border-right-color: rgb(0 0 0) */
border-b-black      /* border-bottom-color: rgb(0 0 0) */
border-l-black      /* border-left-color: rgb(0 0 0) */
```

### Border Style
```css
border-solid    /* border-style: solid */
border-dashed   /* border-style: dashed */
border-dotted   /* border-style: dotted */
border-double   /* border-style: double */
border-hidden   /* border-style: hidden */
border-none     /* border-style: none */
```

### Border Radius
```css
rounded-none    /* border-radius: 0px */
rounded-sm      /* border-radius: 0.125rem */
rounded         /* border-radius: 0.25rem */
rounded-md      /* border-radius: 0.375rem */
rounded-lg      /* border-radius: 0.5rem */
rounded-xl      /* border-radius: 0.75rem */
rounded-2xl     /* border-radius: 1rem */
rounded-3xl     /* border-radius: 1.5rem */
rounded-full    /* border-radius: 9999px */

/* Individual corners */
rounded-t-none  /* border-top-left-radius: 0px; border-top-right-radius: 0px */
rounded-t-sm    /* border-top-left-radius: 0.125rem; border-top-right-radius: 0.125rem */
rounded-r-none  /* border-top-right-radius: 0px; border-bottom-right-radius: 0px */
rounded-b-none  /* border-bottom-right-radius: 0px; border-bottom-left-radius: 0px */
rounded-l-none  /* border-top-left-radius: 0px; border-bottom-left-radius: 0px */

rounded-tl-none /* border-top-left-radius: 0px */
rounded-tr-none /* border-top-right-radius: 0px */
rounded-br-none /* border-bottom-right-radius: 0px */
rounded-bl-none /* border-bottom-left-radius: 0px */
```

### Outline
```css
outline-none    /* outline: 2px solid transparent; outline-offset: 2px */
outline         /* outline-style: solid */
outline-dashed  /* outline-style: dashed */
outline-dotted  /* outline-style: dotted */
outline-double  /* outline-style: double */

outline-0       /* outline-width: 0px */
outline-1       /* outline-width: 1px */
outline-2       /* outline-width: 2px */
outline-4       /* outline-width: 4px */
outline-8       /* outline-width: 8px */

outline-black   /* outline-color: #000 */
outline-white   /* outline-color: #fff */
outline-red-500 /* outline-color: #ef4444 */

outline-offset-0 /* outline-offset: 0px */
outline-offset-1 /* outline-offset: 1px */
outline-offset-2 /* outline-offset: 2px */
outline-offset-4 /* outline-offset: 4px */
outline-offset-8 /* outline-offset: 8px */
```

### Ring
```css
ring-0          /* box-shadow: var(--un-ring-inset) 0 0 0 calc(0px + var(--un-ring-offset-width)) var(--un-ring-color) */
ring-1          /* box-shadow: var(--un-ring-inset) 0 0 0 calc(1px + var(--un-ring-offset-width)) var(--un-ring-color) */
ring-2          /* box-shadow: var(--un-ring-inset) 0 0 0 calc(2px + var(--un-ring-offset-width)) var(--un-ring-color) */
ring-4          /* box-shadow: var(--un-ring-inset) 0 0 0 calc(4px + var(--un-ring-offset-width)) var(--un-ring-color) */
ring-8          /* box-shadow: var(--un-ring-inset) 0 0 0 calc(8px + var(--un-ring-offset-width)) var(--un-ring-color) */
ring            /* box-shadow: var(--un-ring-inset) 0 0 0 calc(3px + var(--un-ring-offset-width)) var(--un-ring-color) */
ring-inset      /* --un-ring-inset: inset */

ring-black      /* --un-ring-color: rgb(0 0 0) */
ring-white      /* --un-ring-color: rgb(255 255 255) */
ring-gray-500   /* --un-ring-color: rgb(107 114 128) */
ring-red-500    /* --un-ring-color: rgb(239 68 68) */
ring-blue-500   /* --un-ring-color: rgb(59 130 246) */

ring-offset-0   /* --un-ring-offset-width: 0px */
ring-offset-1   /* --un-ring-offset-width: 1px */
ring-offset-2   /* --un-ring-offset-width: 2px */
ring-offset-4   /* --un-ring-offset-width: 4px */
ring-offset-8   /* --un-ring-offset-width: 8px */

ring-offset-black  /* --un-ring-offset-color: #000 */
ring-offset-white  /* --un-ring-offset-color: #fff */
```

## 効果（エフェクト）

### Box Shadow
```css
shadow-sm       /* box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) */
shadow          /* box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) */
shadow-md       /* box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) */
shadow-lg       /* box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1) */
shadow-xl       /* box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) */
shadow-2xl      /* box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25) */
shadow-inner    /* box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05) */
shadow-none     /* box-shadow: none */

/* Colored shadows */
shadow-red-500  /* box-shadow: 0 1px 3px 0 rgb(239 68 68 / 0.1), 0 1px 2px -1px rgb(239 68 68 / 0.1) */
shadow-blue-500 /* box-shadow: 0 1px 3px 0 rgb(59 130 246 / 0.1), 0 1px 2px -1px rgb(59 130 246 / 0.1) */
```

### Opacity
```css
opacity-0       /* opacity: 0 */
opacity-5       /* opacity: 0.05 */
opacity-10      /* opacity: 0.1 */
opacity-20      /* opacity: 0.2 */
opacity-25      /* opacity: 0.25 */
opacity-30      /* opacity: 0.3 */
opacity-40      /* opacity: 0.4 */
opacity-50      /* opacity: 0.5 */
opacity-60      /* opacity: 0.6 */
opacity-70      /* opacity: 0.7 */
opacity-75      /* opacity: 0.75 */
opacity-80      /* opacity: 0.8 */
opacity-90      /* opacity: 0.9 */
opacity-95      /* opacity: 0.95 */
opacity-100     /* opacity: 1 */
```

### Mix Blend Mode
```css
mix-blend-normal     /* mix-blend-mode: normal */
mix-blend-multiply   /* mix-blend-mode: multiply */
mix-blend-screen     /* mix-blend-mode: screen */
mix-blend-overlay    /* mix-blend-mode: overlay */
mix-blend-darken     /* mix-blend-mode: darken */
mix-blend-lighten    /* mix-blend-mode: lighten */
mix-blend-color-dodge /* mix-blend-mode: color-dodge */
mix-blend-color-burn  /* mix-blend-mode: color-burn */
mix-blend-hard-light  /* mix-blend-mode: hard-light */
mix-blend-soft-light  /* mix-blend-mode: soft-light */
mix-blend-difference  /* mix-blend-mode: difference */
mix-blend-exclusion   /* mix-blend-mode: exclusion */
```

### Background Blend Mode
```css
bg-blend-normal     /* background-blend-mode: normal */
bg-blend-multiply   /* background-blend-mode: multiply */
bg-blend-screen     /* background-blend-mode: screen */
bg-blend-overlay    /* background-blend-mode: overlay */
bg-blend-darken     /* background-blend-mode: darken */
bg-blend-lighten    /* background-blend-mode: lighten */
bg-blend-color-dodge /* background-blend-mode: color-dodge */
bg-blend-color-burn  /* background-blend-mode: color-burn */
bg-blend-hard-light  /* background-blend-mode: hard-light */
bg-blend-soft-light  /* background-blend-mode: soft-light */
bg-blend-difference  /* background-blend-mode: difference */
bg-blend-exclusion   /* background-blend-mode: exclusion */
```

## インタラクティブ

### Cursor
```css
cursor-auto         /* cursor: auto */
cursor-default      /* cursor: default */
cursor-pointer      /* cursor: pointer */
cursor-wait         /* cursor: wait */
cursor-text         /* cursor: text */
cursor-move         /* cursor: move */
cursor-help         /* cursor: help */
cursor-not-allowed  /* cursor: not-allowed */
cursor-none         /* cursor: none */
cursor-context-menu /* cursor: context-menu */
cursor-progress     /* cursor: progress */
cursor-cell         /* cursor: cell */
cursor-crosshair    /* cursor: crosshair */
cursor-vertical-text /* cursor: vertical-text */
cursor-alias        /* cursor: alias */
cursor-copy         /* cursor: copy */
cursor-no-drop      /* cursor: no-drop */
cursor-grab         /* cursor: grab */
cursor-grabbing     /* cursor: grabbing */
cursor-all-scroll   /* cursor: all-scroll */
cursor-col-resize   /* cursor: col-resize */
cursor-row-resize   /* cursor: row-resize */
cursor-n-resize     /* cursor: n-resize */
cursor-e-resize     /* cursor: e-resize */
cursor-s-resize     /* cursor: s-resize */
cursor-w-resize     /* cursor: w-resize */
cursor-ne-resize    /* cursor: ne-resize */
cursor-nw-resize    /* cursor: nw-resize */
cursor-se-resize    /* cursor: se-resize */
cursor-sw-resize    /* cursor: sw-resize */
cursor-ew-resize    /* cursor: ew-resize */
cursor-ns-resize    /* cursor: ns-resize */
cursor-nesw-resize  /* cursor: nesw-resize */
cursor-nwse-resize  /* cursor: nwse-resize */
cursor-zoom-in      /* cursor: zoom-in */
cursor-zoom-out     /* cursor: zoom-out */
```

### User Select
```css
select-none     /* user-select: none */
select-text     /* user-select: text */
select-all      /* user-select: all */
select-auto     /* user-select: auto */
```

### Pointer Events
```css
pointer-events-none  /* pointer-events: none */
pointer-events-auto  /* pointer-events: auto */
```

### Resize
```css
resize-none     /* resize: none */
resize          /* resize: both */
resize-y        /* resize: vertical */
resize-x        /* resize: horizontal */
```

### Scroll Behavior
```css
scroll-auto     /* scroll-behavior: auto */
scroll-smooth   /* scroll-behavior: smooth */
```

### Touch Action
```css
touch-auto          /* touch-action: auto */
touch-none          /* touch-action: none */
touch-pan-x         /* touch-action: pan-x */
touch-pan-left      /* touch-action: pan-left */
touch-pan-right     /* touch-action: pan-right */
touch-pan-y         /* touch-action: pan-y */
touch-pan-up        /* touch-action: pan-up */
touch-pan-down      /* touch-action: pan-down */
touch-pinch-zoom    /* touch-action: pinch-zoom */
touch-manipulation  /* touch-action: manipulation */
```

## トランジション・アニメーション

### Transition Property
```css
transition-none     /* transition-property: none */
transition-all      /* transition-property: all */
transition          /* transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter */
transition-colors   /* transition-property: color, background-color, border-color, text-decoration-color, fill, stroke */
transition-opacity  /* transition-property: opacity */
transition-shadow   /* transition-property: box-shadow */
transition-transform /* transition-property: transform */
```

### Transition Duration
```css
duration-75     /* transition-duration: 75ms */
duration-100    /* transition-duration: 100ms */
duration-150    /* transition-duration: 150ms */
duration-200    /* transition-duration: 200ms */
duration-300    /* transition-duration: 300ms */
duration-500    /* transition-duration: 500ms */
duration-700    /* transition-duration: 700ms */
duration-1000   /* transition-duration: 1000ms */
```

### Transition Timing Function
```css
ease-linear     /* transition-timing-function: linear */
ease-in         /* transition-timing-function: cubic-bezier(0.4, 0, 1, 1) */
ease-out        /* transition-timing-function: cubic-bezier(0, 0, 0.2, 1) */
ease-in-out     /* transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) */
```

### Transition Delay
```css
delay-75        /* transition-delay: 75ms */
delay-100       /* transition-delay: 100ms */
delay-150       /* transition-delay: 150ms */
delay-200       /* transition-delay: 200ms */
delay-300       /* transition-delay: 300ms */
delay-500       /* transition-delay: 500ms */
delay-700       /* transition-delay: 700ms */
delay-1000      /* transition-delay: 1000ms */
```

### Animation
```css
animate-none        /* animation: none */
animate-spin        /* animation: spin 1s linear infinite */
animate-ping        /* animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite */
animate-pulse       /* animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite */
animate-bounce      /* animation: bounce 1s infinite */
```

## フィルター

### Blur
```css
blur-none       /* filter: blur(0) */
blur-sm         /* filter: blur(4px) */
blur            /* filter: blur(8px) */
blur-md         /* filter: blur(12px) */
blur-lg         /* filter: blur(16px) */
blur-xl         /* filter: blur(24px) */
blur-2xl        /* filter: blur(40px) */
blur-3xl        /* filter: blur(64px) */
```

### Brightness
```css
brightness-0    /* filter: brightness(0) */
brightness-50   /* filter: brightness(.5) */
brightness-75   /* filter: brightness(.75) */
brightness-90   /* filter: brightness(.9) */
brightness-95   /* filter: brightness(.95) */
brightness-100  /* filter: brightness(1) */
brightness-105  /* filter: brightness(1.05) */
brightness-110  /* filter: brightness(1.1) */
brightness-125  /* filter: brightness(1.25) */
brightness-150  /* filter: brightness(1.5) */
brightness-200  /* filter: brightness(2) */
```

### Contrast
```css
contrast-0      /* filter: contrast(0) */
contrast-50     /* filter: contrast(.5) */
contrast-75     /* filter: contrast(.75) */
contrast-100    /* filter: contrast(1) */
contrast-125    /* filter: contrast(1.25) */
contrast-150    /* filter: contrast(1.5) */
contrast-200    /* filter: contrast(2) */
```

### Grayscale
```css
grayscale-0     /* filter: grayscale(0) */
grayscale       /* filter: grayscale(100%) */
```

### Hue Rotate
```css
hue-rotate-0    /* filter: hue-rotate(0deg) */
hue-rotate-15   /* filter: hue-rotate(15deg) */
hue-rotate-30   /* filter: hue-rotate(30deg) */
hue-rotate-60   /* filter: hue-rotate(60deg) */
hue-rotate-90   /* filter: hue-rotate(90deg) */
hue-rotate-180  /* filter: hue-rotate(180deg) */
```

### Invert
```css
invert-0        /* filter: invert(0) */
invert          /* filter: invert(100%) */
```

### Saturate
```css
saturate-0      /* filter: saturate(0) */
saturate-50     /* filter: saturate(.5) */
saturate-100    /* filter: saturate(1) */
saturate-150    /* filter: saturate(1.5) */
saturate-200    /* filter: saturate(2) */
```

### Sepia
```css
sepia-0         /* filter: sepia(0) */
sepia           /* filter: sepia(100%) */
```

### Drop Shadow
```css
drop-shadow-sm  /* filter: drop-shadow(0 1px 1px rgb(0 0 0 / 0.05)) */
drop-shadow     /* filter: drop-shadow(0 1px 2px rgb(0 0 0 / 0.1)) drop-shadow(0 1px 1px rgb(0 0 0 / 0.06)) */
drop-shadow-md  /* filter: drop-shadow(0 4px 3px rgb(0 0 0 / 0.07)) drop-shadow(0 2px 2px rgb(0 0 0 / 0.06)) */
drop-shadow-lg  /* filter: drop-shadow(0 10px 8px rgb(0 0 0 / 0.04)) drop-shadow(0 4px 3px rgb(0 0 0 / 0.1)) */
drop-shadow-xl  /* filter: drop-shadow(0 20px 13px rgb(0 0 0 / 0.03)) drop-shadow(0 8px 5px rgb(0 0 0 / 0.08)) */
drop-shadow-2xl /* filter: drop-shadow(0 25px 25px rgb(0 0 0 / 0.15)) */
drop-shadow-none /* filter: drop-shadow(0 0 #0000) */
```

## 変換（Transform）

### Scale
```css
scale-0         /* transform: scale(0) */
scale-50        /* transform: scale(.5) */
scale-75        /* transform: scale(.75) */
scale-90        /* transform: scale(.9) */
scale-95        /* transform: scale(.95) */
scale-100       /* transform: scale(1) */
scale-105       /* transform: scale(1.05) */
scale-110       /* transform: scale(1.1) */
scale-125       /* transform: scale(1.25) */
scale-150       /* transform: scale(1.5) */

scale-x-0       /* transform: scaleX(0) */
scale-x-50      /* transform: scaleX(.5) */
scale-x-100     /* transform: scaleX(1) */
scale-x-150     /* transform: scaleX(1.5) */

scale-y-0       /* transform: scaleY(0) */
scale-y-50      /* transform: scaleY(.5) */
scale-y-100     /* transform: scaleY(1) */
scale-y-150     /* transform: scaleY(1.5) */
```

### Rotate
```css
rotate-0        /* transform: rotate(0deg) */
rotate-1        /* transform: rotate(1deg) */
rotate-2        /* transform: rotate(2deg) */
rotate-3        /* transform: rotate(3deg) */
rotate-6        /* transform: rotate(6deg) */
rotate-12       /* transform: rotate(12deg) */
rotate-45       /* transform: rotate(45deg) */
rotate-90       /* transform: rotate(90deg) */
rotate-180      /* transform: rotate(180deg) */

-rotate-180     /* transform: rotate(-180deg) */
-rotate-90      /* transform: rotate(-90deg) */
-rotate-45      /* transform: rotate(-45deg) */
-rotate-12      /* transform: rotate(-12deg) */
-rotate-6       /* transform: rotate(-6deg) */
-rotate-3       /* transform: rotate(-3deg) */
-rotate-2       /* transform: rotate(-2deg) */
-rotate-1       /* transform: rotate(-1deg) */
```

### Translate
```css
translate-x-0   /* transform: translateX(0px) */
translate-x-1   /* transform: translateX(0.25rem) */
translate-x-2   /* transform: translateX(0.5rem) */
translate-x-4   /* transform: translateX(1rem) */
translate-x-8   /* transform: translateX(2rem) */
translate-x-1/2 /* transform: translateX(50%) */
translate-x-full /* transform: translateX(100%) */

translate-y-0   /* transform: translateY(0px) */
translate-y-1   /* transform: translateY(0.25rem) */
translate-y-2   /* transform: translateY(0.5rem) */
translate-y-4   /* transform: translateY(1rem) */
translate-y-8   /* transform: translateY(2rem) */
translate-y-1/2 /* transform: translateY(50%) */
translate-y-full /* transform: translateY(100%) */

-translate-x-1  /* transform: translateX(-0.25rem) */
-translate-x-2  /* transform: translateX(-0.5rem) */
-translate-x-1/2 /* transform: translateX(-50%) */
-translate-x-full /* transform: translateX(-100%) */

-translate-y-1  /* transform: translateY(-0.25rem) */
-translate-y-2  /* transform: translateY(-0.5rem) */
-translate-y-1/2 /* transform: translateY(-50%) */
-translate-y-full /* transform: translateY(-100%) */
```

### Skew
```css
skew-x-0        /* transform: skewX(0deg) */
skew-x-1        /* transform: skewX(1deg) */
skew-x-2        /* transform: skewX(2deg) */
skew-x-3        /* transform: skewX(3deg) */
skew-x-6        /* transform: skewX(6deg) */
skew-x-12       /* transform: skewX(12deg) */

skew-y-0        /* transform: skewY(0deg) */
skew-y-1        /* transform: skewY(1deg) */
skew-y-2        /* transform: skewY(2deg) */
skew-y-3        /* transform: skewY(3deg) */
skew-y-6        /* transform: skewY(6deg) */
skew-y-12       /* transform: skewY(12deg) */

-skew-x-12      /* transform: skewX(-12deg) */
-skew-x-6       /* transform: skewX(-6deg) */
-skew-x-3       /* transform: skewX(-3deg) */
-skew-x-2       /* transform: skewX(-2deg) */
-skew-x-1       /* transform: skewX(-1deg) */

-skew-y-12      /* transform: skewY(-12deg) */
-skew-y-6       /* transform: skewY(-6deg) */
-skew-y-3       /* transform: skewY(-3deg) */
-skew-y-2       /* transform: skewY(-2deg) */
-skew-y-1       /* transform: skewY(-1deg) */
```

### Transform Origin
```css
origin-center   /* transform-origin: center */
origin-top      /* transform-origin: top */
origin-top-right /* transform-origin: top right */
origin-right    /* transform-origin: right */
origin-bottom-right /* transform-origin: bottom right */
origin-bottom   /* transform-origin: bottom */
origin-bottom-left /* transform-origin: bottom left */
origin-left     /* transform-origin: left */
origin-top-left /* transform-origin: top left */
```

## 位置（Position）

### Position
```css
static          /* position: static */
fixed           /* position: fixed */
absolute        /* position: absolute */
relative        /* position: relative */
sticky          /* position: sticky */
```

### Top / Right / Bottom / Left
```css
/* Values */
inset-0         /* top: 0px; right: 0px; bottom: 0px; left: 0px */
inset-1         /* top: 0.25rem; right: 0.25rem; bottom: 0.25rem; left: 0.25rem */
inset-2         /* top: 0.5rem; right: 0.5rem; bottom: 0.5rem; left: 0.5rem */
inset-4         /* top: 1rem; right: 1rem; bottom: 1rem; left: 1rem */
inset-auto      /* top: auto; right: auto; bottom: auto; left: auto */
inset-1/2       /* top: 50%; right: 50%; bottom: 50%; left: 50% */
inset-full      /* top: 100%; right: 100%; bottom: 100%; left: 100% */

inset-x-0       /* left: 0px; right: 0px */
inset-x-1       /* left: 0.25rem; right: 0.25rem */
inset-x-auto    /* left: auto; right: auto */

inset-y-0       /* top: 0px; bottom: 0px */
inset-y-1       /* top: 0.25rem; bottom: 0.25rem */
inset-y-auto    /* top: auto; bottom: auto */

top-0           /* top: 0px */
top-1           /* top: 0.25rem */
top-2           /* top: 0.5rem */
top-4           /* top: 1rem */
top-auto        /* top: auto */
top-1/2         /* top: 50% */
top-full        /* top: 100% */

right-0         /* right: 0px */
right-1         /* right: 0.25rem */
right-auto      /* right: auto */

bottom-0        /* bottom: 0px */
bottom-1        /* bottom: 0.25rem */
bottom-auto     /* bottom: auto */

left-0          /* left: 0px */
left-1          /* left: 0.25rem */
left-auto       /* left: auto */
```

## レスポンシブプレフィックス

### ブレークポイント
```css
/* デフォルトブレークポイント */
sm:             /* @media (min-width: 640px) */
md:             /* @media (min-width: 768px) */
lg:             /* @media (min-width: 1024px) */
xl:             /* @media (min-width: 1280px) */
2xl:            /* @media (min-width: 1536px) */

/* 使用例 */
sm:text-lg      /* 640px以上で text-lg を適用 */
md:flex         /* 768px以上で flex を適用 */
lg:grid-cols-3  /* 1024px以上で grid-cols-3 を適用 */
xl:px-8         /* 1280px以上で px-8 を適用 */
2xl:max-w-7xl   /* 1536px以上で max-w-7xl を適用 */
```

## ステートプレフィックス

### 疑似クラス
```css
/* ホバー */
hover:          /* &:hover */
hover:bg-blue-500 /* &:hover { background-color: rgb(59 130 246) } */

/* フォーカス */
focus:          /* &:focus */
focus:ring-2    /* &:focus { box-shadow: var(--un-ring-inset) 0 0 0 calc(2px + var(--un-ring-offset-width)) var(--un-ring-color) } */

/* アクティブ */
active:         /* &:active */
active:scale-95 /* &:active { transform: scale(.95) } */

/* 無効状態 */
disabled:       /* &:disabled */
disabled:opacity-50 /* &:disabled { opacity: 0.5 } */

/* チェック状態 */
checked:        /* &:checked */
checked:bg-blue-500 /* &:checked { background-color: rgb(59 130 246) } */

/* 必須 */
required:       /* &:required */
required:border-red-500 /* &:required { border-color: rgb(239 68 68) } */

/* 無効 */
invalid:        /* &:invalid */
invalid:border-red-500 /* &:invalid { border-color: rgb(239 68 68) } */

/* ファーストチャイルド */
first:          /* &:first-child */
first:mt-0      /* &:first-child { margin-top: 0px } */

/* ラストチャイルド */
last:           /* &:last-child */
last:mb-0       /* &:last-child { margin-bottom: 0px } */

/* 奇数番目 */
odd:            /* &:nth-child(odd) */
odd:bg-gray-50  /* &:nth-child(odd) { background-color: rgb(249 250 251) } */

/* 偶数番目 */
even:           /* &:nth-child(even) */
even:bg-gray-100 /* &:nth-child(even) { background-color: rgb(243 244 246) } */
```

### 疑似要素
```css
/* Before */
before:         /* &::before */
before:content-[''] /* &::before { content: '' } */

/* After */
after:          /* &::after */
after:content-[''] /* &::after { content: '' } */

/* Placeholder */
placeholder:    /* &::placeholder */
placeholder:text-gray-400 /* &::placeholder { color: rgb(156 163 175) } */

/* Selection */
selection:      /* &::selection */
selection:bg-blue-200 /* &::selection { background-color: rgb(191 219 254) } */

/* First Letter */
first-letter:   /* &::first-letter */
first-letter:text-2xl /* &::first-letter { font-size: 1.5rem; line-height: 2rem } */

/* First Line */
first-line:     /* &::first-line */
first-line:font-bold /* &::first-line { font-weight: 700 } */
```

## ダークモード

### ダークモードプレフィックス
```css
dark:           /* @media (prefers-color-scheme: dark) または .dark クラス下 */

/* 使用例 */
dark:bg-gray-900    /* ダークモードで bg-gray-900 を適用 */
dark:text-white     /* ダークモードで text-white を適用 */
dark:border-gray-700 /* ダークモードで border-gray-700 を適用 */

/* 組み合わせ例 */
bg-white dark:bg-gray-900           /* ライト: 白背景、ダーク: グレー背景 */
text-gray-900 dark:text-white       /* ライト: 黒文字、ダーク: 白文字 */
border-gray-200 dark:border-gray-700 /* ライト: 薄いボーダー、ダーク: 濃いボーダー */
```

## グループバリアント

### グループ
```css
group           /* グループの親要素に適用 */
group-hover:    /* 親要素のホバー時に子要素に適用 */
group-focus:    /* 親要素のフォーカス時に子要素に適用 */
group-active:   /* 親要素のアクティブ時に子要素に適用 */

/* 使用例 */
<div class="group">
  <img class="group-hover:scale-110" />
  <p class="group-hover:text-blue-500">テキスト</p>
</div>
```

## 任意値

### 任意値の構文
```css
/* 任意の値を指定 */
w-[32rem]       /* width: 32rem */
h-[100px]       /* height: 100px */
text-[14px]     /* font-size: 14px */
bg-[#1da1f2]    /* background-color: #1da1f2 */
m-[10px_20px]   /* margin: 10px 20px */
grid-cols-[200px_minmax(900px,_1fr)_100px] /* grid-template-columns: 200px minmax(900px, 1fr) 100px */

/* CSS変数 */
bg-[var(--my-color)]        /* background-color: var(--my-color) */
text-[length:var(--my-size)] /* font-size: var(--my-size) */
```

このチートシートは、UNO.CSSの主要なユーティリティクラスを網羅しています。実際の開発では、プロジェクトの設定やカスタムルールによって利用可能なクラスが変わる場合があります。

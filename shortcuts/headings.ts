// shortcuts.headings.ts
// tokens.css の --hd** 変数だけで動く heading01..13 と2つのタイトルスタイル

import type { UserShortcuts } from 'unocss'

export const headingShortcuts: UserShortcuts = [
  ['heading01', 'relative block px-4 py-2 text-[var(--hd01-fg)] bg-[var(--hd01-bg)] border border-[var(--hd01-b1)] rounded'],
  [
    'heading02',
    `relative w-1/4 m-0 mx-[-1px] font-bold
   text-[var(--hd02-fs)] leading-[1.6] font-sans
   text-[var(--hd02-fg)] text-center
   text-shadow-[var(--hd02-text-shadow)]
   bg-[var(--hd02-bg)]
   border-x border-x-solid border-x-[var(--hd02-border)]
   shadow-[var(--hd02-shadow)]
   opacity-70 transform rotate-[-3deg] skew-[-3deg]`,
  ],
  [
    'heading03',
    `relative p-[5px] m-0 mx-[-10px] mb-[-10px] font-normal
   text-[var(--hd03-fs)] leading-[1.6] font-serif
   text-[var(--hd03-fg)] text-center
   bg-[var(--hd03-bg)] bg-[var(--hd03-gradient)]
   shadow-[var(--hd03-shadow)]
   transform rotate-[-3deg] skew-[-3deg]
   before:absolute before:top-[-5px] before:left-0 before:content-empty
   before:border-transparent before:border-solid
   before:border-b-[5px] before:border-l-[10px] before:border-b-[var(--hd03-before-border-b)]
   after:absolute after:top-full after:right-0 after:content-empty
   after:border-transparent after:border-solid
   after:border-t-[5px] after:border-r-[10px] after:border-t-[var(--hd03-after-border-t)]`,
  ],
  [
    'heading03-2',
    `relative pt-[15px] pr-[5px] pb-[10px] pl-[40px]
   mt-[30px] mx-[-40px] mb-[10px]
   text-[var(--hd03-2-fs)] leading-none
   text-[var(--hd03-2-fg)]
   bg-[var(--hd03-2-bg)]
   shadow-[var(--hd03-2-shadow)]
   before:absolute before:top-full before:right-0
   before:content-empty before:border-[5px] before:border-transparent
   before:border-t-[5px] before:border-t-[var(--hd03-2-triangle)]
   before:border-l-[5px] before:border-l-[var(--hd03-2-triangle)]
   after:absolute after:top-full after:left-0
   after:content-empty after:border-[5px] after:border-transparent
   after:border-t-[5px] after:border-t-[var(--hd03-2-triangle)]
   after:border-r-[5px] after:border-r-[var(--hd03-2-triangle)]`,
  ],
  [
    'heading04',
    `relative py-[var(--h4-p1,10px)] px-[var(--h4-p2,20px)]
   my-[var(--h4-m1,0)] mx-[var(--h4-m2,15px)]
   font-bold text-[var(--hd04-fs)] leading-[1.6] font-sans
   text-[var(--hd04-fg)]
   bg-[var(--hd04-bg)]
   border-3 border-solid border-[var(--hd04-border)]
   rounded-[18px]
   shadow-[var(--hd04-shadow)]
   before:absolute before:top-full before:left-[14px]
   before:content-empty before:border-transparent before:border-solid
   before:border-[20px] before:border-t-[var(--hd04-triangle-top)]
   after:absolute after:bottom-[-27px] after:left-[18px]
   after:content-empty after:border-transparent after:border-solid
   after:border-[14px] after:border-t-[var(--hd04-triangle-bottom)]`,
  ],
  [
    'heading04-2',
    `relative pt-[15px] pr-[5px] pb-[12px] pl-[10px]
   mt-[30px] mx-[-10px] mb-[10px]
   text-[var(--hd04-2-fs)] leading-none
   text-[var(--hd04-2-fg)]
   text-shadow-[var(--hd04-2-text-shadow)]
   bg-[var(--hd04-2-bg)]
   border-1 border-solid border-[var(--hd04-2-border)]
   rounded-[3px]
   after:absolute after:top-full after:left-[30px]
   after:content-empty after:border-[10px] after:border-transparent
   after:border-t-[10px] after:border-t-[var(--hd04-2-triangle)]`,
  ],
  [
    'heading04-3',
    `relative pt-[15px] pr-[5px] pb-[12px] pl-[10px]
   mt-[30px] mx-[-10px] mb-[10px]
   [font-size:var(--hd04-3-fs)] leading-none
   text-[var(--hd04-3-fg)]
   bg-[var(--hd04-3-bg)]
   border-2 border-solid border-[var(--hd04-3-border)]
   rounded-[3px]
   before:absolute before:top-full before:left-[30px]
   before:w-0 before:h-0 before:content-empty
   before:border-[14px] before:border-solid before:border-transparent
   before:border-t-[14px] before:border-t-[var(--hd04-3-notch-outer)]
   after:absolute after:top-full after:left-[33px]
   after:w-0 after:h-0 after:content-empty
   after:border-[11px] after:border-solid after:border-transparent
   after:border-t-[11px] after:border-t-[var(--hd04-3-notch-inner)]`,
  ],
  [
    'heading05',
    `relative block w-full mt-[20px] mb-0
   text-lg font-bold
   text-[var(--hd05-fg)] text-left
   rounded-[4px] border border-solid border-[var(--hd05-border)]
   [background:var(--hd05-bg-color)]
   [background-image:var(--hd05-gradient)]`,
  ],
  [
    'heading06',
    `relative block
   pt-[14px] pr-[15px] pb-0 pl-[20px]
   mt-0 mr-[22px] mb-0 ml-[10px]
   font-normal text-[var(--hd06-fs)] leading-[1.3] font-serif
   text-[var(--hd06-fg)]
   bg-[var(--hd06-bg)]
   shadow-[var(--hd06-shadow)]
   before:absolute before:top-full before:left-full
   before:content-empty before:w-0 before:h-0
   before:border-solid before:border-transparent
   before:border-t-[12px] before:border-r-[12px]
   before:border-t-[var(--hd06-corner)]`,
  ],
  [
    'heading06-label',
    `relative inline-block z-0
   after:absolute after:bottom-0 after:left-0 after:z-[-1]
   after:w-full after:h-[var(--hd06-accent-h)]
   after:content-empty after:bg-[var(--hd06-accent-bg)]
   after:transform after:rotate-[var(--hd06-accent-rotate)]`,
  ],
  [
    'heading07',
    `relative p-[10px] pl-[30px] mx-[10px]
   font-bold text-[var(--hd07-fs)] leading-[1.2] font-[var(--hd07-ff)]
   text-[var(--hd07-fg)] text-shadow-[var(--hd07-text-shadow)]
   bg-[var(--hd07-bg)]
   [background-image:linear-gradient(to_bottom,var(--hd07-grad-1),var(--hd07-grad-2)_25%,var(--hd07-grad-3)_30%,var(--hd07-grad-2)_36%,var(--hd07-grad-3)_50%,var(--hd07-grad-4)_80%,var(--hd07-grad-5))]
   border-t border-r border-b border-l
   border-t-[var(--hd07-bg)] border-r-[var(--hd07-bc)] border-b-[var(--hd07-bc)] border-l-[var(--hd07-bg)]
   shadow-[var(--hd07-inset)]
   before:absolute before:top-0 before:left-[15px] before:h-full before:content-empty before:border-l before:border-l-solid before:border-l-[var(--hd07-bg)]
   after:absolute after:top-0 after:left-[16px] after:h-full after:content-empty after:border-r after:border-r-solid after:border-r-[var(--hd07-after-border)]`,
  ],
  [
    'heading08',
    `relative z-1 py-0 pr-[10px] pl-[55px] mx-[10px]
   font-bold text-[var(--hd08-fs)] leading-[var(--hd08-lh)] font-[var(--hd08-ff)]
   text-[var(--hd08-fg)] bg-[var(--hd08-bg)]

   before:absolute before:top-0 before:left-0 before:z-[-1]
   before:w-[40px] before:h-[40px] before:content-empty
   before:bg-[var(--hd08-badge-bg)]
   before:[background-image:var(--hd08-grad-bottom)]
   before:border-r-2 before:border-r-solid before:border-r-[var(--hd08-after-border)]

   after:absolute after:top-0 after:left-0 after:z-[-1]
   after:w-[40px] after:h-[40px] after:content-empty
   after:[background-image:var(--hd08-grad-right)]`,
  ],
  [
    'heading08-2',
    `relative z-1 py-0 pr-[10px] pl-[55px] mx-[10px]
   font-bold text-[var(--hd08-fs)] leading-[var(--hd08-lh)] font-[var(--hd08-ff)]
   text-[var(--hd08-fg)] bg-[var(--hd08-bg)]

   [background-image:var(--metal-grad-y),var(--metal-grad-x)]
   [background-blend-mode:soft-light,normal]
   shadow-[var(--metal-inset),var(--metal-outer),0_0_0_1px_rgba(255,255,255,.02)_inset]

   shadow-[var(--metal-inset),var(--metal-outer)]

   before:absolute before:top-0 before:left-0 before:z-[-1]
   before:w-[40px] before:h-[40px] before:content-empty
   before:bg-[var(--hd08-badge-bg)]
   [--_hd08-bgi:var(--hd08-icon),var(--hd08-grad-bottom)]
   before:[background-image:var(--_hd08-bgi)]
   before:[background-repeat:no-repeat,repeat]
   before:[background-position:center,0_0]
   before:[background-size:var(--hd08-icon-size)_var(--hd08-icon-size),auto]
   before:border-r-2 before:border-r-solid before:border-r-[var(--hd08-after-border)]

   after:absolute after:top-0 after:left-0 after:z-[-1]
   after:w-[40px] after:h-[40px] after:content-empty
   after:[background-image:var(--hd08-grad-right)]`,
  ],
  [
    'heading09',
    `relative px-[15px] py-[10px] mx-[20px]
   font-bold text-[var(--hd09-fs)] leading-[1.2] font-sans
   text-[var(--hd09-fg)]
   bg-[var(--hd09-bg)]
   before:absolute before:top-1/2 before:-translate-y-1/2
   before:left-[-10px] before:content-['<'] before:text-[25px]
   before:leading-none before:text-[var(--hd09-before)]
   after:absolute after:top-[-2px] after:left-[-10px]
   after:content-[''] after:h-[130%]
   after:border-2 after:border-solid after:border-[var(--hd09-br)]
   after:rounded-[2px] after:transform after:rotate-[-2deg]`,
  ],
  [
    'heading09-2',
    `relative px-[15px] py-[10px] mx-[20px]
   font-bold text-[22px] leading-[1.2] font-sans
   text-[var(--hd09-2-fg)] bg-[var(--hd09-2-bg)]

   [background-image:var(--metal-grad-y),var(--metal-grad-x)]
   [background-blend-mode:soft-light,normal]
   shadow-[var(--metal-inset),var(--metal-outer)]

   border-[var(--hd09-2-br)] border-solid
   [border-top-color:var(--hd09-2-bg)]
   [border-right-color:var(--hd09-2-edge)]
   [border-bottom-color:var(--hd09-2-edge)]
   [border-left-color:var(--hd09-2-bg)]

   before:absolute before:top-1/2 before:left-[-10px]
   before:-translate-y-1/2 before:inline-block
   before:text-[25px] before:leading-none before:font-bold
   before:text-[var(--hd09-2-angle-fg)]
   before:content-['<']

   after:absolute after:top-[-2px] after:left-[-10px]
   after:content-[''] after:h-[130%]
   after:border-[2px] after:border-solid
   [--_hd09-2-edge:var(--hd09-2-edge)]
   after:[border-color:var(--_hd09-2-edge)]
   after:rounded-[2px] after:rotate-[-2deg]`,
  ],
  [
    'heading10',
    `relative pt-[14px] pr-[5px] pb-[10px] pl-[50px]
   mt-[30px] mr-[20px] mb-[10px] ml-[-10px]
   text-[var(--hd10-fs)] leading-none
   text-[var(--hd10-fg)]
   bg-[var(--hd10-bg)]
   rounded-l-[22px]
   before:absolute before:top-1/2 before:left-[14px]
   before:w-[20px] before:h-[20px] before:mt-[-10px]
   before:content-empty before:bg-[var(--hd10-before-bg)]
   before:rounded-full before:shadow-[inset_1px_1px_1px_#777]`,
  ],
  [
    'heading10-2',
    `relative pt-[14px] pr-[5px] pb-[10px] pl-[50px]
   mt-[30px] mr-[20px] mb-[10px] ml-[-10px]
   text-[var(--hd10-2-fs)] leading-none
   text-[var(--hd10-2-fg)] bg-[var(--hd10-2-bg)] rounded-l-[22px]

   [background-image:var(--metal-grad-y),var(--metal-grad-x)]
   [background-blend-mode:soft-light,normal]
   shadow-[var(--metal-inset),var(--metal-outer)]

   before:absolute before:top-1/2 before:left-[14px]
   before:w-[20px] before:h-[20px] before:mt-[-10px] before:content-empty
   before:bg-[var(--hd10-2-pin-base)] before:rounded-full
   before:shadow-[inset_1px_1px_1px_rgba(0,0,0,.25),inset_-1px_-1px_1px_rgba(255,255,255,.35)]

   after:absolute after:top-[calc(50%-6px)] after:left-[calc(14px+6px)]
   after:w-[6px] after:h-[6px] after:content-empty
   after:bg-[var(--hd10-2-pin-spot)] after:rounded-full
   after:shadow-[0_0_2px_rgba(255,255,255,.5)]`,
  ],
  [
    'heading10-3',
    `relative pt-[12px] pr-[5px] pb-[12px] pl-[52px]
   mt-[30px] mr-[20px] mb-[10px] ml-[-10px]
   text-[var(--hd10-3-fs)] leading-none
   text-[var(--hd10-3-fg)] bg-[var(--hd10-3-bg)] rounded-l-[22px]

   [background-image:var(--metal-grad-y),var(--metal-grad-x)]
   [background-blend-mode:soft-light,normal]
   shadow-[var(--metal-inset),var(--metal-outer)]

   before:absolute before:top-0 before:left-[3px]
   before:w-[44px] before:h-full before:content-empty
   before:bg-[var(--hd10-3-pin-bg)] before:rounded-[22px]
   before:shadow-[inset_1px_1px_1px_rgba(0,0,0,.25),inset_-1px_-1px_1px_rgba(255,255,255,.35)]

   after:absolute after:top-1/2 after:left-[19px]
   after:w-[12px] after:h-[12px] after:mt-[-6px] after:content-empty
   after:bg-[var(--hd10-3-pin-inner)] after:rounded-full
   after:shadow-[0_0_2px_rgba(255,255,255,.5)]`,
  ],
  [
    'heading11',
    `relative pt-[15px] pr-[5px] pb-[10px] pl-[20px]
   mt-[30px] mx-[-30px] mb-[10px]
   text-[var(--hd11-fs,inherit)] leading-none
   border-l-[10px] border-l-solid border-l-[var(--hd11-blc,#777)]
   after:absolute after:bottom-0 after:left-0 after:w-full
   after:content-empty after:border-b after:border-b-dashed after:border-b-[var(--hd11-bc,#555)]`,
  ],
  [
    'heading12',
    `relative pt-[14px] pr-[5px] pb-[10px] pl-[10px] mt-[30px]
   text-[var(--hd12-fs,1.25rem)] leading-none text-[var(--hd12-fg,#111)]
   before:absolute before:top-0 before:left-[-5px] before:w-[12px] before:h-[12px]
   before:content-empty before:bg-[var(--hd12-b1,#999)] before:transform before:rotate-45
   after:absolute after:top-[15px] after:left-[-10px] after:w-[8px] after:h-[8px]
   after:content-empty after:bg-[var(--hd12-b2,#777)] after:transform after:rotate-12`,
  ],
  [
    'heading13',
    `relative block py-[0.5em] pl-[1em] mb-[1.5em] font-bold
   text-[var(--hd13-fg,inherit)]
   border-l-4 border-l-solid border-l-[var(--hd13-blc,#a00)]
   border-b [border-bottom-color:var(--hd13-bc,#e6e6fa)]
   [border-bottom-width:var(--hd13-bw,2px)]
   [border-bottom-style:var(--hd13-bs,dashed)]`,
  ],
  [
    'heading13-2',
    `p-[0.8em] mb-[1.5em] text-[var(--hd13-2-fs)] font-bold
   border-t-3 [border-top-style:double] border-t-[var(--hd13-2-btc)]
   border-b-3 [border-bottom-style:double] border-b-[var(--hd13-2-bbc)]`,
  ],
  [
    'heading13-3',
    `p-[0.8em] mb-[1.5em] text-[var(--hd13-3-fs)] font-bold
   text-[var(--hd13-3-fg)]
   border-2 [border-style:solid] border-[var(--hd13-3-bc)]
   rounded-[10px]`,
  ],
  [
    'heading13-4',
    `relative py-[0.8em] pl-[1.5em] mb-[1.5em]
   text-[var(--hd13-4-fs)] font-bold
   border-2 border-solid border-[var(--hd13-4-bc)]
   before:absolute before:top-1/2 before:left-[0.5em]
   before:w-[8px] before:h-[30px] before:mt-[-15px] before:content-empty
   before:bg-[var(--hd13-4-bg)] before:rounded-[2px]`,
  ],
  [
    'heading13-5',
    `relative py-[0.8em] pl-[2.5em] mb-[1.5em]
   text-[var(--hd13-5-fs)] font-bold
   border border-solid border-[var(--hd13-5-bc)] rounded-[20px]
   before:absolute before:top-1/2 before:left-[0.5em]
   before:w-[20px] before:h-[20px] before:mt-[-10px]
   before:content-empty before:bg-[var(--hd13-5-bg)]
   before:rounded-[15px] before:shadow-[inset_1px_1px_1px_var(--hd13-5-bc)]`,
  ],
  [
    'heading13-6',
    `relative p-[0.8em] mb-[1.5em]
   text-[var(--hd13-6-fs)] font-bold text-[var(--hd13-6-fg)]
   bg-[var(--hd13-6-bg)] rounded-[5px]
   after:absolute after:bottom-[-15px] after:left-[10%]
   after:ml-[-15px] after:content-empty
   after:border-t-[15px] after:border-t-solid after:border-t-[var(--hd13-6-bc)]
   after:border-r-[15px] after:border-r-solid after:border-r-transparent
   after:border-l-[15px] after:border-l-solid after:border-l-transparent`,
  ],
  [
    'heading13-7',
    `p-[0.8em] mb-[1.5em] text-[var(--hd13-7-fs)] font-bold
   text-[var(--hd13-7-fg)]
   border-2 border-solid border-[var(--hd13-7-bc)]
   shadow-[3px_3px_3px_rgba(0,0,0,0.4)]`,
  ],
  [
    'heading13-8',
    `relative p-[0.8em] mb-[1.5em]
   text-[var(--hd13-8-fs)] font-bold text-[var(--hd13-8-fg)] text-center
   bg-[var(--hd13-8-bg)]
   shadow-[0_1px_2px_0_rgba(0,0,0,0.2),1em_0_0_0_var(--hd13-8-bg),-1em_0_0_0_var(--hd13-8-bg)]
   [transform:rotate(-1deg)_skew(-1deg)]`,
  ],
  [
    'heading13-9',
    `mb-[1.5em] text-[var(--hd13-9-fs)] font-bold text-[var(--hd13-9-fg)]
   text-shadow-[0_1px_1px_var(--hd13-9-tsc)]
   border-b-2 border-b-solid border-b-[var(--hd13-9-bc)]
   shadow-[0_1px_0_var(--hd13-9-sc)]
   first-letter:text-[3.75rem]`,
  ],
  [
    'latest-columns-bridge',
    'latest-columns-title-style',
    { selector: '#latest-columns > .flex' }, // 実DOMに合わせて：タイトル行の .flex に当てる例
  ],
  [
    'machaki-pickup-bridge',
    'machaki-group-title-style',
    { selector: '#machaki-pickup > .flex' },
  ],
]

export default headingShortcuts

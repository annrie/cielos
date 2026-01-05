import type { Preflight } from 'unocss'

export const preflightSyntax: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== ベース（Prism & hljs 共通） ===== */
pre[class*="language-"],
code[class*="language-"],
.hljs{
  background: var(--code-bg);
  color: var(--code-fg);
  border: 1px solid var(--code-bc);
  border-radius: var(--code-rd);
  box-shadow: var(--code-shadow);
}

/* ブロック */
pre[class*="language-"],
.hljs{
  padding: var(--code-py) var(--code-px);
  overflow: auto;
  line-height: 1.55;
}

/* インラインコード（Prism: code.language-*, WPの <code> 単体も上書きしない） */
code[class*="language-"]{
  padding: .15em .4em;
}

/* ===== Prism: トークンに色を付与 ===== */
.token.comment, .token.prolog, .token.doctype, .token.cdata { color: var(--code-comment); }
.token.punctuation { color: var(--code-punct); }
.token.namespace { opacity: .8; }
.token.property, .token.tag, .token.constant, .token.symbol, .token.deleted { color: var(--code-const); }
.token.boolean, .token.number { color: var(--code-number); }
.token.selector, .token.attr-name, .token.string, .token.char, .token.builtin, .token.inserted { color: var(--code-string); }
.token.operator, .token.entity, .token.url, .language-css .token.string, .style .token.string { color: var(--code-operator); }
.token.atrule, .token.attr-value { color: var(--code-attr); }
.token.keyword { color: var(--code-keyword); }
.token.function { color: var(--code-func); }
.token.class-name { color: var(--code-class); }
.token.variable { color: var(--code-var); }

/* 選択＆強調 */
pre[class*="language-"] ::selection,
.hljs ::selection{ background: var(--code-hl-bg); }

/* Prism line highlight plugin */
pre[class*="language-"] .line-highlight{
  background: var(--code-hl-bg) !important;
}

/* Prism line numbers plugin */
pre.line-numbers{
  position: relative; padding-left: calc(var(--code-px) + 2.5rem);
}
pre.line-numbers .line-numbers-rows{
  position:absolute; top: var(--code-py); left: 0;
  width: 2.5rem; pointer-events:none; user-select:none;
  border-right: 1px solid var(--code-ln-bc);
}
pre.line-numbers .line-numbers-rows > span{
  display:block; text-align:right; padding-right:.5rem;
  color: var(--code-ln-fg);
}

/* ===== highlight.js: クラスに色を付与 ===== */
.hljs-comment, .hljs-quote { color: var(--code-comment); }
.hljs-punctuation { color: var(--code-punct); }
.hljs-keyword, .hljs-selector-tag, .hljs-subst { color: var(--code-keyword); }
.hljs-string, .hljs-title, .hljs-name, .hljs-type, .hljs-attribute { color: var(--code-string); }
.hljs-number, .hljs-literal, .hljs-symbol, .hljs-bullet { color: var(--code-number); }
.hljs-built_in, .hljs-builtin-name { color: var(--code-builtin); }
.hljs-section { color: var(--code-class); }
.hljs-meta { color: var(--code-attr); }
.hljs-addition { color: var(--code-func); }
.hljs-deletion { color: var(--code-const); }

/* ===== 便利UI：コードヘッダ（任意） ===== */
.code-block{
  position: relative;
  background: var(--code-bg);
  border: 1px solid var(--code-bc);
  border-radius: var(--code-rd);
  box-shadow: var(--code-shadow);
  overflow: hidden;
}
.code-header{
  display:flex; align-items:center; justify-content:space-between; gap:.5rem;
  padding: .4rem .6rem; border-bottom: 1px solid var(--code-bc);
  background: var(--code-copy-bg); color: var(--code-copy-fg);
}
.code-lang{ font-size: .75rem; opacity:.8; }
.code-copy-btn{
  display:inline-flex; align-items:center; gap:.35rem;
  font-size:.75rem; border:1px solid var(--code-copy-bc); border-radius:.375rem;
  padding:.25rem .5rem; background: var(--code-copy-bg); color: var(--code-copy-fg);
}
.code-copy-btn:hover{ filter: brightness(1.05); }
.code-body{ padding: var(--code-py) var(--code-px); overflow:auto; }
`,
}

// scripts/codemod-headings.v2.mjs
import fs from 'node:fs';
import path from 'node:path';
import url from 'node:url';

const __dirname = path.dirname(url.fileURLToPath(import.meta.url));

const TARGETS = [
  'uno.config.ts',
  'uno.config-base.ts',
  'uno.config-base.enhanced.ts',
  'uno.config-docs.ts',
  'uno.config-biblio.ts',
  'uno.config-biblio.enhanced.ts',
  'uno.config-tabs.ts',
].map(f => path.resolve(__dirname, '..', f));

// ここに “置換したいショートカット名” を追加していけます
const TARGET_CLASS_NAMES = [
  'latest-columns-title-style',
  'machaki-group-title-style',
  // heading05 など個別に付けてもOK
  // 'heading05',
  // ワイルドカード的に heading すべてをやりたい場合は後段の genericMatcher を活用
];

function transform(content, className) {
  let out = content;

  // --- ライト側（accentA/B系） ---
  out = out
    // 文字色直書き → 変数化
    .replace(/text-\[(?:rgba?\([^\]]+?\)|#[0-9a-fA-F]{3,8}|[a-z-]+)\]/g, 'text-[var(--hd-fg)]')
    // 枠色
    .replace(/border-\[(?:rgba?\([^\]]+?\)|#[0-9a-fA-F]{3,8}|[a-z-]+)\]/g, 'border-[var(--hd-border)]')
    // 背景ベース
    .replace(/\bbg-bisque\b/g, 'bg-[var(--hd-accentA)]')
    .replace(/\bbg-lightcyan\b/g, 'bg-[var(--hd-accentB)]')
    // グラデ from/to（色直書きはすべて A 仮定→後でBに振替）
    .replace(/from-\[[^\]]+?\]/g, 'from-[var(--hd-accentA-from)]')
    .replace(/to-(?:\[[^\]]+?\]|[a-z-]+)/g, 'to-[var(--hd-accentA-to)]');

  // machaki-group は accentB に振替
  if (className === 'machaki-group-title-style') {
    out = out
      .replace(/bg-\[var\(--hd-accentA\)\]/g, 'bg-[var(--hd-accentB)]')
      .replace(/from-\[var\(--hd-accentA-from\)\]/g, 'from-[var(--hd-accentB-from)]')
      .replace(/to-\[var\(--hd-accentA-to\)\]/g, 'to-[var(--hd-accentB-to)]');
  }

  // --- ダーク側（surface系） ---
  out = out
    // dark 背景基調
    .replace(/dark:bg-(?:surface-\d+|[a-z-]+)\b/g, 'dark:bg-[var(--hd-surface)]')
    // dark グラデ指定があれば to-t に正規化
    .replace(/dark:bg-gradient-to-[trbl]/g, 'dark:bg-gradient-to-t')
    // dark from/to 直書き → 変数
    .replace(/dark:from-\[[^\]]+?\]/g, 'dark:from-[var(--hd-surface-from)]')
    .replace(/dark:to-(?:\[[^\]]+?\]|[a-z-]+)/g, 'dark:to-[var(--hd-surface-to)]')
    // dark:text-* の直書き排除
    .replace(/dark:text-\[[^\]]+?\]/g, 'text-[var(--hd-fg)]')
    .replace(/dark:text-[a-z-]+/g, 'text-[var(--hd-fg)]');

  // 片落ち防止：bg-gradient-to-* があるのに from/to が無いケースを補う
  if (/bg-gradient-to-/.test(out) && !/from-\[var\(--hd-/.test(out)) {
    out = out.replace(/bg-gradient-to-[trbl]/g, 'bg-gradient-to-t from-[var(--hd-accentA-from)] to-[var(--hd-accentA-to)]');
  }

  return out;
}

// ['className', `...`] or ["className", `...`] を抜き出して中だけ置換
function rewriteOneFile(filePath) {
  if (!fs.existsSync(filePath)) return false;
  const src = fs.readFileSync(filePath, 'utf8');
  let out = src;

  let changed = false;

  // 名前ピンポイントのマッチャ
  for (const name of TARGET_CLASS_NAMES) {
    // ['name', `...`] または ["name", `...`]
    const re = new RegExp(
      String.raw`\[\s*(['"])${name}\1\s*,\s*` +   // ['name',
      String.raw`\`([\s\S]*?)\`\s*\],?`,          //  ` ... `]  （末尾カンマ許容）
      'g',
    );

    out = out.replace(re, (m, quote, body) => {
      const newBody = transform(body, name);
      if (newBody !== body) changed = true;
      return `[${quote}${name}${quote}, \`${newBody}\`]`;
    });
  }

  // 任意の heading 全般を対象にする（必要なら有効化）
  // 例: heading で始まるもの全部
  const genericMatcher = new RegExp(
    String.raw`\[\s*(['"])(heading[0-9][0-9A-Za-z-]*)\1\s*,\s*` + // ['heading05' など
          String.raw`\`([\s\S]*?)\`\s*\],?`,
    'g',
  );

  out = out.replace(genericMatcher, (m, quote, name, body) => {
    // すでにピンポイントで処理したものはスキップ（2重変換防止）
    if (TARGET_CLASS_NAMES.includes(name)) return m;
    const newBody = transform(body, name);
    if (newBody !== body) changed = true;
    return `[${quote}${name}${quote}, \`${newBody}\`]`;
  });

  if (changed) {
    const bak = `${filePath}.bak`;
    fs.writeFileSync(bak, src, 'utf8');
    fs.writeFileSync(filePath, out, 'utf8');
    console.log(`✅ Rewrote: ${path.basename(filePath)} (backup: ${path.basename(bak)})`);
  } else {
    console.log(`— No change: ${path.basename(filePath)}`);
  }
  return changed;
}

let any = false;
for (const t of TARGETS) any = rewriteOneFile(t) || any;

if (!any) {
  console.log('\nHint: パターンが合っているか確認してください:');
  console.log(' - shortcuts 内の記法が ["name", `...`] になっているか');
  console.log(' - クラス名が TARGET_CLASS_NAMES / genericMatcher にヒットしているか');
  console.log(' - backtick 以外のクォートで body を書いていないか（本スクリプトは `...` 前提です）');
}

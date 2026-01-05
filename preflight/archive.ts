// preflight.archive.ts
import type { Preflight } from 'unocss'

/**
 * Archive template specific structural rules.
 * Reusable "card" / "callout" visuals should be shortcuts; only structure here.
 */
export const preflightArchive: Preflight = {
  layer: 'preflights',
  getCSS: () => `
#category-image{display:block;inline-size:100%;block-size:auto}
.page-numbers{display:inline-flex;gap:.25rem;align-items:center}
.pm-biblist__item{list-style:none}
.callout{position:relative}

/* Heading tag combos that must exist only on archive templates */
.archive h1.entry-title{line-height:var(--lh-tight)}

/* Float fixes for legacy markup if needed */
img.alignleft{float:left;margin:0 1rem 1rem 0}
img.alignright{float:right;margin:0 0 1rem 1rem}
blockquote.float-left{float:left;margin:0 1rem 1rem 0}
blockquote.float-right{float:right;margin:0 0 1rem 1rem}

    /* アーカイブ見出しのセレクタ例（旧 SCSS の ID/タグ結合をここに） */
    #archive .section-title {
      margin-block: 1.25rem;
    }
    /* アーカイブ一覧のカード余白最適化など… */
    #archive .post-list > li { padding-block: .75rem; }

/* ===== Archive: layout & spacing ===== */
.archive .archive-grid{display:grid;gap:1rem;grid-template-columns:repeat(auto-fill,minmax(16rem,1fr))}
.archive .archive-list{list-style:none;margin:0;padding:0}
.archive .archive-list > li{margin:0 0 .75rem 0}

/* タイトル帯やカテゴリ画像など（構造のみ） */
.archive .page-header{margin:0 0 1rem 0}
.archive .page-title{margin:.25rem 0 .75rem}

/* サムネイルの角丸・はみ出し防止（構造） */
.archive .thumb{display:block;inline-size:100%;block-size:auto;border-radius:var(--radius-md);overflow:hidden}

/* ページャ（土台は構造、見た目はショートカットで） */
.archive .pager{display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;margin:1rem 0}

/* ===== Archive: layout & structure ===== */
:where(body.archive, .archive, #archive) .archive-grid{
  display:grid;
  gap: 1rem;
}
@media (min-width:640px){
  :where(body.archive, .archive, #archive) .archive-grid{
    grid-template-columns: repeat(2, minmax(0,1fr));
  }
}
@media (min-width:1024px){
  :where(body.archive, .archive, #archive) .archive-grid{
    grid-template-columns: repeat(3, minmax(0,1fr));
  }
}

/* Card: media ratio & fit */
:where(body.archive, .archive, #archive) .archive-card-media{
  aspect-ratio: 16 / 9;
  overflow: hidden;
  position: relative;
  border-top-left-radius: inherit;
  border-top-right-radius: inherit;
}
:where(body.archive, .archive, #archive) .archive-card-media img{
  width:100%; height:100%; object-fit:cover; display:block;
}

/* Overlay (use token gradient) */
:where(body.archive, .archive, #archive) .archive-card-media .overlay{
  position:absolute; inset:0;
  background-image: var(--archive-media-overlay);
  pointer-events:none;
}

/* List style (row layout) */
:where(body.archive, .archive, #archive) .archive-list{
  display:grid; gap: 1rem;
}
:where(body.archive, .archive, #archive) .archive-item{
  display:grid; grid-template-columns: 160px 1fr; gap: .75rem;
  align-items:start;
}
@media (max-width:639px){
  :where(body.archive, .archive, #archive) .archive-item{
    grid-template-columns: 1fr;
  }
}

/* Pagination: reset */
:where(body.archive, .archive, #archive) .pager{
  display:flex; flex-wrap:wrap; gap:.5rem; justify-content:center; align-items:center;
  margin: 1.25rem 0 0;
}
:where(body.archive, .archive, #archive) .pager ul{ list-style:none; margin:0; padding:0; display:flex; gap:.5rem; }
:where(body.archive, .archive, #archive) .pager li{ margin:0; padding:0; }
:where(body.archive, .archive, #archive) .pager a[aria-current="page"]{
  /* current は後述の shortcut と同等の見た目に（保険） */
  background: var(--archive-pager-bg-current);
  color: var(--archive-pager-fg-current);
  border-color: transparent;
}
  `,
}

import type { Preflight } from 'unocss'

export const preflightComments: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== comments: structure ===== */
:where(.comments-area, #comments, .comments) .comment-list{
  list-style: none; margin: 0; padding: 0;
  display: grid; gap: var(--comment-gap);
}
:where(.comments-area, #comments, .comments) .comment-list .children{
  list-style: none; margin: 0; padding-left: var(--comment-indent);
  margin-left: var(--comment-indent);
  display: grid; gap: var(--comment-gap);
  border-left: 1px solid var(--comment-thread-line);
}

/* 1件分の枠 */
:where(.comment-body){
  background: var(--comment-bg);
  border: 1px solid var(--comment-bc);
  border-radius: var(--radius-lg);
  padding: .75rem 1rem;
  box-shadow: var(--comment-shadow);
}

/* メタ行 */
:where(.comment-meta){
  display:flex; flex-wrap:wrap; align-items:center; gap:.5rem .75rem;
  color: var(--comment-meta-fg); font-size: var(--fs-sm);
  margin-bottom: .5rem;
}

/* 著者行（アバター＋名前） */
:where(.comment-author){
  display:flex; align-items:center; gap:.5rem; min-width:0;
  color: var(--comment-author-fg);
}
:where(.comment-author) .avatar{
  width: var(--comment-avatar); height: var(--comment-avatar); border-radius: 999px;
  object-fit: cover; display:block;
}
@media (min-width: 768px){
  :where(.comment-author) .avatar{
    width: var(--comment-avatar-md); height: var(--comment-avatar-md);
  }
}

/* 本文 */
:where(.comment-content){ line-height: var(--lh-normal); }

/* 承認待ち */
:where(.comment-awaiting-moderation){
  display:inline-block; margin-top:.5rem; padding:.25rem .5rem; border-radius: .375rem;
  background: var(--comment-mod-bg);
}

/* 投稿者コメントの強調（任意） */
:where(li.bypostauthor) > .comment-body{
  border-left: 3px solid var(--c-accent);
}
`,
}

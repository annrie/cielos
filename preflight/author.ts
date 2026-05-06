import type { Preflight } from 'unocss'

export const preflightAuthor: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
:where(.author-box, #author-box){
  display:grid; gap: var(--author-gap);
  align-items:start;
  grid-template-columns: auto 1fr;
  padding: 1rem;
  background: var(--author-bg);
  border:1px solid var(--author-bc);
  border-radius: var(--radius-lg);
  box-shadow: var(--author-shadow);
}
@media (max-width:640px){
  :where(.author-box, #author-box){ grid-template-columns: 1fr; }
}
:where(.author-avatar){
  width: var(--author-av-size); height: var(--author-av-size);
  border-radius: 999px; object-fit: cover; display:block;
}
@media (min-width:768px){
  :where(.author-avatar){
    width: var(--author-av-size-md); height: var(--author-av-size-md);
  }
}
`,
}

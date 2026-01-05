import type { Preflight } from 'unocss'
export const preflightRelated: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
:where(.related, #related){
  display:grid; gap: var(--related-gap);
}
:where(.related) .related-grid{
  display:grid; gap: var(--related-gap);
  grid-template-columns: 1fr;
}
@media (min-width:640px){
  :where(.related) .related-grid{ grid-template-columns: repeat(2,minmax(0,1fr)); }
}
@media (min-width:1024px){
  :where(.related) .related-grid{ grid-template-columns: repeat(3,minmax(0,1fr)); }
}
`,
}

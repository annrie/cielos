import type { Preflight } from 'unocss'

export const preflightFooter: Preflight = {
  layer: 'preflights',
  getCSS: () => String.raw`
/* ===== Footer structure ===== */
:where(footer.site-footer, .site-footer, #site-footer){
  background: var(--footer-bg);
  border-top: 1px solid var(--footer-bc);
  color: var(--footer-fg);
}
:where(footer.site-footer, .site-footer, #site-footer) .inner{
  width: var(--container-w); margin-inline:auto;
  padding: var(--footer-gap-y) 1rem;
  display:grid; gap: 1rem;
}
.footer-meta{ font-size: var(--fs-sm); opacity:.9; }
.footer-nav { display:flex; flex-wrap:wrap; gap:.5rem .75rem; }
.footer-nav ul{ list-style:none; margin:0; padding:0; display:flex; flex-wrap:wrap; gap:.5rem .75rem; }

footer, .site-footer, #site-footer{
  display:block !important;
  position:relative !important;
  z-index:1 !important;
  clear:both;
  background: var(--footer-bg) !important;
  color: var(--footer-fg) !important;
  padding-block: var(--footer-py) !important;
  font-size: var(--footer-fs);
  line-height: var(--footer-lh);
  border-top: 1px solid var(--footer-border);
}
footer a{ color:inherit; opacity:.9; text-decoration:none; }
footer a:hover{ color:var(--footer-link-hover); opacity:1; text-decoration:underline; }

/* ===== Footer widgets styling ===== */
/* Reset widget backgrounds to transparent in footer */
footer .widget,
footer .widget-title,
footer .widgettitle,
footer .textwidget,
footer .footer-widget-area{
  background: transparent !important;
  border-color: var(--footer-border, rgba(255,255,255,0.15)) !important;
}

/* Ensure all widget text inherits footer foreground color */
footer .widget,
footer .widget-title,
footer .widgettitle,
footer .textwidget,
footer .widget ul,
footer .widget li,
footer .widget p,
footer .widget span,
footer .footer-widget-area,
footer .footer-widget-area *:not(a){
  color: var(--footer-fg) !important;
}

/* Widget links in footer */
footer .widget a,
footer .footer-widget-area a{
  color: var(--footer-fg) !important;
  opacity: .85;
}
footer .widget a:hover,
footer .footer-widget-area a:hover{
  color: var(--footer-link-hover, #fff) !important;
  opacity: 1;
}

`,
}

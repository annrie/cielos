import type { Preflight } from 'unocss'
import fs from 'node:fs'
import path from 'node:path'
import process from 'node:process'

// preflight index
export function tokensPreflight(tokensPath: string = path.resolve(process.cwd(), 'tokens.css')): Preflight {
  return {
    layer: 'preflights',
    getCSS: () => {
      try {
        const files = [
          tokensPath,
          path.resolve(process.cwd(), 'tokens.css'),
          path.resolve(process.cwd(), 'src/assets/css/tokens.css'),
          tokensPath
            ? tokensPath
            : undefined,
        ].filter(Boolean)
        const css = files
          .map((p) => {
            try {
              return fs.readFileSync(p as string, 'utf8')
            }
            catch {
              return ''
            }
          })
          .filter(Boolean)
          .join('\n')
        return css || `:root{--c-fg:#111;--c-fg-inv:#fff}`
      }
      catch {
        return `:root{--c-fg:#111;--c-fg-inv:#fff}`
      }
    },
  }
}

// re-exports (moved under ./)
export { preflight404 } from './404'
export { preflightA11y } from './a11y'
export { preflightArchive } from './archive'
export { preflightAuthor } from './author'
export { preflightBase, preflightStickyFooter } from './base'
export { preflightBiblio } from './biblio'
export { preflightBreadcrumbs } from './breadcrumbs'
export { preflightChildPages } from './child-pages'
export { preflightComments } from './comments'
export { preflightContent } from './content'
export { preflightDocs } from './docs'
export { preflightFeatureGrid } from './feature-grid'
export { preflightFooter } from './footer'
export { preflightFooterVisibilityGuard } from './footer-visibility-guard'
export { preflightForms } from './forms'
export { preflightHeader } from './header'
export { preflightHeaderDesktopRow } from './header-desktop-row'
export { preflightHeroFeature } from './hero-feature'
export { preflightHeroPage } from './hero-page'
export { preflightLayout } from './layout'
export { preflightMobileMenu } from './mobile-menu'
export { preflightNavSolid } from './nav.solid'
export { preflightPrint } from './print'
export { preflightRelated } from './related'
export { preflightSearch } from './search'
export { preflightSections } from './sections'
export { preflightSidebar } from './sidebar'
export { preflightSingle } from './single'
export { preflightSyntax } from './syntax'
export { tabsPreflight } from './tabs'
export { preflightThemeIcons } from './theme-icons'
export { preflightThemeTransition } from './theme-transition'
export { preflightTop } from './top'
export { preflightWpAdmin } from './wp-admin'

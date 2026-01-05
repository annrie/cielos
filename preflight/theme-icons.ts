// preflight.theme-icons.ts
import type { Preflight } from 'unocss'

export const preflightThemeIcons: Preflight = {
  layer: 'preflights',
  getCSS: () => `
/* ========== テーマアイコン ========== */

/* ボタンを relative に設定 */
#theme-toggle-desktop,
#theme-toggle-mobile{
  position:relative;
}

/* アイコンを中央に絶対配置（重ねて配置、JSで表示制御） */
#theme-toggle-desktop svg,
#theme-toggle-mobile svg{
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  display:none;
}
`,
}

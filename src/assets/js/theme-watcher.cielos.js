const KEY = 'cielos:theme' // 衝突回避用の専用キー

// read() はどこからも呼ばれていない。このファイルは vite.config.ts の入口(watcher)だが、
// PHP からは読み込まれていない(unomoon から写したときのまま)。
// eslint-disable-next-line unused-imports/no-unused-vars, no-unused-vars -- 上の理由で未使用のまま残す
function read() {
  try {
    // 旧キー（'theme'）があればマイグレーションしつつ移行
    const legacy = localStorage.getItem('theme')
    if (legacy === 'light' || legacy === 'dark' || legacy === 'system') {
      localStorage.setItem(KEY, legacy)
      localStorage.removeItem('theme')
      return legacy
    }
    const v = localStorage.getItem(KEY)
    return (v === 'light' || v === 'dark' || v === 'system') ? v : 'system'
  }
  catch { return 'system' }
}

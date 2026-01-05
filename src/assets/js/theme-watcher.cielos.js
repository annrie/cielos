 const KEY = 'cielos:theme'  // 衝突回避用の専用キー

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
    } catch (e) { return 'system' }
  }

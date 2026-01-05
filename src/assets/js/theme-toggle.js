(() => {
  const KEY = 'cielos:theme';
  const root = document.documentElement;
  const sys = matchMedia('(prefers-color-scheme: dark)');

  const isDarkResolved = (v) => {
    if (v === 'system') return sys.matches;
    return v === 'dark';
  };

  const apply = (v) => {
    const dark = isDarkResolved(v);
    const isSystem = v === 'system';
    root.classList.toggle('dark', dark);
    root.style.colorScheme = dark ? 'dark' : 'light';

    // icon sync (desktop + mobile)
    const setIcon = (scope) => {
      const sun  = scope.querySelector('[data-icon="sun"]');
      const moon = scope.querySelector('[data-icon="moon"]');
      const sysIcon = scope.querySelector('[data-icon="system"]');

      if (isSystem) {
        // システムモード：システムアイコンのみ表示
        if (sun) sun.style.display = 'none';
        if (moon) moon.style.display = 'none';
        if (sysIcon) sysIcon.style.display = 'block';
      } else if (dark) {
        // ダークモード：月のみ表示
        if (sun) sun.style.display = 'none';
        if (moon) moon.style.display = 'block';
        if (sysIcon) sysIcon.style.display = 'none';
      } else {
        // ライトモード：太陽のみ表示
        if (sun) sun.style.display = 'block';
        if (moon) moon.style.display = 'none';
        if (sysIcon) sysIcon.style.display = 'none';
      }
    };
    const dBtn = document.getElementById('theme-toggle-desktop');
    const mBtn = document.getElementById('theme-toggle-mobile');
    if (dBtn) setIcon(dBtn);
    if (mBtn) setIcon(mBtn);
  };

  const current = () => localStorage.getItem(KEY) || 'system';
  // cycle: system → light → dark → system
  const cycle = (v) => {
    const order = ['system', 'light', 'dark'];
    const i = order.indexOf(v);
    return order[(i + 1) % order.length];
  };

  // wire buttons (once)
  const wire = (id) => {
    const el = document.getElementById(id);
    if (!el || el.dataset.wired === '1') return;
    el.dataset.wired = '1';
    el.addEventListener('click', () => {
      const v = cycle(current());
      localStorage.setItem(KEY, v);
      apply(v);
    });
  };

  // initial: apply quickly to avoid FOUC
  apply(current());
  wire('theme-toggle-desktop');
  wire('theme-toggle-mobile');

  // follow system only if mode=system
  sys.addEventListener?.('change', () => {
    if ((localStorage.getItem(KEY) || 'system') === 'system') apply('system');
  });
})();

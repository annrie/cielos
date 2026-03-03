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

    // icon sync - all buttons with data-theme-toggle
    const setIcon = (scope) => {
      const sun  = scope.querySelector('[data-icon="sun"]');
      const moon = scope.querySelector('[data-icon="moon"]');
      const sysIcon = scope.querySelector('[data-icon="system"]');

      if (isSystem) {
        if (sun) sun.style.display = 'none';
        if (moon) moon.style.display = 'none';
        if (sysIcon) sysIcon.style.display = 'block';
      } else if (dark) {
        if (sun) sun.style.display = 'none';
        if (moon) moon.style.display = 'block';
        if (sysIcon) sysIcon.style.display = 'none';
      } else {
        if (sun) sun.style.display = 'block';
        if (moon) moon.style.display = 'none';
        if (sysIcon) sysIcon.style.display = 'none';
      }
    };
    document.querySelectorAll('[data-theme-toggle]').forEach(setIcon);
  };

  const current = () => localStorage.getItem(KEY) || 'system';
  // cycle: system → light → dark → system
  const cycle = (v) => {
    const order = ['system', 'light', 'dark'];
    const i = order.indexOf(v);
    return order[(i + 1) % order.length];
  };

  // wire all toggle buttons with data-theme-toggle
  const wireAll = () => {
    document.querySelectorAll('[data-theme-toggle]').forEach(el => {
      if (el.dataset.wired === '1') return;
      el.dataset.wired = '1';
      el.addEventListener('click', () => {
        const v = cycle(current());
        localStorage.setItem(KEY, v);
        apply(v);
      });
    });
  };

  // initial: apply quickly to avoid FOUC
  apply(current());
  wireAll();

  // follow system only if mode=system
  sys.addEventListener?.('change', () => {
    if ((localStorage.getItem(KEY) || 'system') === 'system') apply('system');
  });
})();

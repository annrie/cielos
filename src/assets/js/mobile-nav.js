(() => {
  const btn   = document.querySelector('[data-toggle="mobile-menu"]');
  const panel = document.getElementById('mobile-menu');
  if (!btn || !panel) return;

  // 二重配線防止
  if (btn.dataset.wired === '1') return;
  btn.dataset.wired = '1';

  const setOpen = (open) => {
    if (open) panel.setAttribute('data-open','');
    else panel.removeAttribute('data-open');
    btn.setAttribute('aria-expanded', String(open));
  };

  btn.addEventListener('click', (e) => {
    e.preventDefault();
    setOpen(!panel.hasAttribute('data-open'));
  }, { passive:false });

  // 初期は閉
  setOpen(false);

  // --- サブ：多段対応 ---
  panel.querySelectorAll('li').forEach(li => {
    const sub = li.querySelector(':scope > ul');
    if (!sub) return;

    // 初期閉
    li.setAttribute('aria-expanded','false');

    // 既にトグルがあればスキップ
    if (li.querySelector(':scope > .submenu-toggle')) return;

    // ラベル（a か div）直後に追加
    const row = li.querySelector(':scope > div') || li;
    const label = row.querySelector(':scope > a, :scope > span, :scope > div') || row.firstChild;

    const tgl = document.createElement('button');
    tgl.type = 'button';
    tgl.className = 'submenu-toggle';
    tgl.setAttribute('aria-label','Toggle submenu');
    tgl.innerHTML = '<svg class="chev" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';

    (label && label.parentNode) ? label.parentNode.insertBefore(tgl, label.nextSibling) : li.insertBefore(tgl, sub);

    tgl.addEventListener('click', (ev) => {
      ev.preventDefault();
      const open = li.getAttribute('aria-expanded') === 'true';
      li.setAttribute('aria-expanded', String(!open));
    }, { passive:false });
  });
})();

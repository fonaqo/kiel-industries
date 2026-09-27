(function () {
  function closeMenu(menu, trigger) {
    if (!menu) return;
    menu.hidden = true;
    if (trigger) trigger.setAttribute('aria-expanded', 'false');
  }

  function bindAccountMenu() {
    const trigger = document.getElementById('kiel-header-account-trigger');
    const menu = document.getElementById('kiel-header-account-menu');
    if (!trigger || !menu || trigger.dataset.kielBound) return;
    trigger.dataset.kielBound = '1';

    trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      const open = menu.hidden;
      menu.hidden = !open;
      trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    document.addEventListener('click', (e) => {
      if (!menu.hidden && !e.target.closest('.kiel-header-account')) {
        closeMenu(menu, trigger);
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeMenu(menu, trigger);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindAccountMenu);
  } else {
    bindAccountMenu();
  }
  document.addEventListener('turbo:load', bindAccountMenu);
})();

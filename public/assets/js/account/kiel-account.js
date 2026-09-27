(function () {
  function normalizePath(href) {
    try {
      return new URL(href, window.location.origin).pathname.replace(/\/$/, '') || '/';
    } catch {
      return href;
    }
  }

  function syncSidebarActive(root) {
    const scope = root || document;
    const current = window.location.pathname.replace(/\/$/, '') || '/';
    scope.querySelectorAll('[data-sidebar-nav]').forEach((link) => {
      const target = normalizePath(link.getAttribute('href') || '');
      let active =
        current === target ||
        (target !== '/mon-compte' && target !== '/admin' && current.startsWith(target + '/'));
      if (target === '/mon-compte/commandes' && current.startsWith('/mon-compte/commandes')) {
        active = true;
      }
      if (target === '/admin/commandes' && current.startsWith('/admin/commandes')) {
        active = true;
      }
      if (target === '/mon-compte/favoris' && current.startsWith('/mon-compte/favoris')) {
        active = true;
      }
      if (target === '/admin/favoris' && current.startsWith('/admin/favoris')) {
        active = true;
      }
      link.classList.toggle('is-active', active);
    });
  }

  function wireFramePagination() {
    document.querySelectorAll('#account-main nav a, #admin-main nav a').forEach((link) => {
      if (link.getAttribute('href')?.startsWith('/')) {
        link.setAttribute('data-turbo-frame', link.closest('#admin-main') ? 'admin-main' : 'account-main');
      }
    });
  }

  function wireAvatarPreview(root) {
    const scope = root || document;
    scope.querySelectorAll('[data-kiel-avatar-preview]').forEach((input) => {
      if (input.dataset.kielAvatarBound) return;
      input.dataset.kielAvatarBound = '1';
      input.addEventListener('change', () => {
        const file = input.files?.[0];
        const img = scope.querySelector('[data-kiel-profile-avatar]');
        if (!file || !img) return;
        img.src = URL.createObjectURL(file);
      });
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    syncSidebarActive();
    wireFramePagination();
    wireAvatarPreview();
  });
  document.addEventListener('turbo:frame-load', (e) => {
    syncSidebarActive();
    wireFramePagination();
    wireAvatarPreview(document.getElementById('account-main') || document.getElementById('admin-main') || document);
  });
  document.addEventListener('turbo:load', () => syncSidebarActive());
})();

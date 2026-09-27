(function () {
  function setActiveNav() {
    const page = document.body.dataset.page;
    if (!page) return;
    const nav = document.querySelector('.nav-main');
    const activeClasses = (nav?.dataset.activeClasses || 'text-secondary font-bold')
      .split(/\s+/)
      .filter(Boolean);
    document.querySelectorAll('.nav-main a[data-path]').forEach((link) => {
      link.removeAttribute('aria-current');
      activeClasses.forEach((c) => link.classList.remove(c));
      if (link.dataset.path === page) {
        link.setAttribute('aria-current', 'page');
        activeClasses.forEach((c) => link.classList.add(c));
      }
    });
  }

  function setMenuToggleOpen(open) {
    const toggle = document.getElementById('kiel-site-menu-toggle');
    if (!toggle) return;
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
    const icon = toggle.querySelector('.material-symbols-outlined');
    if (icon) icon.textContent = open ? 'close' : 'menu';
    document.body.classList.toggle('kiel-site-menu-open', open);
  }

  function openDrawer(id) {
    const overlay = document.getElementById('kiel-drawer-overlay');
    const drawer = document.getElementById(id);
    if (!overlay || !drawer) return;
    document.querySelectorAll('.kiel-drawer.is-open').forEach((el) => {
      el.classList.remove('is-open');
      el.setAttribute('aria-hidden', 'true');
    });
    overlay.classList.add('is-open');
    overlay.setAttribute('aria-hidden', 'false');
    drawer.classList.add('is-open');
    drawer.setAttribute('aria-hidden', 'false');
    document.getElementById('header-cart-btn')?.setAttribute('aria-expanded', id === 'kiel-drawer-cart' ? 'true' : 'false');
    document.getElementById('header-wishlist-btn')?.setAttribute('aria-expanded', id === 'kiel-drawer-wishlist' ? 'true' : 'false');
    document.getElementById('header-search-btn')?.setAttribute('aria-expanded', id === 'kiel-drawer-search' ? 'true' : 'false');
    setMenuToggleOpen(id === 'kiel-drawer-nav');
    document.body.classList.add('kiel-drawer-open');
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
    if (id === 'kiel-drawer-search') {
      requestAnimationFrame(() => {
        document.getElementById('header-search-q')?.focus();
      });
    }
  }

  function closeDrawers() {
    document.querySelectorAll('.kiel-drawer.is-open').forEach((el) => {
      el.classList.remove('is-open');
      el.setAttribute('aria-hidden', 'true');
    });
    const overlay = document.getElementById('kiel-drawer-overlay');
    overlay?.classList.remove('is-open');
    overlay?.setAttribute('aria-hidden', 'true');
    document.getElementById('header-cart-btn')?.setAttribute('aria-expanded', 'false');
    document.getElementById('header-wishlist-btn')?.setAttribute('aria-expanded', 'false');
    document.getElementById('header-search-btn')?.setAttribute('aria-expanded', 'false');
    setMenuToggleOpen(false);
    document.body.classList.remove('kiel-drawer-open');
    document.body.style.removeProperty('overflow');
    document.documentElement.style.removeProperty('overflow');
  }

  function bindDrawerUi() {
    if (document.body.dataset.kielDrawersBound === 'true') return;
    document.body.dataset.kielDrawersBound = 'true';

    window.KielSite = { openDrawer, closeDrawers };

    document.addEventListener('click', (e) => {
      if (e.target.closest('#header-cart-btn')) {
        e.preventDefault();
        openDrawer('kiel-drawer-cart');
        window.KielCart?.refresh?.().catch(() => null);
        return;
      }
      if (e.target.closest('#header-wishlist-btn')) {
        e.preventDefault();
        window.KielWishlist?.load?.();
        openDrawer('kiel-drawer-wishlist');
        return;
      }
      if (e.target.closest('#header-search-btn')) {
        e.preventDefault();
        openDrawer('kiel-drawer-search');
        return;
      }
      if (e.target.closest('[data-drawer-close]')) {
        e.preventDefault();
        closeDrawers();
        return;
      }
      if (e.target.closest('#cart-drawer-goto-panier')) {
        closeDrawers();
      }
    });

    document.getElementById('kiel-drawer-overlay')?.addEventListener('click', closeDrawers);

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeDrawers();
    });
  }

  function setActiveMobileNav() {
    const page = document.body.dataset.page;
    if (!page) return;
    document.querySelectorAll('#kiel-site-mobile-nav a[data-path]').forEach((link) => {
      link.classList.toggle('is-active', link.dataset.path === page);
    });
  }

  function bindMobileSiteNav() {
    const toggle = document.getElementById('kiel-site-menu-toggle');
    const navDrawer = document.getElementById('kiel-drawer-nav');
    if (!toggle || !navDrawer || toggle.dataset.kielBound) return;
    toggle.dataset.kielBound = 'true';

    toggle.addEventListener('click', () => {
      if (navDrawer.classList.contains('is-open')) {
        closeDrawers();
      } else {
        openDrawer('kiel-drawer-nav');
      }
    });

    navDrawer.querySelectorAll('#kiel-site-mobile-nav a').forEach((link) => {
      link.addEventListener('click', () => closeDrawers());
    });
  }

  function init() {
    if (!document.querySelector('.kiel-drawer.is-open')) {
      document.body.classList.remove('kiel-drawer-open');
      document.body.style.removeProperty('overflow');
    }
    document.documentElement.style.removeProperty('overflow');
    setActiveNav();
    setActiveMobileNav();
    bindMobileSiteNav();
    window.KielCurrency?.initSwitch?.();
    bindDrawerUi();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  document.addEventListener('turbo:load', init);
})();

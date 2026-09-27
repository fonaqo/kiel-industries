(function () {
  const PARTIALS = {
    'kiel-site-header': 'assets/partials/site-header.html',
    'kiel-site-footer': 'assets/partials/site-footer.html',
    'kiel-site-drawers': 'assets/partials/site-drawers.html',
  };

  async function injectPartial(id) {
    const host = document.getElementById(id);
    if (!host) return;
    try {
      const res = await fetch(PARTIALS[id], { cache: 'no-cache' });
      if (!res.ok) throw new Error(res.statusText);
      host.innerHTML = await res.text();
      host.removeAttribute('aria-busy');
      host.classList.remove('kiel-chrome-slot--loading');
    } catch (e) {
      host.innerHTML =
        '<p class="kiel-chrome-fallback">Navigation indisponible — <a href="index.html">retour à l’accueil</a></p>';
    }
  }

  function setActiveNav() {
    const page = document.body.dataset.page;
    if (!page) return;
    document.querySelectorAll('.nav-main a[data-path]').forEach((link) => {
      link.removeAttribute('aria-current');
      if (link.dataset.path === page) {
        link.setAttribute('aria-current', 'page');
      }
    });
  }

  function initCurrencySwitch() {
    const root = document.getElementById('currency-switch');
    if (!root) return;
    root.querySelectorAll('.currency-btn').forEach((btn) => {
      btn.addEventListener('click', () => {
        root.querySelectorAll('.currency-btn').forEach((b) => b.setAttribute('aria-pressed', 'false'));
        btn.setAttribute('aria-pressed', 'true');
      });
    });
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
    document.getElementById('header-cart-btn')?.setAttribute(
      'aria-expanded',
      id === 'kiel-drawer-cart' ? 'true' : 'false'
    );
    document.getElementById('header-wishlist-btn')?.setAttribute(
      'aria-expanded',
      id === 'kiel-drawer-wishlist' ? 'true' : 'false'
    );
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
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
    document.body.style.overflow = '';
    document.documentElement.style.removeProperty('overflow');
  }

  function initDrawers() {
    document.getElementById('header-cart-btn')?.addEventListener('click', () => openDrawer('kiel-drawer-cart'));
    document.getElementById('header-wishlist-btn')?.addEventListener('click', () =>
      openDrawer('kiel-drawer-wishlist')
    );
    document.getElementById('kiel-drawer-overlay')?.addEventListener('click', closeDrawers);
    document.querySelectorAll('[data-drawer-close]').forEach((el) => {
      el.addEventListener('click', closeDrawers);
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeDrawers();
    });
    const cartFoot = document.querySelector('#kiel-drawer-cart .kiel-drawer__foot');
    if (cartFoot && !cartFoot.querySelector('[data-cart-checkout]')) {
      const checkout = document.createElement('a');
      checkout.href = 'recap-panier.html';
      checkout.className = 'kiel-drawer__cta';
      checkout.style.marginTop = '0.5rem';
      checkout.textContent = 'Voir le panier';
      checkout.dataset.cartCheckout = '1';
      cartFoot.appendChild(checkout);
    }
  }

  async function initKielChrome() {
    await Promise.all(Object.keys(PARTIALS).map((id) => injectPartial(id)));
    setActiveNav();
    initCurrencySwitch();
    initDrawers();
    document.dispatchEvent(new CustomEvent('kiel-chrome-ready'));
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initKielChrome);
  } else {
    initKielChrome();
  }
})();

(function () {
  const STORAGE_KEY = 'kiel_wishlist_v1';

  const state = {
    items: [],
    useServer: false,
    urls: {},
  };

  function readStore() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      const parsed = raw ? JSON.parse(raw) : [];
      return Array.isArray(parsed) ? parsed : [];
    } catch {
      return [];
    }
  }

  function writeStore() {
    if (state.useServer) {
      return;
    }
    localStorage.setItem(STORAGE_KEY, JSON.stringify(state.items));
  }

  function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  }

  function readConfig() {
    const body = document.body;
    state.useServer = body?.dataset.wishlistAuth === '1';
    state.urls = {
      items: body?.dataset.wishlistItemsUrl || '',
      sync: body?.dataset.wishlistSyncUrl || '',
      toggle: body?.dataset.wishlistToggleUrl || '',
    };
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/"/g, '&quot;');
  }

  function itemKey(item) {
    return item.product_id ? `id:${item.product_id}` : `name:${item.name}`;
  }

  async function fetchJson(url, options = {}) {
    const res = await fetch(url, {
      credentials: 'same-origin',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken(),
        'X-Requested-With': 'XMLHttpRequest',
        ...(options.headers || {}),
      },
      ...options,
    });
    if (!res.ok) {
      throw new Error('wishlist_request_failed');
    }
    return res.json();
  }

  async function fetchServerItems() {
    const data = await fetchJson(state.urls.items);
    state.items = Array.isArray(data.items) ? data.items : [];
  }

  async function syncLocalToServer() {
    const local = readStore();
    const ids = local.map((item) => item.product_id).filter(Boolean);
    const data = await fetchJson(state.urls.sync, {
      method: 'POST',
      body: JSON.stringify({ product_ids: ids }),
    });
    state.items = Array.isArray(data.items) ? data.items : [];
    if (ids.length) {
      try {
        localStorage.removeItem(STORAGE_KEY);
      } catch {
        /* ignore */
      }
    }
  }

  function readBootstrap() {
    const el = document.getElementById('kiel-wishlist-bootstrap');
    if (!el) return null;
    try {
      const parsed = JSON.parse(el.textContent || '[]');
      return Array.isArray(parsed) ? parsed : null;
    } catch {
      return null;
    }
  }

  function hydrate(items) {
    if (!Array.isArray(items)) return;
    state.items = items;
    renderBadge();
    renderDrawer();
    renderAccountPanel();
    syncToggleButtons();
  }

  async function load() {
    readConfig();
    const bootstrap = readBootstrap();

    if (state.useServer && state.urls.sync && state.urls.items) {
      try {
        await syncLocalToServer();
        await fetchServerItems();
      } catch {
        state.items = bootstrap?.length ? bootstrap : readStore();
      }
    } else if (bootstrap?.length) {
      state.items = bootstrap;
    } else {
      state.items = readStore();
    }

    renderBadge();
    renderDrawer();
    renderAccountPanel();
    syncToggleButtons();
    document.dispatchEvent(new CustomEvent('kiel:wishlist-updated', { detail: [...state.items] }));
  }

  function renderBadge() {
    const count = String(state.items.length);
    const badge = document.getElementById('wishlist-badge');
    if (badge) badge.textContent = count;
    const accountStat = document.getElementById('kiel-account-wishlist-count');
    if (accountStat) accountStat.textContent = count;
  }

  function renderAccountPanel() {
    const list = document.getElementById('kiel-account-wishlist-list');
    const empty = document.getElementById('kiel-account-wishlist-empty');
    if (!list || !empty) return;

    if (!state.items.length) {
      list.innerHTML = '';
      empty.hidden = false;
      return;
    }

    empty.hidden = true;
    list.innerHTML = state.items
      .map(
        (item, index) => `
        <article class="kiel-account-wishlist__item" data-wish-index="${index}">
          <a class="kiel-account-wishlist__thumb" href="${escapeHtml(item.url || '/boutique')}">
            <img alt="" loading="lazy" src="${escapeHtml(item.image || '')}"/>
          </a>
          <div class="kiel-account-wishlist__body">
            <h3><a href="${escapeHtml(item.url || '/boutique')}">${escapeHtml(item.name)}</a></h3>
            <p class="kiel-account-wishlist__price">${item.price ? `${Number(item.price).toLocaleString('fr-FR')} FCFA` : ''}</p>
            <div class="kiel-account-wishlist__actions">
              ${
                item.product_id
                  ? `<button type="button" data-kiel-add-cart="${item.product_id}">Ajouter au panier</button>`
                  : ''
              }
              <button type="button" class="kiel-account-wishlist__remove" data-wish-remove="${index}"${
                item.product_id ? ` data-wish-product-id="${item.product_id}"` : ''
              }>Retirer</button>
            </div>
          </div>
        </article>`
      )
      .join('');
  }

  function renderDrawer() {
    const body = document.getElementById('wishlist-drawer-body');
    if (!body) return;
    if (!state.items.length) {
      body.innerHTML =
        '<p class="kiel-drawer__empty">Aucun favori pour le moment. Cliquez sur le cœur sur un produit pour l’enregistrer.</p>';
      return;
    }
    body.innerHTML = state.items
      .map(
        (item, index) => `
        <div class="kiel-drawer-line" data-wish-index="${index}">
          <img class="kiel-drawer-line__thumb" alt="" loading="lazy" src="${escapeHtml(item.image || '')}"/>
          <div class="kiel-drawer-line__body">
            <strong>${escapeHtml(item.name)}</strong>
            <span class="kiel-drawer-line__price">${item.price ? `${Number(item.price).toLocaleString('fr-FR')} FCFA` : 'Favori'}</span>
            <div class="kiel-drawer-line__actions">
              ${
                item.product_id
                  ? `<button type="button" class="kiel-drawer-line__add" data-wish-add="${item.product_id}">Ajouter au panier</button>`
                  : ''
              }
              <button type="button" class="kiel-drawer-line__remove" data-wish-remove="${index}"${
                item.product_id ? ` data-wish-product-id="${item.product_id}"` : ''
              }>Retirer</button>
            </div>
          </div>
        </div>`
      )
      .join('');
  }

  function syncToggleButtons() {
    const keys = new Set(state.items.map(itemKey));
    document.querySelectorAll('[data-kiel-wishlist]').forEach((btn) => {
      const productId = parseInt(btn.getAttribute('data-kiel-wishlist'), 10);
      const name = btn.getAttribute('data-wish-name') || '';
      const key = productId ? `id:${productId}` : `name:${name}`;
      const on = keys.has(key);
      btn.classList.toggle('is-wishlisted', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
      const icon = btn.querySelector('.material-symbols-outlined');
      if (icon) {
        icon.style.fontVariationSettings = on ? "'FILL' 1" : "'FILL' 0";
        icon.classList.toggle('text-secondary', on);
      }
    });
  }

  function pushLocalToggle(btn) {
    const productId = parseInt(btn.getAttribute('data-kiel-wishlist'), 10) || null;
    const name = btn.getAttribute('data-wish-name') || 'Produit KIEL';
    const price = parseInt(btn.getAttribute('data-wish-price') || '0', 10) || 0;
    const image = btn.getAttribute('data-wish-image') || '';
    const url = btn.getAttribute('data-wish-url') || '';

    const existingIdx = state.items.findIndex((item) => {
      if (productId && item.product_id === productId) return true;
      return !productId && item.name === name;
    });

    if (existingIdx >= 0) {
      state.items.splice(existingIdx, 1);
    } else {
      state.items.push({ product_id: productId, name, price, image, url });
    }
    writeStore();
  }

  async function toggleFromButton(btn) {
    const productId = parseInt(btn.getAttribute('data-kiel-wishlist'), 10) || null;

    if (state.useServer && productId && state.urls.toggle) {
      try {
        const data = await fetchJson(state.urls.toggle, {
          method: 'POST',
          body: JSON.stringify({ product_id: productId }),
        });
        state.items = Array.isArray(data.items) ? data.items : [];
      } catch {
        pushLocalToggle(btn);
      }
    } else {
      pushLocalToggle(btn);
    }

    renderBadge();
    renderDrawer();
    renderAccountPanel();
    syncToggleButtons();
    document.dispatchEvent(new CustomEvent('kiel:wishlist-updated', { detail: [...state.items] }));
  }

  async function removeAtIndex(idx, productId) {
    if (state.useServer && productId && state.urls.toggle) {
      try {
        const data = await fetchJson(state.urls.toggle, {
          method: 'POST',
          body: JSON.stringify({ product_id: productId }),
        });
        state.items = Array.isArray(data.items) ? data.items : [];
      } catch {
        state.items.splice(idx, 1);
        writeStore();
      }
    } else {
      state.items.splice(idx, 1);
      writeStore();
    }
    renderBadge();
    renderDrawer();
    renderAccountPanel();
    syncToggleButtons();
    document.dispatchEvent(new CustomEvent('kiel:wishlist-updated', { detail: [...state.items] }));
  }

  function bindClicks() {
    document.addEventListener('click', async (e) => {
      const wishBtn = e.target.closest('[data-kiel-wishlist]');
      if (wishBtn) {
        e.preventDefault();
        e.stopPropagation();
        await toggleFromButton(wishBtn);
        return;
      }

      const removeBtn = e.target.closest('[data-wish-remove]');
      if (removeBtn) {
        e.preventDefault();
        const idx = parseInt(removeBtn.getAttribute('data-wish-remove'), 10);
        const productId = parseInt(removeBtn.getAttribute('data-wish-product-id') || '0', 10) || null;
        if (!Number.isNaN(idx)) {
          await removeAtIndex(idx, productId);
        }
        return;
      }

      const addBtn = e.target.closest('[data-wish-add]');
      if (addBtn) {
        e.preventDefault();
        const id = parseInt(addBtn.getAttribute('data-wish-add'), 10);
        if (id && window.KielCart?.addProduct) {
          try {
            await window.KielCart.addProduct(id, 1);
            window.KielSite?.openDrawer?.('kiel-drawer-cart');
          } catch {
            /* ignore */
          }
        }
      }
    });
  }

  window.KielWishlist = {
    load,
    hydrate,
    items: () => state.items,
    refresh: load,
    renderAccountPanel,
  };

  document.addEventListener('DOMContentLoaded', () => {
    load();
    bindClicks();
  });

  document.addEventListener('turbo:load', () => {
    load();
  });

  document.addEventListener('turbo:frame-load', (e) => {
    if (e.target?.id === 'account-main' || e.target?.id === 'admin-main') {
      load();
    }
  });

  document.addEventListener('kiel:wishlist-updated', () => {
    renderAccountPanel();
  });

  document.addEventListener('kiel:cart-updated', () => syncToggleButtons());
})();

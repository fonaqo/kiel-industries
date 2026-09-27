(function () {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const cartUrl = document.body?.dataset.cartUrl || '/cart';
  const cartAddUrl = document.body?.dataset.cartAddUrl || '/cart/add';
  const cartSyncUrl = document.body?.dataset.cartSyncUrl || '/cart/sync';
  const CART_STORAGE_KEY = 'kiel_cart_v1';

  const state = {
    lines: [],
    count: 0,
    subtotal_fcfa: 0,
    shipping_fcfa: 0,
    total_fcfa: 0,
  };

  function fmt(n) {
    return Number(n || 0).toLocaleString('fr-FR');
  }

  function formatMoney(amountFcfa) {
    if (window.KielCurrency?.formatFcfa) {
      return window.KielCurrency.formatFcfa(Number(amountFcfa || 0));
    }
    return `${fmt(amountFcfa)} FCFA`;
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/"/g, '&quot;');
  }

  function readLocalCart() {
    try {
      const raw = localStorage.getItem(CART_STORAGE_KEY);
      const parsed = raw ? JSON.parse(raw) : null;
      return parsed && Array.isArray(parsed.lines) ? parsed.lines : [];
    } catch {
      return [];
    }
  }

  function writeLocalCart(data) {
    try {
      localStorage.setItem(
        CART_STORAGE_KEY,
        JSON.stringify({
          lines: data.lines || [],
          updated_at: Date.now(),
        })
      );
    } catch {
      /* ignore quota */
    }
  }

  async function api(url, options = {}) {
    const res = await fetch(url, {
      credentials: 'same-origin',
      headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf,
        'X-Requested-With': 'XMLHttpRequest',
        ...(options.headers || {}),
      },
      ...options,
    });
    const text = await res.text();
    let data;
    try {
      data = JSON.parse(text);
    } catch {
      throw new Error('invalid_json');
    }
    if (!res.ok) {
      throw new Error(data.message || 'cart_request_failed');
    }
    return data;
  }

  function showToast(line, addedQty = 1) {
    const toast = document.getElementById('cart-toast');
    const title = document.getElementById('toast-title');
    const msg = document.getElementById('toast-msg');
    const img = document.getElementById('cart-toast-img');
    if (!toast || !title || !msg) return;
    title.textContent = line?.name || 'Produit ajouté';
    const qty = Math.max(1, addedQty || 1);
    const total = (line?.price || 0) * qty;
    msg.textContent = `${formatMoney(total)}${qty > 1 ? ` (${qty} unités)` : ''} ajouté au panier.`;
    const fallback = document.getElementById('cart-toast-fallback');
    if (img && line?.image) {
      img.src = line.image;
      img.hidden = false;
      if (fallback) fallback.hidden = true;
    } else {
      if (img) img.hidden = true;
      if (fallback) fallback.hidden = false;
    }
    toast.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
    toast.classList.add('translate-y-0', 'opacity-100');
    clearTimeout(showToast._t);
    showToast._t = setTimeout(() => {
      toast.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
      toast.classList.remove('translate-y-0', 'opacity-100');
    }, 3200);
  }

  function updateDrawerFoot() {
    const foot = document.getElementById('cart-drawer-foot');
    const hasItems = (state.lines?.length || 0) > 0;
    if (foot) foot.hidden = !hasItems;
    if (!hasItems) return;
    const totalEl = document.getElementById('cart-drawer-total');
    if (totalEl) totalEl.textContent = formatMoney(state.total_fcfa);
    const subEl = document.getElementById('cart-drawer-subtotal');
    if (subEl) subEl.textContent = formatMoney(state.subtotal_fcfa);
  }

  function applyPayload(data) {
    Object.assign(state, data);
    writeLocalCart(data);
    const badge = document.getElementById('cart-badge');
    if (badge) badge.textContent = String(state.count || 0);
    renderCartDrawer();
    renderPanierPage();
    updateDrawerFoot();
    document.dispatchEvent(new CustomEvent('kiel:cart-updated', { detail: state }));
  }

  async function syncLocalToServer() {
    const localLines = readLocalCart();
    if (!localLines.length) return null;
    const payload = localLines.map((line) => ({
      product_id: line.product_id,
      qty: line.qty,
    }));
    return api(cartSyncUrl, {
      method: 'POST',
      body: JSON.stringify({ lines: payload }),
    });
  }

  function localDiffersFromServer(localLines, serverData) {
    const serverLines = serverData?.lines || [];
    if (!localLines.length) {
      return false;
    }
    if (!serverLines.length) {
      return true;
    }
    const serverById = new Map(serverLines.map((l) => [l.product_id, l.qty]));
    return localLines.some((line) => {
      const serverQty = serverById.get(line.product_id);
      return serverQty === undefined || (line.qty || 0) > serverQty;
    });
  }

  function computeTotalsFromLines(lines) {
    const subtotal = lines.reduce((s, l) => s + (l.price || 0) * (l.qty || 0), 0);
    const shipping = subtotal >= 40000 || !lines.length ? 0 : 2500;
    return {
      subtotal_fcfa: subtotal,
      shipping_fcfa: shipping,
      total_fcfa: subtotal + shipping,
      count: lines.reduce((s, l) => s + (l.qty || 0), 0),
    };
  }

  async function refresh() {
    let data = await api(cartUrl);
    const localLines = readLocalCart();
    if (localDiffersFromServer(localLines, data)) {
      try {
        const synced = await syncLocalToServer();
        if (synced) {
          data = synced;
        }
      } catch {
        /* keep server cart */
      }
    }
    applyPayload(data);
    return data;
  }

  async function addProduct(productId, qty = 1) {
    const data = await api(cartAddUrl, {
      method: 'POST',
      body: JSON.stringify({ product_id: productId, qty }),
    });
    applyPayload(data);
    const line =
      data.lines?.find((l) => l.product_id === productId) || data.lines?.[data.lines.length - 1];
    showToast(line, qty);
    return data;
  }

  async function updateQty(productId, qty) {
    const data = await api(`${cartUrl}/${productId}`, {
      method: 'PATCH',
      body: JSON.stringify({ qty }),
    });
    applyPayload(data);
  }

  async function removeLine(productId) {
    const data = await api(`${cartUrl}/${productId}`, { method: 'DELETE' });
    applyPayload(data);
  }

  function renderCartDrawer() {
    const body = document.getElementById('cart-drawer-body');
    if (!body) return;
    if (!state.lines?.length) {
      body.innerHTML = `
        <div class="kiel-empty-state kiel-empty-state--drawer">
          <p>Votre panier est vide.</p>
          <a class="kiel-btn kiel-btn--primary" href="${document.body.dataset.boutiqueUrl || '/boutique'}" data-turbo-frame="_top">Aller à la boutique</a>
        </div>`;
      return;
    }
    body.innerHTML = state.lines
      .map(
        (line) => `
        <div class="kiel-drawer-line" data-product-id="${line.product_id}">
          <img class="kiel-drawer-line__thumb" alt="" loading="lazy" src="${escapeHtml(line.image || '')}"/>
          <div class="kiel-drawer-line__body">
            <strong>${escapeHtml(line.name)}</strong>
            <span class="kiel-drawer-line__price">${formatMoney(line.price * line.qty)}</span>
            <div class="kiel-drawer-line__actions">
              <div class="product-qty" data-min="1">
                <button type="button" aria-label="Diminuer" data-cart-qty-minus="${line.product_id}">−</button>
                <span class="product-qty-value">${line.qty}</span>
                <button type="button" aria-label="Augmenter" data-cart-qty-plus="${line.product_id}">+</button>
              </div>
              <button type="button" class="kiel-drawer-line__remove" data-cart-remove="${line.product_id}">Supprimer</button>
            </div>
          </div>
        </div>`
      )
      .join('');
  }

  function renderPanierPage() {
    const root = document.getElementById('kiel-panier-root');
    if (!root) return;

    if (!state.lines?.length) {
      root.innerHTML = `
        <div class="kiel-empty-state">
          <p>Votre panier est vide.</p>
          <a class="kiel-btn kiel-btn--primary" href="${document.body.dataset.boutiqueUrl || '/boutique'}" data-turbo-frame="_top">Aller à la boutique</a>
        </div>`;
      return;
    }

    const rows = state.lines
      .map(
        (line) => `
      <article class="kiel-panier-line" data-product-id="${line.product_id}">
        <div class="kiel-panier-line__media"><img alt="" src="${escapeHtml(line.image || '')}"/></div>
        <div class="kiel-panier-line__info">
          <h2>${escapeHtml(line.name)}</h2>
          <p>${formatMoney(line.price)} / unité</p>
          <button type="button" class="kiel-panier-line__remove" data-cart-remove="${line.product_id}">Retirer</button>
        </div>
        <div class="kiel-panier-line__qty">
          <button type="button" data-cart-qty-minus="${line.product_id}">−</button>
          <span>${line.qty}</span>
          <button type="button" data-cart-qty-plus="${line.product_id}">+</button>
        </div>
        <div class="kiel-panier-line__total">${formatMoney(line.price * line.qty)}</div>
      </article>`
      )
      .join('');

    root.innerHTML = `
      <div class="kiel-panier-layout">
        <div class="kiel-panier-lines">${rows}</div>
        <aside class="kiel-panier-summary">
          <h3>Récapitulatif</h3>
          <p><span>Sous-total</span><strong>${formatMoney(state.subtotal_fcfa)}</strong></p>
          <p><span>Livraison</span><strong>${state.shipping_fcfa ? formatMoney(state.shipping_fcfa) : 'Offerte'}</strong></p>
          <p class="kiel-panier-summary__total"><span>Total</span><strong>${formatMoney(state.total_fcfa)}</strong></p>
          <a class="kiel-btn kiel-btn--primary kiel-panier-summary__cta" href="${document.body.dataset.commandeUrl || '/commande'}">Finaliser la commande</a>
          <a class="kiel-panier-summary__link" href="${document.body.dataset.boutiqueUrl || '/boutique'}">Continuer mes achats</a>
        </aside>
      </div>`;
  }

  function panierLoadError() {
    const root = document.getElementById('kiel-panier-root');
    if (!root) return;
    root.innerHTML = `
      <div class="kiel-panier-empty">
        <p>Impossible de charger le panier. Vérifiez votre connexion et rechargez la page.</p>
        <button type="button" class="kiel-btn kiel-btn--primary" id="kiel-panier-retry">Réessayer</button>
      </div>`;
    document.getElementById('kiel-panier-retry')?.addEventListener('click', () => {
      root.innerHTML = '<p class="text-center text-on-surface-variant">Chargement…</p>';
      refresh().catch(panierLoadError);
    });
  }

  function resolveQty(addBtn) {
    const source = addBtn.getAttribute('data-qty-source');
    if (source === 'pdp') {
      const input = document.querySelector('[data-kiel-pdp-qty]');
      return Math.max(1, parseInt(input?.value || '1', 10) || 1);
    }
    const card = addBtn.closest('.product-item, .kiel-shop-card, .featured-product-card');
    const valueEl = card?.querySelector('.product-qty-value');
    if (valueEl) {
      return Math.max(1, parseInt(valueEl.textContent || '1', 10) || 1);
    }
    return parseInt(addBtn.getAttribute('data-qty') || '1', 10) || 1;
  }

  function commandeUrl() {
    return document.body?.dataset.commandeUrl || '/commande';
  }

  async function goToCheckout() {
    try {
      await refresh();
    } catch {
      /* navigation même si sync échoue */
    }
    window.location.href = commandeUrl();
  }

  function bindGlobalClicks() {
    document.addEventListener('click', async (e) => {
      const checkoutLink = e.target.closest('a[href*="/commande"]');
      if (checkoutLink && checkoutLink.getAttribute('href') === commandeUrl()) {
        e.preventDefault();
        await goToCheckout();
        return;
      }

      const buyBtn = e.target.closest('[data-kiel-buy-now]');
      if (buyBtn) {
        e.preventDefault();
        e.stopPropagation();
        const id = parseInt(buyBtn.getAttribute('data-kiel-buy-now'), 10);
        if (!id) return;
        const qty = resolveQty(buyBtn);
        buyBtn.disabled = true;
        try {
          await addProduct(id, qty);
          await goToCheckout();
        } catch {
          buyBtn.disabled = false;
          alert('Impossible de préparer la commande.');
        }
        return;
      }

      const addBtn = e.target.closest('[data-kiel-add-cart]');
      if (addBtn) {
        e.preventDefault();
        e.stopPropagation();
        const id = parseInt(addBtn.getAttribute('data-kiel-add-cart'), 10);
        if (!id) return;
        const qty = resolveQty(addBtn);
        try {
          await addProduct(id, qty);
          addBtn.classList.add('is-added');
          setTimeout(() => addBtn.classList.remove('is-added'), 600);
        } catch {
          alert('Impossible d’ajouter au panier.');
        }
        return;
      }

      const openCart = e.target.closest('[data-kiel-open-cart]');
      if (openCart) {
        e.preventDefault();
        try {
          await refresh();
        } catch {
          /* ignore */
        }
        window.KielSite?.openDrawer?.('kiel-drawer-cart');
        return;
      }

      const removeBtn = e.target.closest('[data-cart-remove]');
      if (removeBtn) {
        e.preventDefault();
        const id = parseInt(removeBtn.getAttribute('data-cart-remove'), 10);
        if (id) {
          try {
            await removeLine(id);
          } catch {
            /* ignore */
          }
        }
        return;
      }

      const minus = e.target.closest('[data-cart-qty-minus]');
      const plus = e.target.closest('[data-cart-qty-plus]');
      const control = minus || plus;
      if (!control) return;
      e.preventDefault();
      const id = parseInt(control.getAttribute(minus ? 'data-cart-qty-minus' : 'data-cart-qty-plus'), 10);
      const line = state.lines.find((l) => l.product_id === id);
      if (!line) return;
      const next = minus ? line.qty - 1 : line.qty + 1;
      try {
        await updateQty(id, next);
      } catch {
        /* ignore */
      }
    });
  }

  window.KielCart = { refresh, addProduct, state: () => state };

  function bootCartPage() {
    if (document.getElementById('kiel-panier-root')) {
      refresh().catch(panierLoadError);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    bindGlobalClicks();
    refresh().catch(() => {
      const local = readLocalCart();
      if (local.length) {
        applyPayload({ lines: local, ...computeTotalsFromLines(local) });
      }
    });
    bootCartPage();
  });

  document.addEventListener('turbo:frame-load', () => {
    bootCartPage();
  });

  document.addEventListener('kiel:currency-changed', () => {
    renderCartDrawer();
    renderPanierPage();
    updateDrawerFoot();
  });
})();

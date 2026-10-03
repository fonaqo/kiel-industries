(function () {
  const root = document.getElementById('kiel-shop-live');
  if (!root) return;

  const filtersPanel = root.querySelector('.kiel-shop-filters-panel');
  const filtersDesktopMq = window.matchMedia('(min-width: 992px)');

  function syncFiltersPanelOpen() {
    if (!filtersPanel) return;
    if (filtersDesktopMq.matches) {
      filtersPanel.setAttribute('open', '');
    } else {
      filtersPanel.removeAttribute('open');
    }
  }

  syncFiltersPanelOpen();
  filtersDesktopMq.addEventListener('change', syncFiltersPanelOpen);

  const boutiqueUrl = document.body.dataset.boutiqueUrl || '/boutique';
  let debounceTimer;

  function buildUrl(params) {
    const url = new URL(boutiqueUrl, window.location.origin);
    Object.entries(params).forEach(([key, value]) => {
      if (value !== '' && value !== null && value !== undefined && value !== false) {
        url.searchParams.set(key, value);
      }
    });
    return url;
  }

  function currentParams() {
    const sidebar = root.querySelector('.kiel-shop-sidebar');
    const params = {};
    sidebar?.querySelectorAll('[name]').forEach((el) => {
      if (el.type === 'checkbox') {
        if (el.checked) params[el.name] = el.value;
      } else if (el.type === 'search' || el.type === 'number' || el.tagName === 'SELECT') {
        if (el.value !== '') params[el.name] = el.value;
      }
    });
    const sort = root.querySelector('[data-shop-sort-form] select[name="tri"]');
    if (sort?.value) params.tri = sort.value;
    return params;
  }

  async function fetchResults(url, pushState = true) {
    root.classList.add('is-loading');
    try {
      const res = await fetch(url.toString(), {
        headers: {
          Accept: 'application/json',
          'X-Kiel-Shop-Partial': '1',
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'same-origin',
      });
      const data = await res.json();
      const target = document.getElementById('kiel-shop-results');
      if (target && data.html) {
        target.innerHTML = data.html;
        window.KielWishlist?.load?.();
        window.KielCurrency?.applyDom?.(target);
      }
      if (pushState) {
        window.history.pushState({ shop: true }, '', url.pathname + url.search);
      }
    } catch {
      window.location.href = url.toString();
    } finally {
      root.classList.remove('is-loading');
    }
  }

  function onFilterChange() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      fetchResults(buildUrl(currentParams()));
    }, 280);
  }

  root.addEventListener('submit', (e) => {
    const form = e.target.closest('form');
    if (!form || !root.contains(form)) return;
    if (form.matches('[data-shop-sort-form]')) return;
    e.preventDefault();
    fetchResults(buildUrl(currentParams()));
  });

  root.addEventListener('change', (e) => {
    if (e.target.matches('[data-shop-auto-submit], .kiel-shop-filter-check input, .kiel-shop-sidebar select')) {
      onFilterChange();
    }
  });

  root.addEventListener('input', (e) => {
    if (e.target.matches('#shop-q, .kiel-shop-sidebar input[type="number"]')) {
      onFilterChange();
    }
  });

  root.addEventListener('click', (e) => {
    const cat = e.target.closest('.kiel-shop-filter-group a[href*="boutique"]');
    if (cat && root.contains(cat)) {
      e.preventDefault();
      fetchResults(new URL(cat.href));
      return;
    }
    const reset = e.target.closest('.kiel-shop-filter-reset');
    if (reset) {
      e.preventDefault();
      fetchResults(new URL(reset.href));
      return;
    }
    const pageLink = e.target.closest('#kiel-shop-results .kiel-pagination a');
    if (pageLink) {
      e.preventDefault();
      fetchResults(new URL(pageLink.href));
    }
  });

  window.addEventListener('popstate', (e) => {
    if (e.state?.shop) {
      fetchResults(new URL(window.location.href), false);
    }
  });
})();

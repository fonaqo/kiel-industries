(function () {
  const STORAGE_KEY = 'kiel_currency_v1';
  const rates = (() => {
    try {
      return JSON.parse(document.body?.dataset.currencyRates || '{}');
    } catch {
      return {};
    }
  })();

  let current = 'FCFA';

  function loadStored() {
    try {
      const saved = localStorage.getItem(STORAGE_KEY);
      if (saved && ['FCFA', 'EUR', 'USD'].includes(saved)) {
        current = saved;
      }
    } catch {
      /* ignore */
    }
  }

  function convertFromFcfa(amountFcfa, currency) {
    const n = Number(amountFcfa) || 0;
    if (currency === 'EUR') {
      return n / (Number(rates.fcfa_per_eur) || 655.957);
    }
    if (currency === 'USD') {
      return n / (Number(rates.fcfa_per_usd) || 610);
    }
    return n;
  }

  function readDirectPrice(el, currency) {
    if (currency === 'EUR') {
      const raw = el.getAttribute('data-price-eur');
      if (raw !== null && raw !== '') {
        const n = parseFloat(raw);
        if (Number.isFinite(n)) {
          return n;
        }
      }
    }
    if (currency === 'USD') {
      const raw = el.getAttribute('data-price-usd');
      if (raw !== null && raw !== '') {
        const n = parseFloat(raw);
        if (Number.isFinite(n)) {
          return n;
        }
      }
    }
    const fcfa = parseInt(el.getAttribute('data-price-fcfa') || '', 10);
    if (!Number.isFinite(fcfa)) {
      return null;
    }
    if (currency === 'FCFA') {
      return fcfa;
    }
    return convertFromFcfa(fcfa, currency);
  }

  function formatFcfa(amountFcfa) {
    return formatAmount(null, amountFcfa);
  }

  function formatAmount(el, amountFcfaFallback) {
    const value = el ? readDirectPrice(el, current) : convertFromFcfa(amountFcfaFallback, current);
    if (value === null || !Number.isFinite(value)) {
      return '';
    }
    if (current === 'EUR') {
      return `${value.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`;
    }
    if (current === 'USD') {
      return `$${value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }
    return `${Math.round(value).toLocaleString('fr-FR')} FCFA`;
  }

  function applyDom(root) {
    const scope = root || document;
    scope.querySelectorAll('[data-price-fcfa]').forEach((el) => {
      const text = formatAmount(el, null);
      if (text) {
        el.textContent = text;
      }
    });
  }

  function syncSwitchUi() {
    const root = document.getElementById('currency-switch');
    if (!root) return;
    root.querySelectorAll('.currency-btn').forEach((btn) => {
      const active = btn.getAttribute('data-currency') === current;
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
      btn.classList.toggle('bg-secondary', active);
      btn.classList.toggle('text-on-secondary', active);
    });
  }

  function setCurrency(code) {
    if (!['FCFA', 'EUR', 'USD'].includes(code)) {
      return;
    }
    current = code;
    try {
      localStorage.setItem(STORAGE_KEY, code);
    } catch {
      /* ignore */
    }
    syncSwitchUi();
    applyDom();
    document.dispatchEvent(new CustomEvent('kiel:currency-changed', { detail: { currency: code } }));
  }

  function initSwitch() {
    const root = document.getElementById('currency-switch');
    if (!root || root.dataset.kielCurrencyBound === '1') {
      return;
    }
    root.dataset.kielCurrencyBound = '1';
    root.querySelectorAll('.currency-btn').forEach((btn) => {
      btn.addEventListener('click', () => {
        const code = btn.getAttribute('data-currency');
        if (code) setCurrency(code);
      });
    });
    syncSwitchUi();
  }

  loadStored();

  window.KielCurrency = {
    formatFcfa,
    formatAmount,
    getCurrency: () => current,
    applyDom,
    setCurrency,
    initSwitch,
  };

  document.addEventListener('DOMContentLoaded', () => {
    initSwitch();
    applyDom();
  });
})();

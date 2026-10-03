(function () {
  const loader = document.getElementById('kiel-page-loader');
  if (!loader) return;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const mobile = window.matchMedia('(max-width: 767px)').matches;
  const minMs = reduced ? 150 : mobile ? 280 : 500;
  const start = performance.now();

  let finished = false;

  function finish() {
    if (finished) {
      return;
    }
    finished = true;
    const wait = Math.max(0, minMs - (performance.now() - start));
    setTimeout(() => {
      loader.classList.add('is-done');
      loader.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('kiel-drawer-open');
      if (!document.querySelector('.kiel-drawer.is-open')) {
        document.body.style.removeProperty('overflow');
      }
      document.documentElement.style.removeProperty('overflow');
    }, wait);
  }

  const ready = () => {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', finish, { once: true });
    } else {
      finish();
    }
  };

  ready();
  setTimeout(finish, 4500);
})();

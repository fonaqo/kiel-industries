(function () {
  const loader = document.getElementById('kiel-page-loader');
  if (!loader) return;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const minMs = reduced ? 350 : 1200;
  const start = performance.now();

  function finish() {
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

  if (document.readyState === 'complete') {
    finish();
  } else {
    window.addEventListener('load', finish, { once: true });
    setTimeout(finish, 5000);
  }
})();

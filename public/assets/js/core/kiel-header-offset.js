(function () {
  function syncHeaderOffset() {
    const header = document.querySelector('header.fixed');
    if (!header) {
      return;
    }
    const px = Math.ceil(header.getBoundingClientRect().height);
    document.documentElement.style.setProperty('--kiel-header-clearance', px + 'px');
  }

  function init() {
    syncHeaderOffset();
    window.addEventListener('resize', syncHeaderOffset, { passive: true });
    window.addEventListener('load', syncHeaderOffset, { once: true });
    window.addEventListener('orientationchange', () => {
      requestAnimationFrame(syncHeaderOffset);
    });
    if ('ResizeObserver' in window) {
      const header = document.querySelector('header.fixed');
      if (header) {
        new ResizeObserver(syncHeaderOffset).observe(header);
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  document.addEventListener('turbo:load', syncHeaderOffset);
})();

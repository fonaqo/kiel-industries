(function () {
  const page = document.body.dataset.page;
  if (page) {
    document.querySelectorAll('.kiel-page-nav a[data-page]').forEach((link) => {
      if (link.dataset.page === page) link.classList.add('is-active');
    });
  }

  const toggle = document.querySelector('.kiel-mobile-nav-toggle');
  const nav = document.getElementById('kiel-page-nav');
  toggle?.addEventListener('click', () => nav?.classList.toggle('kiel-page-nav--open'));

  const filterRoot = document.querySelector('.kiel-shop-filters');
  if (filterRoot) {
    const cards = document.querySelectorAll('.kiel-product-card[data-category]');
    filterRoot.addEventListener('click', (e) => {
      const btn = e.target.closest('button[data-filter]');
      if (!btn) return;
      filterRoot.querySelectorAll('button').forEach((b) => b.classList.remove('is-active'));
      btn.classList.add('is-active');
      const filter = btn.dataset.filter;
      cards.forEach((card) => {
        const show = filter === 'all' || card.dataset.category === filter;
        card.style.display = show ? '' : 'none';
      });
    });
  }

  document.querySelectorAll('.kiel-form[data-mailto]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const fd = new FormData(form);
      const subject = encodeURIComponent(form.dataset.subject || 'Message KIEL INDUSTRIES');
      const body = encodeURIComponent(
        [...fd.entries()].map(([k, v]) => `${k}: ${v}`).join('\n')
      );
      window.location.href = `mailto:kielbienetre@gmail.com?subject=${subject}&body=${body}`;
    });
  });
})();

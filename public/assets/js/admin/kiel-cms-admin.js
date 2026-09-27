(function () {
  const root = document.body;
  if (!root.classList.contains('kiel-cms-admin')) return;

  const toggle = document.getElementById('kiel-cms-nav-toggle');
  const backdrop = document.getElementById('kiel-cms-sidebar-backdrop');
  const sidebar = document.querySelector('.kiel-cms-sidebar');

  function setNavOpen(open) {
    root.classList.toggle('kiel-cms-admin--nav-open', open);
    if (toggle) toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  toggle?.addEventListener('click', () => setNavOpen(!root.classList.contains('kiel-cms-admin--nav-open')));
  backdrop?.addEventListener('click', () => setNavOpen(false));
  sidebar?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      if (window.matchMedia('(max-width: 1023px)').matches) setNavOpen(false);
    });
  });

  const userMenu = document.getElementById('kiel-cms-user-menu');
  const userToggle = document.getElementById('kiel-cms-user-toggle');
  const userDropdown = document.getElementById('kiel-cms-user-dropdown');

  function setUserOpen(open) {
    if (!userMenu || !userToggle || !userDropdown) return;
    userMenu.classList.toggle('is-open', open);
    userToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    userDropdown.hidden = !open;
  }

  userToggle?.addEventListener('click', (e) => {
    e.stopPropagation();
    setUserOpen(!userMenu.classList.contains('is-open'));
  });

  document.addEventListener('click', (e) => {
    if (userMenu && !userMenu.contains(e.target)) setUserOpen(false);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      setNavOpen(false);
      setUserOpen(false);
    }
  });

  document.querySelectorAll('form[data-cms-auto-filter]').forEach((form) => {
    let debounceTimer;
    const submit = () => {
      if (typeof form.requestSubmit === 'function') {
        form.requestSubmit();
      } else {
        form.submit();
      }
    };

    form.querySelectorAll('select').forEach((el) => {
      el.addEventListener('change', submit);
    });

    const search = form.querySelector('input[type="search"]');
    if (search) {
      search.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(submit, 350);
      });
      search.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          clearTimeout(debounceTimer);
          submit();
        }
      });
    }
  });
})();

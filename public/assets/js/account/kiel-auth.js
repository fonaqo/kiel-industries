(function () {
  function initPasswordToggles() {
    document.querySelectorAll('[data-kiel-password-toggle]').forEach(function (btn) {
      if (btn.dataset.kielBound) {
        return;
      }
      btn.dataset.kielBound = '1';
      btn.addEventListener('click', function () {
        var wrap = btn.closest('.kiel-auth-password');
        var input = wrap && wrap.querySelector('input');
        var icon = btn.querySelector('.material-symbols-outlined');
        if (!input || !icon) {
          return;
        }
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.textContent = show ? 'visibility_off' : 'visibility';
        btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPasswordToggles);
  } else {
    initPasswordToggles();
  }
})();

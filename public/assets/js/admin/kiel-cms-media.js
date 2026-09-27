(function () {
  function setPreview(root, url) {
    const preview = root.querySelector('[data-kiel-cms-media-preview]');
    const wrap = root.querySelector('[data-kiel-cms-media-preview-wrap]');
    const placeholder = wrap?.querySelector('.kiel-cms-media-field__thumb-placeholder');
    if (!preview || !wrap) {
      return;
    }
    if (url) {
      preview.src = url.startsWith('http') ? url : '/' + url.replace(/^\//, '');
      preview.hidden = false;
      wrap.classList.remove('is-empty');
      if (placeholder) {
        placeholder.hidden = true;
      }
    } else {
      preview.hidden = true;
      preview.removeAttribute('src');
      wrap.classList.add('is-empty');
      if (placeholder) {
        placeholder.hidden = false;
      }
    }
  }

  function activateTab(root, tab) {
    root.querySelectorAll('[data-kiel-media-tab]').forEach((btn) => {
      const active = btn.getAttribute('data-kiel-media-tab') === tab;
      btn.classList.toggle('is-active', active);
      btn.setAttribute('aria-selected', active ? 'true' : 'false');
    });
    root.querySelectorAll('[data-kiel-media-panel]').forEach((panel) => {
      panel.hidden = panel.getAttribute('data-kiel-media-panel') !== tab;
    });
  }

  function bindMediaField(root) {
    const urlInput = root.querySelector('[data-kiel-cms-media-url]');
    const fileInput = root.querySelector('[data-kiel-cms-media-file]');
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const uploadUrl = root.getAttribute('data-upload-url');
    const initial = root.getAttribute('data-initial-tab') || 'link';

    activateTab(root, initial);

    root.querySelectorAll('[data-kiel-media-tab]').forEach((btn) => {
      btn.addEventListener('click', () => {
        activateTab(root, btn.getAttribute('data-kiel-media-tab'));
      });
    });

    if (urlInput) {
      urlInput.addEventListener('input', () => {
        setPreview(root, urlInput.value.trim());
      });
      if (urlInput.value.trim()) {
        setPreview(root, urlInput.value.trim());
      }
    }

    if (fileInput) {
      fileInput.addEventListener('change', async () => {
        const file = fileInput.files?.[0];
        if (!file) {
          return;
        }
        if (uploadUrl && token) {
          const body = new FormData();
          body.append('file', file);
          try {
            const res = await fetch(uploadUrl, {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': token, Accept: 'application/json' },
              body,
              credentials: 'same-origin',
            });
            if (res.ok) {
              const data = await res.json();
              if (data.path && urlInput) {
                urlInput.value = data.path;
                setPreview(root, data.path);
                activateTab(root, 'link');
                return;
              }
            }
          } catch {
            /* fall through to local preview */
          }
        }
        const objectUrl = URL.createObjectURL(file);
        setPreview(root, objectUrl);
        activateTab(root, 'upload');
      });
    }
  }

  function bindGalleryField(root) {
    root.querySelectorAll('[data-kiel-gallery-tab]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const tab = btn.getAttribute('data-kiel-gallery-tab');
        root.querySelectorAll('[data-kiel-gallery-tab]').forEach((b) => {
          b.classList.toggle('is-active', b === btn);
        });
        root.querySelectorAll('[data-kiel-gallery-panel]').forEach((panel) => {
          panel.hidden = panel.getAttribute('data-kiel-gallery-panel') !== tab;
        });
      });
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-kiel-cms-media]').forEach(bindMediaField);
    document.querySelectorAll('[data-kiel-cms-gallery]').forEach(bindGalleryField);
  });
})();

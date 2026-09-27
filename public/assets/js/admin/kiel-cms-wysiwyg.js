(function () {
  function initWysiwyg() {
    if (typeof tinymce === 'undefined') {
      return;
    }

    document.querySelectorAll('textarea[data-wysiwyg]').forEach((el) => {
      if (el.dataset.wysiwygInit === '1') {
        return;
      }

      el.dataset.wysiwygInit = '1';
      const mode = el.getAttribute('data-wysiwyg') || 'full';
      const isBasic = mode === 'basic';
      const defaultHeight = isBasic ? 220 : 360;
      const height = parseInt(el.getAttribute('data-wysiwyg-height') || String(defaultHeight), 10);

      tinymce.init({
        target: el,
        license_key: 'gpl',
        height,
        menubar: false,
        plugins: isBasic ? 'lists link autolink' : 'lists link autolink code',
        toolbar: isBasic
          ? 'undo redo | bold italic | bullist numlist | link'
          : 'undo redo | blocks | bold italic | bullist numlist | link | removeformat | code',
        block_formats: 'Paragraphe=p; Titre 2=h2; Titre 3=h3',
        content_style:
          'body{font-family:"Plus Jakarta Sans",system-ui,sans-serif;font-size:14px;line-height:1.55;color:#2c000a}',
        branding: false,
        promotion: false,
      });
    });

    document.querySelectorAll('form.kiel-cms-form, form.kiel-cms-editor').forEach((form) => {
      if (form.dataset.wysiwygSubmitBound === '1') {
        return;
      }
      form.dataset.wysiwygSubmitBound = '1';
      form.addEventListener('submit', () => {
        if (typeof tinymce !== 'undefined') {
          tinymce.triggerSave();
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWysiwyg);
  } else {
    initWysiwyg();
  }
})();

(function () {
  async function refreshPage() {
    if (window.KielWishlist?.load) {
      await window.KielWishlist.load();
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    refreshPage();
  });

  document.addEventListener('turbo:load', () => {
    refreshPage();
  });
})();

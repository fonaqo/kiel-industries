(function () {
  function deferHeroVideoOnMobile() {
    const video = document.getElementById('hero-video');
    if (!video) {
      return;
    }
    if (!window.matchMedia('(max-width: 767px)').matches) {
      video.autoplay = true;
      video.preload = 'metadata';
      video.play().catch(() => null);
      return;
    }
    video.preload = 'none';
    video.autoplay = false;
    video.pause();

    const start = () => {
      if (video.dataset.kielHeroStarted === '1') {
        return;
      }
      video.dataset.kielHeroStarted = '1';
      const source = video.querySelector('source');
      if (source && !source.src) {
        source.src = source.getAttribute('src') || '';
      }
      video.load();
      video.play().catch(() => null);
    };

    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              start();
              observer.disconnect();
            }
          });
        },
        { rootMargin: '0px', threshold: 0.15 }
      );
      observer.observe(video);
    } else {
      start();
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', deferHeroVideoOnMobile);
  } else {
    deferHeroVideoOnMobile();
  }
})();

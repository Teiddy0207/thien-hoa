document.addEventListener('DOMContentLoaded', function () {
  var sections = document.querySelectorAll('.reveal-on-scroll:not(.is-visible)');
  var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var STAGGER_SELECTORS = '.info-group, .advantage-card, .gallery-item, .post-item, .rv-info-item';

  function setupStagger(section) {
    var items = section.querySelectorAll(STAGGER_SELECTORS);
    if (!items.length) return;
    items.forEach(function (item, index) {
      item.classList.add('reveal-child');
      item.style.setProperty('--reveal-delay', (index * 70) + 'ms');
    });
  }

  sections.forEach(setupStagger);

  if (!sections.length) {
    return;
  }

  if (prefersReducedMotion || !('IntersectionObserver' in window)) {
    sections.forEach(function (el) {
      el.classList.add('is-visible');
    });
    return;
  }

  var observer = new IntersectionObserver(function (entries, obs) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        obs.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.14
  });

  sections.forEach(function (el) {
    observer.observe(el);
  });

  var hero = document.querySelector('.hero-section');
  var heroTitle = hero ? hero.querySelector('.hero-title-image') : null;
  var heroVisual = hero ? hero.querySelector('.hero-image img') : null;
  var heroLine = hero ? hero.querySelector('.hero-bottom-image img') : null;

  if (!hero || !heroTitle || !heroVisual || prefersReducedMotion) {
    return;
  }

  var currentX = 0;
  var currentY = 0;
  var targetX = 0;
  var targetY = 0;
  var ticking = false;

  function updateParallax() {
    currentX += (targetX - currentX) * 0.1;
    currentY += (targetY - currentY) * 0.1;

    heroTitle.style.transform = 'translate3d(' + (currentX * 0.35) + 'px,' + (currentY * 0.25) + 'px,0)';
    heroVisual.style.transform = 'translate3d(' + (currentX * -0.2) + 'px,' + (currentY * -0.15) + 'px,0) scale(1.02)';
    if (heroLine) {
      heroLine.style.transform = 'translate3d(' + (currentX * -0.1) + 'px,' + (currentY * 0.1) + 'px,0)';
    }

    ticking = false;
  }

  function requestParallaxTick() {
    if (ticking) return;
    ticking = true;
    window.requestAnimationFrame(updateParallax);
  }

  hero.addEventListener('mousemove', function (event) {
    var rect = hero.getBoundingClientRect();
    var relX = (event.clientX - rect.left) / rect.width - 0.5;
    var relY = (event.clientY - rect.top) / rect.height - 0.5;
    targetX = relX * 26;
    targetY = relY * 20;
    requestParallaxTick();
  });

  hero.addEventListener('mouseleave', function () {
    targetX = 0;
    targetY = 0;
    requestParallaxTick();
  });

  window.addEventListener('scroll', function () {
    var rect = hero.getBoundingClientRect();
    var progress = Math.max(-1, Math.min(1, rect.top / Math.max(1, rect.height)));
    targetY = (targetY * 0.8) + progress * -12;
    requestParallaxTick();
  }, { passive: true });
});

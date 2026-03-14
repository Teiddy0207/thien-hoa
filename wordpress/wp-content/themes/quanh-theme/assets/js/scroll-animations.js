document.addEventListener('DOMContentLoaded', function () {
  var elements = document.querySelectorAll('.reveal-on-scroll');

  if (!elements.length) {
    return;
  }

  // Fallback nếu trình duyệt không hỗ trợ IntersectionObserver
  if (!('IntersectionObserver' in window)) {
    elements.forEach(function (el) {
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
    threshold: 0.2
  });

  elements.forEach(function (el) {
    observer.observe(el);
  });
});


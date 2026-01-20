(function() {
  var btn = document.getElementById('news-load-more-btn');
  if (!btn) return;

  var container = document.getElementById('news-load-more-container');
  var endEl = document.getElementById('news-load-more-end');
  if (!container) return;

  var defaultLabel = (btn.getAttribute('data-label') || 'Xem thêm tin tức').trim();
  var loadingLabel = (btn.getAttribute('data-loading') || 'Đang tải...').trim();

  btn.addEventListener('click', function() {
    var max = parseInt(btn.getAttribute('data-max'), 10) || 1;
    var current = parseInt(btn.getAttribute('data-current'), 10) || 1;
    if (current >= max) return;

    var form = new URLSearchParams({
      action: 'news_load_more',
      nonce: (typeof newsLoadMore !== 'undefined' && newsLoadMore.nonce) ? newsLoadMore.nonce : '',
      paged: String(current + 1)
    });

    btn.disabled = true;
    btn.classList.add('is-loading');
    btn.textContent = loadingLabel;

    fetch(typeof ajaxurl !== 'undefined' ? ajaxurl : (newsLoadMore && newsLoadMore.ajaxurl) || '/wp-admin/admin-ajax.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: form.toString()
    })
      .then(function(r) { return r.json(); })
      .then(function(res) {
        if (res.success && res.data && res.data.html) {
          container.insertAdjacentHTML('beforeend', res.data.html);
          btn.setAttribute('data-current', String(current + 1));
          if (!res.data.has_more) {
            btn.style.display = 'none';
            if (endEl) endEl.style.display = 'block';
          }
        }
        btn.disabled = false;
        btn.classList.remove('is-loading');
        btn.textContent = defaultLabel;
      })
      .catch(function() {
        btn.disabled = false;
        btn.classList.remove('is-loading');
        btn.textContent = defaultLabel;
      });
  });
})();

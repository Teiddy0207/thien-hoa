(function() {
  function run() {
    var nav = document.querySelector('.news-section .news-pagination') || document.getElementById('news-pagination-nav');
    var postList = document.querySelector('.news-section .post-list') || document.getElementById('news-post-list');
    if (!nav || !postList) return;

    var ajaxurl = (typeof newsPagination !== 'undefined' && newsPagination && newsPagination.ajaxurl) ? newsPagination.ajaxurl : (typeof ajaxurl !== 'undefined' ? ajaxurl : (typeof newsLoadMore !== 'undefined' && newsLoadMore && newsLoadMore.ajaxurl) ? newsLoadMore.ajaxurl : '/wp-admin/admin-ajax.php');
    var nonce = (typeof newsPagination !== 'undefined' && newsPagination && newsPagination.nonce) ? newsPagination.nonce : (typeof newsLoadMore !== 'undefined' && newsLoadMore && newsLoadMore.nonce) ? newsLoadMore.nonce : '';

    function getPagedFromUrl(url) {
      if (!url) return 1;
      try {
        var u = new URL(url, window.location.origin);
        var p = u.searchParams.get('paged');
        if (p) return Math.max(1, parseInt(p, 10));
        var m = (u.pathname || '').match(/\/page\/(\d+)\/?/);
        if (m) return Math.max(1, parseInt(m[1], 10));
      } catch (e) {}
      return 1;
    }

    function getCurrentPaged() {
      return getPagedFromUrl(window.location.href);
    }

    function loadPage(paged, pushState) {
      if (paged < 1) return;
      postList.classList.add('is-loading');
      var form = new URLSearchParams({
        action: 'news_pagination',
        nonce: nonce,
        paged: String(paged)
      });
      fetch(ajaxurl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: form.toString()
      })
        .then(function(r) { return r.json(); })
        .then(function(res) {
          postList.classList.remove('is-loading');
          if (!res.success || !res.data) return;
          var d = res.data;
          if (d.posts_html !== undefined) {
            postList.innerHTML = d.posts_html;
          }
          if (d.pagination_html !== undefined && d.pagination_html) {
            nav.innerHTML = d.pagination_html;
          }
          if (pushState !== false && window.history && window.history.pushState) {
            var base = (typeof newsPagination !== 'undefined' && newsPagination && newsPagination.baseUrl) ? newsPagination.baseUrl : (window.location.pathname + window.location.search).replace(/\?paged=\d+|\/page\/\d+\/?/g, '').replace(/\?$/, '');
            var sep = base.indexOf('?') !== -1 ? '&' : '?';
            var newUrl = paged === 1 ? base.replace(/\?paged=\d+&?|&paged=\d+/g, '').replace(/\?$/, '') : base + sep + 'paged=' + paged;
            window.history.pushState({ paged: paged }, '', newUrl);
          }
          nav.dispatchEvent(new CustomEvent('news-pagination-updated', { detail: { paged: paged } }));
        })
        .catch(function() {
          postList.classList.remove('is-loading');
        });
    }

    nav.addEventListener('click', function(e) {
      var link = e.target.closest('a.page-numbers');
      if (!link || !link.href) return;
      e.preventDefault();
      e.stopPropagation();
      if (link.classList.contains('current')) return;
      var paged = getPagedFromUrl(link.href);
      var current = getCurrentPaged();
      if (paged === current) return;
      loadPage(paged, true);
    }, true);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run);
  } else {
    run();
  }

  window.addEventListener('popstate', function(e) {
    var postList = document.querySelector('.news-section .post-list') || document.getElementById('news-post-list');
    var nav = document.querySelector('.news-section .news-pagination') || document.getElementById('news-pagination-nav');
    if (!nav || !postList) return;
    var paged = e.state && e.state.paged != null ? e.state.paged : (function() {
      try {
        var u = new URL(window.location.href);
        var p = u.searchParams.get('paged');
        if (p) return Math.max(1, parseInt(p, 10));
        var m = (u.pathname || '').match(/\/page\/(\d+)\/?/);
        if (m) return Math.max(1, parseInt(m[1], 10));
      } catch (e) {}
      return 1;
    })();
    var nonce = (typeof newsLoadMore !== 'undefined' && newsLoadMore && newsLoadMore.nonce) ? newsLoadMore.nonce : '';
    var ajaxurl = typeof ajaxurl !== 'undefined' ? ajaxurl : (typeof newsLoadMore !== 'undefined' && newsLoadMore && newsLoadMore.ajaxurl) ? newsLoadMore.ajaxurl : '/wp-admin/admin-ajax.php';
    postList.classList.add('is-loading');
    var form = new URLSearchParams({ action: 'news_pagination', nonce: nonce, paged: String(paged) });
    fetch(ajaxurl, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: form.toString() })
      .then(function(r) { return r.json(); })
      .then(function(res) {
        postList.classList.remove('is-loading');
        if (!res.success || !res.data) return;
        var d = res.data;
        if (d.posts_html !== undefined) postList.innerHTML = d.posts_html;
        if (d.pagination_html !== undefined && d.pagination_html) nav.innerHTML = d.pagination_html;
      })
      .catch(function() { postList.classList.remove('is-loading'); });
  });
})();

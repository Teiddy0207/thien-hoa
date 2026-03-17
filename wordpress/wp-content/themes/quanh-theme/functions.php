<?php

if ( ! defined( 'QUANH_THEME_VERSION' ) ) {
  define( 'QUANH_THEME_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/library-admin.php';

add_theme_support('menus');
add_theme_support('title-tag');

register_nav_menus([
  'header' => 'Header Menu'
]);

function quanh_body_class_template_pages( $classes ) {
  $slug_to_template_class = [
    'lien-he'   => 'page-template-page-lien-he-php',
    'tong-quan' => 'page-template-page-tong-quan-php',
    'vi-tri'    => 'page-template-page-vi-tri-php',
    'mat-bang'  => 'page-template-page-mat-bang-php',
    'uu-the'    => 'page-template-page-uu-the-php',
    'thu-vien'  => 'page-template-page-thu-vien-php',
    'tin-tuc'   => 'page-template-page-tin-tuc-php',
  ];
  foreach ( $slug_to_template_class as $slug => $template_class ) {
    if ( is_page( $slug ) && ! in_array( $template_class, $classes, true ) ) {
      $classes[] = $template_class;
      break;
    }
  }
  return $classes;
}
add_filter( 'body_class', 'quanh_body_class_template_pages', 20 );

/**
 * Menu header chỉ hiển thị Trang chủ + Tin tức (dù đã tạo menu đầy đủ trong WP).
 * Các mục Tổng quan, Vị trí, Mặt bằng, Ưu thế, Thư viện, Liên hệ đã gom vào landing.
 */
function quanh_filter_header_menu_to_two_items( $items, $args ) {
  if ( empty( $args->theme_location ) || $args->theme_location !== 'header' ) {
    return $items;
  }
  $home_url      = trailingslashit( home_url() );
  $news_url      = trailingslashit( home_url( '/tin-tuc/' ) );
  $news_page     = get_page_by_path( 'tin-tuc' );
  $news_permalink = $news_page ? trailingslashit( get_permalink( $news_page ) ) : $news_url;
  $home_item = null;
  $news_item = null;
  foreach ( $items as $item ) {
    $url = trailingslashit( $item->url );
    if ( $home_item === null && ( $url === $home_url || $item->url === home_url() ) ) {
      $home_item = $item;
    }
    if ( $news_item === null && ( $url === $news_url || $url === $news_permalink || strpos( $item->url, '/tin-tuc' ) !== false ) ) {
      $news_item = $item;
    }
    if ( $home_item && $news_item ) {
      break;
    }
  }
  $keep = array_filter( array( $home_item, $news_item ) );
  if ( count( $keep ) === 0 ) {
    return $items;
  }
  return array_values( $keep );
}
add_filter( 'wp_nav_menu_objects', 'quanh_filter_header_menu_to_two_items', 10, 2 );

// Fallback menu: chỉ Trang chủ và Tin tức (các mục khác gom vào landing)
function quanh_fallback_menu() {
  $items = [
    ['title' => 'Trang chủ', 'url' => home_url('/')],
    ['title' => 'Tin tức', 'url' => home_url('/tin-tuc')],
  ];

  echo '<ul class="menu">';
  foreach ($items as $item) {
    $current = '';
    if (is_front_page() && $item['title'] === 'Trang chủ') {
      $current = ' current-menu-item';
    } elseif (is_page('tin-tuc') && $item['title'] === 'Tin tức') {
      $current = ' current-menu-item';
    }
    echo '<li class="menu-item' . $current . '">';
    echo '<a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a>';
    echo '</li>';
  }
  echo '</ul>';
}


function quanh_fix_home_menu_current_class( $classes, $item ) {
  if ( ! is_front_page() ) {
    $front_page_id = (int) get_option( 'page_on_front' );
    
    $is_front_page_item = false;
    
    if ( $item->type === 'post_type' && (int) $item->object_id === $front_page_id && $front_page_id > 0 ) {
      $is_front_page_item = true;
    }
    
    if ( $item->type === 'custom' ) {
      $home_url = trailingslashit( home_url() );
      $item_url = trailingslashit( $item->url );
      if ( $item_url === $home_url || $item->url === home_url() ) {
        $is_front_page_item = true;
      }
    }
    
    if ( $is_front_page_item ) {
      $classes = array_diff( $classes, array(
        'current-menu-item',
        'current_page_item',
        'current-menu-ancestor',
        'current-menu-parent',
        'current_page_parent',
        'current_page_ancestor'
      ) );
    }
  }
  
  return $classes;
}
add_filter( 'nav_menu_css_class', 'quanh_fix_home_menu_current_class', 10, 2 );

function quanh_enqueue_styles() {
  $style_file = function_exists( 'get_theme_file_path' ) ? get_theme_file_path( 'style.css' ) : ( get_stylesheet_directory() . '/style.css' );
  $mtime      = ( $style_file && file_exists( $style_file ) ) ? filemtime( $style_file ) : false;
  $version    = $mtime ? (string) $mtime : ( defined( 'QUANH_THEME_VERSION' ) ? QUANH_THEME_VERSION : '1.0' );
  wp_enqueue_style(
    'quanh-style',
    get_stylesheet_uri(),
    [],
    $version
  );
}
add_action('wp_enqueue_scripts', 'quanh_enqueue_styles');

function quanh_enqueue_scripts() {
  $js_dir = get_template_directory() . '/assets/js/';
  $ver_js = function( $file ) use ( $js_dir ) {
    $path = $js_dir . $file;
    return file_exists( $path ) ? (string) filemtime( $path ) : '1.0';
  };

  /* Hamburger menu: load trong head để vẫn chạy khi trang không gọi get_footer() */
  wp_enqueue_script(
    'quanh-hamburger-menu',
    get_template_directory_uri() . '/assets/js/hamburger-menu.js',
    array(),
    $ver_js( 'hamburger-menu.js' ),
    false
  );

  wp_enqueue_script(
    'news-load-more',
    get_template_directory_uri() . '/assets/js/news-load-more.js',
    array(),
    $ver_js( 'news-load-more.js' ),
    true
  );
  wp_localize_script('news-load-more', 'newsLoadMore', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('news_load_more'),
  ));

  wp_enqueue_script(
    'news-pagination-ajax',
    get_template_directory_uri() . '/assets/js/news-pagination-ajax.js',
    array(),
    $ver_js( 'news-pagination-ajax.js' ),
    true
  );
  $news_page_url = home_url('/');
  $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'page-tin-tuc.php'));
  if (!empty($pages)) {
    $news_page_url = get_permalink($pages[0]->ID);
  }
  wp_localize_script('news-pagination-ajax', 'newsPagination', array(
    'baseUrl'  => preg_replace('#\?paged=\d+#', '', preg_replace('#/page/\d+/?#', '/', $news_page_url)),
    'ajaxurl'  => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('news_load_more'),
  ));

  /* Hiệu ứng cuộn landing: reveal khi section vào viewport */
  if (is_front_page()) {
    wp_enqueue_script(
      'quanh-scroll-animations',
      get_template_directory_uri() . '/assets/js/scroll-animations.js',
      array(),
      $ver_js( 'scroll-animations.js' ),
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'quanh_enqueue_scripts');

/**
 * AJAX: Load thêm tin tức (chỉ cột phải – 3 bài/trang, bỏ qua bài featured)
 */
function quanh_ajax_news_load_more() {
  check_ajax_referer('news_load_more', 'nonce');
  $paged = max(1, (int) (isset($_POST['paged']) ? $_POST['paged'] : 0));
  $per_page = 3;
  $offset   = 1 + ($paged - 1) * $per_page;

  $count = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'fields'         => 'ids',
  ));
  $total = (int) $count->found_posts;
  wp_reset_postdata();
  $right_max_pages = $total > 1 ? (int) ceil(($total - 1) / $per_page) : 0;

  $q = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => $per_page,
    'offset'         => $offset,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ));

  ob_start();
  if ($q->have_posts()) {
    echo '<div class="news-load-more-batch"><div class="news-load-more-grid">';
    while ($q->have_posts()) {
      $q->the_post();
      $thumb = '';
      if (has_post_thumbnail()) {
        $url = wp_get_attachment_image_url(get_post_thumbnail_id(), 'medium');
        if ($url) {
          $thumb = '<img src="' . esc_url($url) . '" alt="' . esc_attr(get_the_title()) . '">';
        }
      }
      if (!$thumb) {
        $content = get_the_content();
        if (preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $m)) {
          $thumb = '<img src="' . esc_url($m[1]) . '" alt="' . esc_attr(get_the_title()) . '">';
        } else {
          $thumb = '<div style="background:linear-gradient(135deg,#003d5c,#001f3f);width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);font-size:12px;">Không có ảnh</div>';
        }
      }
      echo '<a href="' . esc_url(get_permalink()) . '" class="post-item">';
      echo '<div class="post-thumbnail">' . $thumb . '</div>';
      echo '<div class="post-info">';
      echo '<div class="post-date">' . esc_html(get_the_date('d/m/Y')) . '</div>';
      echo '<h3>' . get_the_title() . '</h3>';
      echo '<span class="read-more"><span>Đọc thêm</span><span>→</span></span>';
      echo '</div></a>';
    }
    echo '</div></div>';
  }
  wp_reset_postdata();
  $html = ob_get_clean();

  wp_send_json_success(array('html' => $html, 'has_more' => $paged < $right_max_pages));
}
add_action('wp_ajax_news_load_more', 'quanh_ajax_news_load_more');
add_action('wp_ajax_nopriv_news_load_more', 'quanh_ajax_news_load_more');

/**
 * AJAX: Phân trang tin tức (chỉ cột phải, không reload trang)
 */
function quanh_ajax_news_pagination() {
  check_ajax_referer('news_load_more', 'nonce');
  $paged = max(1, (int) (isset($_POST['paged']) ? $_POST['paged'] : 0));
  $per_page = 3;
  $offset   = 1 + ($paged - 1) * $per_page;

  $count = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => -1,
    'fields'         => 'ids',
  ));
  $total = (int) $count->found_posts;
  wp_reset_postdata();
  $right_max_pages = $total > 1 ? (int) ceil(($total - 1) / $per_page) : 0;

  $q = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => $per_page,
    'offset'         => $offset,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ));

  ob_start();
  if ($q->have_posts()) {
    while ($q->have_posts()) {
      $q->the_post();
      $thumb = '';
      if (has_post_thumbnail()) {
        $url = wp_get_attachment_image_url(get_post_thumbnail_id(), 'medium');
        if ($url) $thumb = '<img src="' . esc_url($url) . '" alt="' . esc_attr(get_the_title()) . '">';
      }
      if (!$thumb) {
        $content = get_the_content();
        if (preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $m)) {
          $thumb = '<img src="' . esc_url($m[1]) . '" alt="' . esc_attr(get_the_title()) . '">';
        } else {
          $thumb = '<div style="background:linear-gradient(135deg,#003d5c,#001f3f);width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);font-size:12px;">Không có ảnh</div>';
        }
      }
      echo '<a href="' . esc_url(get_permalink()) . '" class="post-item">';
      echo '<div class="post-thumbnail">' . $thumb . '</div>';
      echo '<div class="post-info">';
      echo '<div class="post-date">' . esc_html(get_the_date('d/m/Y')) . '</div>';
      echo '<h3>' . get_the_title() . '</h3>';
      echo '<span class="read-more"><span>Đọc thêm</span><span>→</span></span>';
      echo '</div></a>';
    }
  }
  wp_reset_postdata();
  $posts_html = ob_get_clean();

  $news_page_url = home_url('/');
  $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'page-tin-tuc.php'));
  if (!empty($pages)) {
    $news_page_url = get_permalink($pages[0]->ID);
  }
  $base = $news_page_url . (strpos($news_page_url, '?') !== false ? '&' : '?') . 'paged=%#%';
  $pagination_html = '';
  if ($right_max_pages > 1) {
    $pagination_html = paginate_links(array(
      'base'      => $base,
      'format'    => '',
      'current'   => $paged,
      'total'     => $right_max_pages,
      'prev_text' => '← Trước',
      'next_text' => 'Sau →',
      'type'      => 'plain',
      'end_size'  => 1,
      'mid_size'  => 2,
    ));
  }

  wp_send_json_success(array(
    'posts_html'      => $posts_html,
    'pagination_html' => $pagination_html,
    'paged'           => $paged,
    'max_pages'       => $right_max_pages,
  ));
}
add_action('wp_ajax_news_pagination', 'quanh_ajax_news_pagination');
add_action('wp_ajax_nopriv_news_pagination', 'quanh_ajax_news_pagination');

/**
 * WP Admin (block editor): khi insert Image block, nếu chưa có caption thì dùng ALT làm caption.
 * Mục tiêu: ngay dưới block ảnh hiển thị mô tả (alt) thay vì rỗng/khác.
 */
function quanh_admin_attachment_caption_fallback_to_alt( $response, $attachment, $meta ) {
  if ( ! is_admin() ) {
    return $response;
  }

  $alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
  $alt = is_string( $alt ) ? trim( $alt ) : '';
  if ( $alt === '' ) {
    return $response;
  }

  $caption_raw = '';
  if ( isset( $response['caption'] ) && is_string( $response['caption'] ) ) {
    $caption_raw = trim( wp_strip_all_tags( $response['caption'] ) );
  }

  if ( $caption_raw !== '' ) {
    return $response;
  }

  // Gutenberg dùng caption/captionRaw từ response để fill caption attribute.
  $response['caption'] = $alt;
  $response['captionRaw'] = $alt;
  return $response;
}
add_filter( 'wp_prepare_attachment_for_js', 'quanh_admin_attachment_caption_fallback_to_alt', 20, 3 );

/**
 * WP Admin (block editor): style caption dưới ảnh để phân biệt với nội dung (italic).
 */
function quanh_editor_caption_styles() {
  $css = "
    .editor-styles-wrapper figure figcaption,
    .editor-styles-wrapper .wp-element-caption,
    .editor-styles-wrapper .wp-caption-text {
      font-style: italic;
      opacity: 0.78;
    }
  ";
  wp_register_style( 'quanh-editor-tweaks', false, array(), QUANH_THEME_VERSION );
  wp_enqueue_style( 'quanh-editor-tweaks' );
  wp_add_inline_style( 'quanh-editor-tweaks', $css );
}
add_action( 'enqueue_block_editor_assets', 'quanh_editor_caption_styles' );

/**
 * Single post: nếu ảnh không có caption thì hiển thị alt như mô tả ảnh.
 */
function quanh_single_add_alt_as_caption( $content ) {
  if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
    return $content;
  }

  if ( stripos( $content, '<img' ) === false ) {
    return $content;
  }

  $html = '<div>' . $content . '</div>';

  libxml_use_internal_errors( true );
  $dom = new DOMDocument();
  $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED );
  libxml_clear_errors();

  $xpath = new DOMXPath( $dom );

  // 1) Gutenberg: figure.wp-block-image có/không có figcaption
  $figures = $xpath->query( '//figure[contains(concat(" ", normalize-space(@class), " "), " wp-block-image ")]' );
  foreach ( $figures as $figure ) {
    $img = $xpath->query( './/img[1]', $figure )->item( 0 );
    if ( ! $img ) continue;

    $alt = trim( (string) $img->getAttribute( 'alt' ) );
    if ( $alt === '' ) continue;

    $figcaption = $xpath->query( './figcaption', $figure )->item( 0 );
    if ( $figcaption ) {
      if ( trim( $figcaption->textContent ) !== '' ) continue;
      while ( $figcaption->firstChild ) {
        $figcaption->removeChild( $figcaption->firstChild );
      }
      $figcaption->appendChild( $dom->createTextNode( $alt ) );
      $figcaption->setAttribute( 'class', trim( $figcaption->getAttribute( 'class' ) . ' q-image-alt-caption' ) );
      continue;
    }

    $newCap = $dom->createElement( 'figcaption' );
    $newCap->setAttribute( 'class', 'q-image-alt-caption' );
    $newCap->appendChild( $dom->createTextNode( $alt ) );
    $figure->appendChild( $newCap );
  }

  // 1b) Nếu người soạn nhập "mô tả ảnh" như 1 đoạn <p> ngay sau figure (thay vì caption),
  // thì chuyển nó thành figcaption để frontend hiển thị đúng kiểu mô tả (italic).
  // Nếu caption đã có (do caption thật hoặc do fallback từ ALT), thì chỉ xoá <p> khi nội dung bị trùng.
  foreach ( $figures as $figure ) {
    // Nếu đã có figcaption và có nội dung thì bỏ qua
    $existing = $xpath->query( './figcaption', $figure )->item( 0 );
    $existing_text = $existing ? trim( $existing->textContent ) : '';

    $next = $figure->nextSibling;
    while ( $next && $next->nodeType === XML_TEXT_NODE && trim( $next->textContent ) === '' ) {
      $next = $next->nextSibling;
    }
    if ( ! $next || $next->nodeType !== XML_ELEMENT_NODE || strtolower( $next->nodeName ) !== 'p' ) {
      continue;
    }

    // Heuristic: chỉ nhận "mô tả" ngắn, không chứa markup phức tạp
    $raw = $dom->saveHTML( $next );
    if ( preg_match( '/<(a|strong|b|em|i|u|span|br|img|figure|ul|ol|li|h\\d)\\b/i', $raw ) ) {
      continue;
    }
    $text = trim( $next->textContent );
    if ( $text === '' || mb_strlen( $text ) > 180 ) {
      continue;
    }

    // Nếu caption đã có, chỉ xoá <p> khi trùng caption hoặc trùng ALT.
    if ( $existing_text !== '' ) {
      $img = $xpath->query( './/img[1]', $figure )->item( 0 );
      $alt = $img ? trim( (string) $img->getAttribute( 'alt' ) ) : '';
      $same_as_caption = mb_strtolower( $text ) === mb_strtolower( $existing_text );
      $same_as_alt = $alt !== '' && mb_strtolower( $text ) === mb_strtolower( $alt );
      if ( $same_as_caption || $same_as_alt ) {
        $next->parentNode->removeChild( $next );
      }
      continue;
    }

    if ( $existing ) {
      while ( $existing->firstChild ) {
        $existing->removeChild( $existing->firstChild );
      }
      $existing->appendChild( $dom->createTextNode( $text ) );
      $existing->setAttribute( 'class', trim( $existing->getAttribute( 'class' ) . ' q-image-alt-caption' ) );
    } else {
      $cap = $dom->createElement( 'figcaption' );
      $cap->setAttribute( 'class', 'q-image-alt-caption' );
      $cap->appendChild( $dom->createTextNode( $text ) );
      $figure->appendChild( $cap );
    }

    // Xoá paragraph mô tả (đã chuyển vào caption)
    $next->parentNode->removeChild( $next );
  }

  // 2) Ảnh thường (không nằm trong figure): wrap bằng figure + figcaption (alt)
  $imgs = $xpath->query( '//img[not(ancestor::figure)]' );
  foreach ( $imgs as $img ) {
    $alt = trim( (string) $img->getAttribute( 'alt' ) );
    if ( $alt === '' ) continue;

    $figure = $dom->createElement( 'figure' );
    $figure->setAttribute( 'class', 'q-alt-figure' );

    $clonedImg = $img->cloneNode( true );
    $figure->appendChild( $clonedImg );

    $cap = $dom->createElement( 'figcaption' );
    $cap->setAttribute( 'class', 'q-image-alt-caption' );
    $cap->appendChild( $dom->createTextNode( $alt ) );
    $figure->appendChild( $cap );

    $img->parentNode->replaceChild( $figure, $img );
  }

  $wrapper = $dom->getElementsByTagName( 'div' )->item( 0 );
  $out = '';
  foreach ( $wrapper->childNodes as $node ) {
    $out .= $dom->saveHTML( $node );
  }
  return $out;
}
add_filter( 'the_content', 'quanh_single_add_alt_as_caption', 30 );


// --- BẮT ĐẦU COPY TỪ ĐÂY ---
function tao_bai_viet_mock_rivera() {
    // Kiểm tra xem đã chạy chưa để tránh tạo lặp lại
    if ( get_option( 'rivera_mock_data_generated' ) ) return;

    // Danh sách tiêu đề bài viết giả lập (Chuẩn BĐS)
    $titles = [
        'Tiến độ dự án Rivera Thiên Hoa cập nhật tháng 01/2026',
        'Lễ mở bán phân khu "Phồn Hoa" thu hút hơn 500 nhà đầu tư',
        'Vì sao Bất động sản Sa Đéc đang trở thành tâm điểm miền Tây?',
        'Trải nghiệm chuỗi tiện ích 5 sao tại Rivera Thiên Hoa',
        'Chính sách ưu đãi đặc biệt cho khách hàng đặt cọc tháng này',
        'Đánh giá tiềm năng tăng giá của Shophouse mặt tiền Hùng Vương',
        'Không gian sống xanh chuẩn resort giữa lòng thành phố',
        'Rivera Thiên Hoa: Nơi an cư lý tưởng cho gia đình đa thế hệ',
        'Cập nhật hạ tầng giao thông kết nối dự án Rivera',
        'Bí quyết chọn hướng nhà hợp phong thủy cho gia chủ mệnh Kim'
    ];

    // Nội dung mẫu (Lorem Ipsum + Keywords)
    $content = '
        <p><strong>Rivera Thiên Hoa</strong> đang là tâm điểm chú ý của thị trường bất động sản khu vực...</p>
        <p>Với vị trí đắc địa và tiện ích đẳng cấp, dự án hứa hẹn mang lại khả năng sinh lời cao.</p>
        <h3>Tiềm năng phát triển</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
        <h3>Kết luận</h3>
        <p>Đây là thời điểm vàng để các nhà đầu tư xuống tiền. Mọi chi tiết xin liên hệ hotline phòng kinh doanh.</p>
    ';

    // Chạy vòng lặp tạo bài
    foreach ($titles as $index => $title) {
        $post_data = array(
            'post_title'    => $title,
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'post',
            'post_date'     => date('Y-m-d H:i:s', strtotime("-$index days")) // Mỗi bài cách nhau 1 ngày
        );

        // Chèn bài viết vào WordPress
        wp_insert_post( $post_data );
    }

    // Đánh dấu là đã tạo xong
    update_option( 'rivera_mock_data_generated', true );
}
// Móc hàm vào để chạy khi web load
add_action( 'init', 'tao_bai_viet_mock_rivera' );
// --- KẾT THÚC COPY ---
<?php

if ( ! defined( 'QUANH_THEME_VERSION' ) ) {
  define( 'QUANH_THEME_VERSION', '1.0.0' );
}

add_theme_support('menus');
add_theme_support('title-tag');

function quanh_add_viewport_meta() {
  echo '<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">' . "\n";
}
add_action( 'wp_head', 'quanh_add_viewport_meta', 9999 );

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

// Fallback menu tự động nếu menu chưa được cấu hình
function quanh_fallback_menu() {
  $pages = [
    ['title' => 'Trang chủ', 'slug' => ''],
    ['title' => 'Tổng quan', 'slug' => 'tong-quan'],
    ['title' => 'Vị trí', 'slug' => 'vi-tri'],
    ['title' => 'Mặt bằng', 'slug' => 'mat-bang'],
    ['title' => 'Ưu thế', 'slug' => 'uu-the'],
    ['title' => 'Thư viện', 'slug' => 'thu-vien'],
    ['title' => 'Tin tức', 'slug' => 'tin-tuc'],
    ['title' => 'Liên hệ', 'slug' => 'lien-he']
  ];
  
  echo '<ul class="menu">';
  foreach ($pages as $page) {
    $url = home_url('/' . ($page['slug'] ? $page['slug'] : ''));
    $current = '';
    
    // Kiểm tra trang hiện tại
    if (is_front_page() && $page['slug'] === '') {
      $current = ' current-menu-item';
    } elseif (is_page($page['slug'])) {
      $current = ' current-menu-item';
    }
    
    echo '<li class="menu-item' . $current . '">';
    echo '<a href="' . esc_url($url) . '">' . esc_html($page['title']) . '</a>';
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
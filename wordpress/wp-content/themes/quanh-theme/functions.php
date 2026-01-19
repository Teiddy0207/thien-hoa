<?php
add_theme_support('menus');
add_theme_support('title-tag');

register_nav_menus([
  'header' => 'Header Menu'
]);

function quanh_enqueue_styles() {
  wp_enqueue_style(
    'quanh-style',
    get_stylesheet_uri(),
    [],
    '1.0'
  );
}
add_action('wp_enqueue_scripts', 'quanh_enqueue_styles');

function quanh_enqueue_scripts() {
  wp_enqueue_script(
    'news-load-more',
    get_template_directory_uri() . '/assets/js/news-load-more.js',
    array(),
    '1.0',
    true
  );
  wp_localize_script('news-load-more', 'newsLoadMore', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('news_load_more'),
  ));
}
add_action('wp_enqueue_scripts', 'quanh_enqueue_scripts');

/**
 * AJAX: Load thêm tin tức (trang Tin tức)
 */
function quanh_ajax_news_load_more() {
  check_ajax_referer('news_load_more', 'nonce');
  $paged = max(1, (int) (isset($_POST['paged']) ? $_POST['paged'] : 0));

  $q = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 4,
    'paged'          => $paged,
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

  $max = isset($q->max_num_pages) ? (int) $q->max_num_pages : 1;
  wp_send_json_success(array('html' => $html, 'has_more' => $paged < $max));
}
add_action('wp_ajax_news_load_more', 'quanh_ajax_news_load_more');
add_action('wp_ajax_nopriv_news_load_more', 'quanh_ajax_news_load_more');


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
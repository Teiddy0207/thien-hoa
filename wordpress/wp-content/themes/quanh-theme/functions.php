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
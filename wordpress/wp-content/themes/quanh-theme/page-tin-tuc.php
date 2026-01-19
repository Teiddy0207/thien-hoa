<?php
/*
Template Name: Tin Tức
*/
get_header();

// Trên Page template, get_query_var('page'/'paged') thường không có với /page/2/;
// dùng ?paged= và $_GET là chắc chắn nhất.
$paged = (int) get_query_var( 'paged' );
if ( $paged < 1 ) $paged = (int) get_query_var( 'page' );
if ( $paged < 1 && isset( $_GET['paged'] ) ) $paged = max( 1, (int) $_GET['paged'] );
if ( $paged < 1 ) $paged = 1;

// Lưu URL trang Tin tức TRƯỚC khi chạy WP_Query; sau loop get_permalink() sẽ trả về bài viết cuối.
$news_page_url = get_permalink( get_queried_object_id() );
if ( ! $news_page_url ) $news_page_url = get_permalink();

$news_query = new WP_Query([
  'post_type'      => 'post',
  'posts_per_page' => 4,
  'paged'         => $paged,
  'orderby'       => 'date',
  'order'         => 'DESC'
]);
?>

<section class="news-section">
  <div class="news-container">
    
    <!-- Title -->
    <h1 class="page-title">TIN TỨC</h1>

    <!-- Main Layout -->
    <div class="news-layout">
      
      <!-- Left: Featured Post (bài đầu tiên) -->
      <div class="featured-post">
        <?php
        if ( $news_query->have_posts() ) :
          $news_query->the_post();
        ?>
          <a href="<?php the_permalink(); ?>" class="featured-card">
            <div class="featured-image">
              <?php 
              if (has_post_thumbnail()) {
                $thumbnail_id = get_post_thumbnail_id();
                $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large');
                if ($thumbnail_url) {
                  echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                }
              } else {
                $content = get_the_content();
                $first_image = '';
                if (preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches)) {
                  $first_image = $matches[1];
                }
                if ($first_image) {
                  echo '<img src="' . esc_url($first_image) . '" alt="' . esc_attr(get_the_title()) . '">';
                } else {
                  echo '<div style="background: linear-gradient(135deg, #003d5c, #001f3f); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5);">Không có ảnh</div>';
                }
              }
              ?>
            </div>
            <div class="featured-overlay"></div>
            <div class="featured-content">
              <div class="post-date"><?php echo get_the_date('d/m/Y'); ?></div>
              <h2><?php the_title(); ?></h2>
              <span class="read-more">
                <span>Đọc thêm</span>
                <span class="arrow">→</span>
              </span>
            </div>
          </a>
        <?php endif; ?>
      </div>

      <!-- Right: Post List (3 bài tiếp theo) -->
      <div class="post-list">
        <?php
        while ( $news_query->have_posts() ) : $news_query->the_post();
        ?>
          <a href="<?php the_permalink(); ?>" class="post-item">
            <div class="post-thumbnail">
              <?php 
              if (has_post_thumbnail()) {
                $thumbnail_id = get_post_thumbnail_id();
                $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'medium');
                if ($thumbnail_url) {
                  echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                }
              } else {
                $content = get_the_content();
                $first_image = '';
                if (preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches)) {
                  $first_image = $matches[1];
                }
                if ($first_image) {
                  echo '<img src="' . esc_url($first_image) . '" alt="' . esc_attr(get_the_title()) . '">';
                } else {
                  echo '<div style="background: linear-gradient(135deg, #003d5c, #001f3f); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5); font-size: 12px;">Không có ảnh</div>';
                }
              }
              ?>
            </div>
            <div class="post-info">
              <div class="post-date"><?php echo get_the_date('d/m/Y'); ?></div>
              <h3><?php the_title(); ?></h3>
              <span class="read-more">
                <span>Đọc thêm</span>
                <span>→</span>
              </span>
            </div>
          </a>
        <?php endwhile; ?>
      </div>

    </div>

    <!-- Load thêm (AJAX) -->
    <div id="news-load-more-container" class="news-load-more-container"></div>
    <?php if ( $news_query->max_num_pages > 1 ) : ?>
    <div class="news-load-more-actions">
      <button type="button" class="news-load-more-btn" id="news-load-more-btn" data-current="1" data-max="<?php echo (int) $news_query->max_num_pages; ?>" data-label="Xem thêm tin tức" data-loading="Đang tải...">Xem thêm tin tức</button>
      <p class="news-load-more-end" id="news-load-more-end" style="display:none;">Đã xem hết tin tức</p>
    </div>
    <?php endif; ?>

    <!-- Pagination (giữ nguyên) -->
    <?php
    if ( $news_query->max_num_pages > 1 ) :
      $base = $news_page_url . ( strpos( $news_page_url, '?' ) !== false ? '&' : '?' ) . 'paged=%#%';
    ?>
    <nav class="news-pagination" aria-label="Phân trang tin tức">
      <?php
      echo paginate_links([
        'base'      => $base,
        'format'    => '',
        'current'   => $paged,
        'total'     => $news_query->max_num_pages,
        'prev_text' => '← Trước',
        'next_text' => 'Sau →',
        'type'      => 'plain',
        'end_size'  => 1,
        'mid_size'  => 2,
      ]);
      ?>
    </nav>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

    <!-- Newsletter Subscribe -->
    <!-- <div class="newsletter-section">
      <h2>Đăng ký nhận tin tức mới nhất</h2>
      <p>Cập nhật thông tin mới nhất về dự án Rivera Thiên Hoa</p>
      <form class="newsletter-form" method="post" action="">
        <input type="email" name="email" placeholder="Nhập email của bạn" required>
        <button type="submit">ĐĂNG KÝ</button>
      </form>
    </div> -->

  </div>
</section>

<?php get_footer(); ?>
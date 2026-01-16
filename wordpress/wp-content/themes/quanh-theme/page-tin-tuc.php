<?php
/*
Template Name: Tin Tức
*/
get_header();
?>

<section class="news-section">
  <div class="news-container">
    
    <!-- Title -->
    <h1 class="page-title">TIN TỨC</h1>

    <!-- Main Layout -->
    <div class="news-layout">
      
      <!-- Left: Featured Post -->
      <div class="featured-post">
        <?php
        $featured_query = new WP_Query([
          'posts_per_page' => 1,
          'post_type' => 'post',
          'orderby' => 'date',
          'order' => 'DESC'
        ]);

        if ($featured_query->have_posts()) :
          while ($featured_query->have_posts()) : $featured_query->the_post();
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
                // Fallback: lấy ảnh đầu tiên trong nội dung bài viết
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
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>

      <!-- Right: Post List -->
      <div class="post-list">
        <?php
        $recent_query = new WP_Query([
          'posts_per_page' => 3,
          'post_type' => 'post',
          'offset' => 1,
          'orderby' => 'date',
          'order' => 'DESC'
        ]);

        if ($recent_query->have_posts()) :
          while ($recent_query->have_posts()) : $recent_query->the_post();
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
                // Fallback: lấy ảnh đầu tiên trong nội dung bài viết
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
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>

    </div>



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
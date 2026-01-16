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
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
              <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-news.jpg" alt="<?php the_title(); ?>">
              <?php endif; ?>
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
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
              <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-news.jpg" alt="<?php the_title(); ?>">
              <?php endif; ?>
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

    <!-- More Posts Grid -->
    <div class="more-posts">
      <h2>TIN TỨC MỚI NHẤT</h2>
      
      <div class="posts-grid">
        <?php
        $grid_query = new WP_Query([
          'posts_per_page' => 6,
          'post_type' => 'post',
          'offset' => 4,
          'orderby' => 'date',
          'order' => 'DESC'
        ]);

        if ($grid_query->have_posts()) :
          while ($grid_query->have_posts()) : $grid_query->the_post();
        ?>
          <div class="grid-post-card">
            <a href="<?php the_permalink(); ?>">
              <div class="card-image">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('medium'); ?>
                <?php else : ?>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-news.jpg" alt="<?php the_title(); ?>">
                <?php endif; ?>
              </div>
              <div class="card-content">
                <div class="post-date"><?php echo get_the_date('d/m/Y'); ?></div>
                <h3><?php the_title(); ?></h3>
                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                <span class="read-more">
                  <span>Đọc thêm</span>
                  <span>→</span>
                </span>
              </div>
            </a>
          </div>
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>

      <!-- Pagination -->
      <div class="pagination">
        <?php
        echo paginate_links([
          'total' => $grid_query->max_num_pages,
          'prev_text' => '←',
          'next_text' => '→',
          'type' => 'list'
        ]);
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
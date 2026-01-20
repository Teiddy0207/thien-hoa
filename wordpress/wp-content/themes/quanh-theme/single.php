<?php
/*
Template Name: Single Post
*/
get_header();
?>

<section class="single-post-section">
  <div class="single-post-container">
    
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post();
    ?>
    
    <!-- Post Header -->
    <div class="post-header">
      <div class="post-meta">
        <span class="post-date"><?php echo get_the_date('d/m/Y'); ?></span>
        <?php
        $categories = get_the_category();
        if (!empty($categories)) :
        ?>
          <span class="post-category">
            <?php echo esc_html($categories[0]->name); ?>
          </span>
        <?php endif; ?>
      </div>
      
      <h1 class="post-title"><?php the_title(); ?></h1>
    </div>

    <!-- Featured Image -->
    <?php if (has_post_thumbnail()) : ?>
      <div class="post-featured-image">
        <?php the_post_thumbnail('large'); ?>
      </div>
    <?php endif; ?>

    <!-- Post Content -->
    <div class="post-content">
      <?php the_content(); ?>
    </div>

    <!-- Post Footer -->
    <div class="post-footer">
      <div class="post-tags">
        <?php
        $tags = get_the_tags();
        if ($tags) :
          echo '<span class="tags-label">Tags: </span>';
          foreach ($tags as $tag) {
            echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link">' . esc_html($tag->name) . '</a>';
          }
        endif;
        ?>
      </div>

      <!-- Back to News -->
      <div class="back-to-news">
        <a href="<?php echo get_permalink(get_page_by_path('tin-tuc')); ?>" class="back-link">
          <span>←</span> Quay lại Tin tức
        </a>
      </div>
    </div>

    <?php
    $related = new WP_Query( array(
      'post_type'      => 'post',
      'posts_per_page' => 9,
      'post__not_in'   => array( get_the_ID() ),
      'orderby'        => 'date',
      'order'          => 'DESC',
    ) );
    if ( $related->have_posts() ) :
      $has_more = $related->post_count > 3;
    ?>
    <!-- TIN TỨC KHÁC (carousel: 3 thấy, mũi tên cuộn thêm) -->
    <section class="other-news-section">
      <h2 class="other-news-title">TIN TỨC KHÁC</h2>
      <div class="other-news-wrap">
        <?php if ( $has_more ) : ?><button type="button" class="other-news-arrow other-news-prev" aria-label="Tin trước">‹</button><?php endif; ?>
        <div class="other-news-viewport">
          <div class="other-news-grid">
          <?php
          while ( $related->have_posts() ) : $related->the_post();
            $thumb = '';
            if ( has_post_thumbnail() ) {
              $u = wp_get_attachment_image_url( get_post_thumbnail_id(), 'medium' );
              if ( $u ) $thumb = '<img src="' . esc_url( $u ) . '" alt="' . esc_attr( get_the_title() ) . '">';
            }
            if ( ! $thumb ) {
              $c = get_the_content();
              if ( preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $c, $m ) ) {
                $thumb = '<img src="' . esc_url( $m[1] ) . '" alt="' . esc_attr( get_the_title() ) . '">';
              } else {
                $thumb = '<div class="other-news-no-thumb">Không có ảnh</div>';
              }
            }
          ?>
          <a href="<?php the_permalink(); ?>" class="other-news-card">
            <div class="other-news-thumb"><?php echo $thumb; ?></div>
            <div class="other-news-info">
              <span class="other-news-date"><?php echo get_the_date( 'd/m/Y' ); ?></span>
              <h3 class="other-news-heading"><?php the_title(); ?></h3>
            </div>
          </a>
          <?php endwhile; ?>
          </div>
        </div>
        <?php if ( $has_more ) : ?><button type="button" class="other-news-arrow other-news-next" aria-label="Tin sau">›</button><?php endif; ?>
      </div>
    </section>
    <script>
    (function(){
      var v = document.querySelector('.other-news-viewport');
      var prev = document.querySelector('.other-news-prev');
      var next = document.querySelector('.other-news-next');
      if (!v || !prev || !next) return;
      function scroll(d) {
        var w = v.clientWidth;
        var s = Math.max(0, Math.min(v.scrollWidth - w, v.scrollLeft + d));
        v.scrollTo({ left: s, behavior: 'smooth' });
      }
      prev.addEventListener('click', function(){ scroll(-v.clientWidth); });
      next.addEventListener('click', function(){ scroll(v.clientWidth); });
    })();
    </script>
    <?php
      wp_reset_postdata();
    endif;
    ?>

    <?php
      endwhile;
    endif;
    ?>

  </div>
</section>

<?php get_footer(); ?>

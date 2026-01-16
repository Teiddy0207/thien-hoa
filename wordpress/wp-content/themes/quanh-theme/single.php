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
      endwhile;
    endif;
    ?>

  </div>
</section>

<?php get_footer(); ?>

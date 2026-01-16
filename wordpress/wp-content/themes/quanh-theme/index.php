<?php get_header(); ?>

<main class="site-main">
  <?php
  if (have_posts()) {
    while (have_posts()) {
      the_post();
      ?>
      <article>

      </article>
      <?php
    }
  }
  ?>
</main>

<?php get_footer(); ?>
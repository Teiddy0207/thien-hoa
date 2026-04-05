<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="header-container">

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/thienHoa.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
    </a>

    <!-- Hamburger Button -->
    <button class="hamburger-menu" id="hamburgerMenu" aria-label="Toggle Menu">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav class="main-menu" id="mainMenu">
      <?php
        $menu_args = [
          'theme_location' => 'header',
          'container' => false,
          'fallback_cb' => 'quanh_fallback_menu',
          'items_wrap' => '<ul class="menu">%3$s</ul>'
        ];
        wp_nav_menu($menu_args);
      ?>
    </nav>

  </div>
</header>

<!--  -->

<div class="contact-buttons">
  
  <!-- <a href="tel:0123456789" class="contact-btn phone" title="Gọi ngay">📞</a> -->
  <a href="#lien-he" class="contact-call">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/call4.png' ); ?>" alt="" class="contact-call-bg">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/call5.png' ); ?>" alt="Gọi ngay" class="contact-call-icon">
  </a>
  <a href="#lien-he" class="contact-column" title="Liên hệ để đặt mua">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/column4.png' ); ?>" alt="Liên hệ">
    <span class="column-text">Liên hệ để đặt mua</span>
  </a>

</div>

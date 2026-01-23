<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<head>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="header-container">

    <div class="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/thienHoa.png" alt="Logo">
    </div>

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
    <img src="<?php echo get_template_directory_uri(); ?>/assets/call.png" alt="Gọi ngay">
  </a>
  <a href="#lien-he" class="contact-column" title="Liên hệ để đặt mua">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/column.png" alt="Liên hệ">
    <span class="column-text">LIÊN HỆ ĐỂ ĐẶT MUA</span>
  </a>

</div>

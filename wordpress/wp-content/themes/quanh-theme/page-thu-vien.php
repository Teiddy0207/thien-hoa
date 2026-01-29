<?php
/*
Template Name: Thư Viện
*/
get_header();
?>

<section class="library-section">
  <div class="library-container">
    
    <!-- Title -->
    <h1 class="page-title">THƯ VIỆN</h1>

    <!-- Sub Navigation -->
    <div class="library-tabs">
      <a href="#hinh-anh" class="tab-link active">HÌNH ẢNH</a>
      <a href="#video" class="tab-link">VIDEO</a>
    </div>

    <!-- Gallery Section -->
    <div class="library-gallery" id="hinh-anh">
      
      <!-- Gallery Grid -->
      <div class="gallery-grid">
        <?php
        // Lấy tất cả ảnh đính kèm của page này
        $attachments = get_attached_media('image', get_the_ID());
        
        // Nếu không có ảnh đính kèm, lấy từ gallery custom field hoặc fallback
        if (empty($attachments)) {
          // Fallback: sử dụng ảnh mặc định
          $default_images = array(
            array('url' => get_template_directory_uri() . '/assets/thuvien1.png', 'alt' => 'Rivera Thiên Hoa'),
            array('url' => get_template_directory_uri() . '/assets/thuvien2.png', 'alt' => 'Rivera Thiên Hoa')
          );
          
          foreach ($default_images as $img) {
            echo '<div class="gallery-item">';
            echo '  <div class="gallery-image-wrapper">';
            echo '    <img src="' . esc_url($img['url']) . '" alt="' . esc_attr($img['alt']) . '">';
            echo '    <div class="image-label">ẢNH DIỄN HỌA 3D</div>';
            echo '  </div>';
            echo '</div>';
          }
        } else {
          // Hiển thị ảnh từ Media Library
          foreach ($attachments as $attachment) {
            $image_url = wp_get_attachment_image_url($attachment->ID, 'large');
            $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            if (empty($image_alt)) {
              $image_alt = get_the_title($attachment->ID);
            }
            $image_caption = wp_get_attachment_caption($attachment->ID);
            $label = !empty($image_caption) ? $image_caption : 'ẢNH DIỄN HỌA 3D';
            
            echo '<div class="gallery-item">';
            echo '  <div class="gallery-image-wrapper">';
            echo '    <img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
            echo '    <div class="image-label">' . esc_html($label) . '</div>';
            echo '  </div>';
            echo '</div>';
          }
        }
        ?>
      </div>

      <!-- Gallery Navigation -->
      <div class="gallery-nav">
        <a href="#" class="nav-arrow prev">
          <span>← Trước</span>
        </a>
        <a href="#" class="nav-arrow next">
          <span>Sau →</span>
        </a>
      </div>

    </div>

    <!-- Video Section (Hidden by default) -->
    <div class="library-video" id="video" style="display: none;">
      <div class="video-grid">
        <!-- Video items will be added here -->
        <p style="text-align: center; color: rgba(255, 255, 255, 0.7); padding: 60px 0;">
          Nội dung video sẽ được cập nhật sau
        </p>
      </div>
    </div>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const tabs = document.querySelectorAll('.tab-link');
  const gallerySection = document.getElementById('hinh-anh');
  const videoSection = document.getElementById('video');

  tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Remove active class from all tabs
      tabs.forEach(t => t.classList.remove('active'));
      
      // Add active class to clicked tab
      this.classList.add('active');
      
      // Show/hide sections
      if (this.getAttribute('href') === '#hinh-anh') {
        gallerySection.style.display = 'block';
        videoSection.style.display = 'none';
      } else {
        gallerySection.style.display = 'none';
        videoSection.style.display = 'block';
      }
    });
  });
});
</script>


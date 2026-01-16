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
        <div class="gallery-item">
          <div class="gallery-image-wrapper">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/thuvien1.png" alt="Rivera Thiên Hoa">
            <div class="image-label">ẢNH DIỄN HỌA 3D</div>
          </div>
        </div>
        
        <div class="gallery-item">
          <div class="gallery-image-wrapper">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/thuvien2.png" alt="Rivera Thiên Hoa">
            <div class="image-label">ẢNH DIỄN HỌA 3D</div>
          </div>
        </div>
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

<?php get_footer(); ?>

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

    <!-- Gallery Section: mỗi lần hiển thị 2 ảnh, nút Trước/Sau chuyển trang -->
    <div class="library-gallery" id="hinh-anh">
      <div class="gallery-pages-wrap">
        <?php
        $gallery_ids = quanh_get_library_gallery_ids( get_the_ID() );
        $items = array();
        if ( ! empty( $gallery_ids ) ) {
          foreach ( $gallery_ids as $aid ) {
            $image_url = wp_get_attachment_image_url( $aid, 'large' );
            if ( ! $image_url ) continue;
            $image_alt = get_post_meta( $aid, '_wp_attachment_image_alt', true ) ?: get_the_title( $aid );
            $image_caption = wp_get_attachment_caption( $aid );
            $label = $image_caption ?: 'ẢNH DIỄN HỌA 3D';
            $items[] = array( 'url' => $image_url, 'alt' => $image_alt, 'label' => $label );
          }
        }
        if ( empty( $items ) ) {
          $items = array(
            array( 'url' => get_template_directory_uri() . '/assets/thuvien1.png', 'alt' => 'Rivera Thiên Hoa', 'label' => 'ẢNH DIỄN HỌA 3D' ),
            array( 'url' => get_template_directory_uri() . '/assets/thuvien2.png', 'alt' => 'Rivera Thiên Hoa', 'label' => 'ẢNH DIỄN HỌA 3D' ),
          );
        }
        $per_page = 2;
        $chunks = array_chunk( $items, $per_page );
        foreach ( $chunks as $i => $chunk ) {
          $active = $i === 0 ? ' active' : '';
          echo '<div class="gallery-page' . $active . '" data-page="' . ( $i + 1 ) . '">';
          echo '<div class="gallery-grid">';
          foreach ( $chunk as $img ) {
            echo '<div class="gallery-item"><div class="gallery-image-wrapper">';
            echo '<img src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $img['alt'] ) . '">';
            echo '<div class="image-label">' . esc_html( $img['label'] ) . '</div></div></div>';
          }
          echo '</div></div>';
        }
        ?>
      </div>
      <div class="gallery-nav">
        <button type="button" class="nav-arrow prev" aria-label="Trang trước"><span>← Trước</span></button>
        <button type="button" class="nav-arrow next" aria-label="Trang sau"><span>Sau →</span></button>
      </div>
    </div>

    <!-- Video Section (video quản lý tại meta box "Video Thư viện" khi sửa page) -->
    <div class="library-video" id="video" style="display: none;">
      <div class="video-grid">
        <?php
        $library_videos = quanh_get_library_videos( get_the_ID() );
        if ( ! empty( $library_videos ) ) {
          foreach ( $library_videos as $v ) {
            $url = is_array( $v ) ? ( $v['url'] ?? '' ) : (string) $v;
            $title = is_array( $v ) ? ( $v['title'] ?? '' ) : '';
            if ( $url === '' ) continue;
            $embed = wp_oembed_get( $url, array( 'width' => 560 ) );
            if ( $embed ) {
              echo '<div class="video-item">';
              if ( $title ) echo '<p class="video-item-title">' . esc_html( $title ) . '</p>';
              echo $embed . '</div>';
            }
          }
        } else {
          echo '<p style="text-align: center; color: rgba(255, 255, 255, 0.7); padding: 60px 0;">Nội dung video sẽ được cập nhật sau. Vào <strong>Trang → Chỉnh sửa page Thư viện</strong>, thêm link YouTube/Vimeo tại meta box "Video Thư viện".</p>';
        }
        ?>
      </div>
    </div>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var tabs = document.querySelectorAll('.tab-link');
  var gallerySection = document.getElementById('hinh-anh');
  var videoSection = document.getElementById('video');
  tabs.forEach(function(tab) {
    tab.addEventListener('click', function(e) {
      e.preventDefault();
      tabs.forEach(function(t) { t.classList.remove('active'); });
      this.classList.add('active');
      if (this.getAttribute('href') === '#hinh-anh') {
        gallerySection.style.display = 'block';
        videoSection.style.display = 'none';
      } else {
        gallerySection.style.display = 'none';
        videoSection.style.display = 'block';
      }
    });
  });

  var wrap = document.querySelector('.library-gallery .gallery-pages-wrap');
  var pages = wrap ? wrap.querySelectorAll('.gallery-page') : [];
  var prevBtn = document.querySelector('.library-gallery .gallery-nav .nav-arrow.prev');
  var nextBtn = document.querySelector('.library-gallery .gallery-nav .nav-arrow.next');
  var current = 1;
  var total = pages.length;
  function showPage(n) {
    current = Math.max(1, Math.min(n, total));
    pages.forEach(function(p, i) {
      p.classList.toggle('active', i + 1 === current);
    });
    if (prevBtn) prevBtn.disabled = current <= 1;
    if (nextBtn) nextBtn.disabled = current >= total;
    if (infoEl) infoEl.textContent = total > 0 ? current + ' / ' + total : '';
  }
  if (prevBtn) prevBtn.addEventListener('click', function() { showPage(current - 1); });
  if (nextBtn) nextBtn.addEventListener('click', function() { showPage(current + 1); });
  showPage(1);
});
</script>


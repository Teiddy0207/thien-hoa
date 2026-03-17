<?php
/**
 * Landing page: Hero + Tổng quan + Vị trí + Mặt bằng + Ưu thế + Thư viện + Liên hệ
 * Cuộn mượt, một trang.
 */
get_header();
$template_uri = get_template_directory_uri();
$gallery_page_id = null;
$thu_vien_pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'page-thu-vien.php'));
if (!empty($thu_vien_pages)) {
  $gallery_page_id = $thu_vien_pages[0]->ID;
}
?>

<main id="landing-main" class="landing-page">
  <!-- Hero -->
  <section class="hero-section reveal-on-scroll is-visible" id="trang-chu">
    <div class="hero-container">
      <div class="hero-content">
        <img src="<?php echo esc_url($template_uri); ?>/assets/primary-text.svg"
             alt="Khởi sinh trên đất phồn hoa"
             class="hero-title-image">
        <a href="#lien-he" class="cta-btn-custom">
          <img src="<?php echo esc_url($template_uri); ?>/assets/lienhe2.png" alt="Nút liên hệ">
          <span class="cta-text">LIÊN HỆ</span>
        </a>
      </div>
      <div class="hero-image">
        <img src="<?php echo esc_url($template_uri); ?>/assets/object.svg" alt="Rivera Thiên Hoa">
      </div>
    </div>
    <div class="hero-bottom-image">
      <img src="<?php echo esc_url($template_uri); ?>/assets/line-removebg-preview.png" alt="">
    </div>
  </section>

  <!-- Tổng quan -->
  <section class="overview-section reveal-on-scroll" id="tong-quan">
    <div class="overview-container">
      <h1 class="page-title">TỔNG QUAN DỰ ÁN</h1>
      <div class="overview-content">
        <div class="info-group">
          <div class="info-icon"><img src="<?php echo esc_url($template_uri); ?>/assets/tongquan1.png" alt=""></div>
          <div class="info-details">
            <div class="info-label">Tên thương mại:</div>
            <div class="info-value">RIVERA THIÊN HOA</div>
          </div>
        </div>
        <div class="info-group">
          <div class="info-icon"><img src="<?php echo esc_url($template_uri); ?>/assets/tongquan2.png" alt=""></div>
          <div class="info-details">
            <div class="info-label">Vị trí:</div>
            <div class="info-value">XÃ TÂN DƯƠNG, TỈNH ĐỒNG THÁP</div>
          </div>
        </div>
        <div class="info-group">
          <div class="info-icon"><img src="<?php echo esc_url($template_uri); ?>/assets/tongquan3.png" alt=""></div>
          <div class="info-details">
            <div class="info-label">Chủ Đầu tư:</div>
            <div class="info-value">CÔNG TY TNHH THƯƠNG MẠI<br>ĐẦU TƯ XÂY DỰNG<br>ĐTK LAND SA ĐÉC (DTK LAND)</div>
          </div>
        </div>
        <div class="info-group">
          <div class="info-icon"><img src="<?php echo esc_url($template_uri); ?>/assets/tongquan45.png" alt=""></div>
          <div class="info-details">
            <div class="info-label">Quy mô:</div>
            <div class="info-value">2.94 ha</div>
          </div>
        </div>
        <div class="info-group">
          <div class="info-icon"><img src="<?php echo esc_url($template_uri); ?>/assets/tongquan5.png" alt=""></div>
          <div class="info-details">
            <div class="info-label">Đơn vị hợp tác <br> phát triển dự án:</div>
            <div class="info-value">CÔNG TY CP ĐẦU TƯ VÀ<br>PHÁT TRIỂN ĐÔ THỊ LONG GIANG<br>(LONG GIANG LAND)</div>
          </div>
        </div>
        <div class="info-group">
          <div class="info-icon"><img src="<?php echo esc_url($template_uri); ?>/assets/tongquan6.png" alt=""></div>
          <div class="info-details">
            <div class="info-label">Loại hình <br> sản phẩm:</div>
            <div class="info-value">43 CĂN NHÀ Ở LIỀN KỀ,<br>121 LÔ ĐẤT NỀN</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Vị trí (giữ background section, không lệch tỉ lệ) -->
  <section class="location-section location-section--landing reveal-on-scroll" id="vi-tri">
    <div class="location-container">
      <h1 class="page-title">VỊ TRÍ ĐẮC ĐỊA</h1>
      <div class="location-content">
        <div class="location-info">
          <div class="info-box">
            <p class="info-text">
              Tọa lạc tại Phường Tân Phú Đông, Rivera Thiên Hoa sở hữu vị trí đắng mơ ước với khả năng kết nối giao thông thuận tiện cùng đặc quyền thu hưởng nền tảng giá trị văn hoá lâu đời trên miền đất di sản đã sớm phồn nét phồn hoa nức tiếng cách đây cả trăm năm.
            </p>
          </div>
          <div class="location-nav">
            <button class="nav-btn prev" id="locationPrevBtn" type="button">
              <span class="arrow">←</span>
              <span>Trước</span>
            </button>
            <div class="nav-dots" id="locationDots">
              <span class="dot active"></span>
              <span class="dot"></span>
              <span class="dot"></span>
            </div>
            <button class="nav-btn next" id="locationNextBtn" type="button">
              <span>Sau</span>
              <span class="arrow">→</span>
            </button>
          </div>
        </div>
        <div class="location-map">
          <div class="location-tagline">
            <img src="<?php echo esc_url($template_uri); ?>/assets/songtinhhoa2.png" alt="Sống TINH HOA nơi tâm điểm GIAO HOÀ">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mặt bằng -->
  <section class="matbang-section reveal-on-scroll" id="mat-bang">
    <div class="matbang-container">
      <div class="matbang-intro">
        <div class="matbang-image">
          <div class="matbang-image-wrapper">
            <?php
            if (is_front_page() && has_post_thumbnail(get_queried_object_id())) {
              echo get_the_post_thumbnail(get_queried_object_id(), 'full');
            } else {
              echo '<img src="' . esc_url($template_uri . '/assets/house3.png') . '" alt="Rivera Thiên Hoa Shophouse">';
            }
            ?>
            <div class="matbang-image-overlay"></div>
          </div>
        </div>
        <div class="matbang-content">
          <div class="matbang-title">
            <img src="<?php echo esc_url($template_uri); ?>/assets/matbangtext2.png" alt="Sống cảm hứng nơi vẻ đẹp thăng hoa">
          </div>
          <div class="matbang-description">
            <p>
              Lấy cảm hứng từ những đô thị phồn hoa phương Tây, Rivera Thiên Hoa chắt lọc tinh hoa kiến trúc Pháp hào hoa kết hợp ngôn ngữ kiến trúc mang hơi thở hiện đại làm chất riêng toả sáng và góp phần tạo nên không gian sống đầy cảm hứng và tự hào của cư dân tương lai.
            </p>
            <p>
              Với vẻ đẹp bề thế, điểm lẻ, tôn vinh sự cân bằng trong từng bố cục, đường nét, Rivera Thiên Hoa vừa nổi bật, vừa hài hoà trong tổng thể cảnh quan miền di sản hoa hoa Sa Đéc.
            </p>
          </div>
          <a href="#uu-the" class="matbang-cta-button">
            <img src="<?php echo esc_url($template_uri); ?>/assets/lienhe2.png" alt="Xem mặt bằng">
            <span class="matbang-cta-text">XEM MẶT BẰNG</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Ưu thế -->
  <section class="advantages-section reveal-on-scroll" id="uu-the">
    <div class="advantages-container">
      <div class="section-header">
        <div class="subtitle">
          <img src="<?php echo esc_url($template_uri); ?>/assets/logouuthe6.png" alt="Rivera Thiên Hoa">
        </div>
        <h1 class="page-title">5 LỢI THẾ DANH GIÁ</h1>
      </div>
      <div class="advantages-grid">
        <div class="advantage-card">
          <div class="card-image">
            <img src="<?php echo esc_url($template_uri); ?>/assets/uuthe1.png" alt="Vị trí đắt giá">
            <div class="card-overlay"></div>
            <div class="card-content">
              <h3>VỊ TRÍ ĐẮT GIÁ</h3>
              <p class="card-description">
                Vị trí tâm điểm đất giá trên miền đất di sản đầy tiềm năng cùng với tầm nhìn của một đô thị động lực trong vùng đô thị trung tâm đồng bằng Sông Cửu Long, dễ dàng kết nối giao thông, tận hưởng tiện ích nội ngoại khu phong phú.
              </p>
            </div>
            <div class="card-border"></div>
          </div>
        </div>
        <div class="advantage-card">
          <div class="card-image">
            <img src="<?php echo esc_url($template_uri); ?>/assets/uuthe2.png" alt="Kiến trúc tinh hoa">
            <div class="card-overlay"></div>
            <div class="card-content">
              <h3>KIẾN TRÚC TINH HOA</h3>
              <p class="card-description">
                Thiết kế kiến trúc tân cổ điển lấy cảm hứng từ những tinh hoa của các miền đất lộng lẫy, văn minh bậc nhất thế giới để viết tiếp câu chuyện phồn hoa của miền đất di sản "bồn mùa đều xuân".
              </p>
            </div>
            <div class="card-border"></div>
          </div>
        </div>
        <div class="advantage-card">
          <div class="card-image">
            <img src="<?php echo esc_url($template_uri); ?>/assets/uuthe3.png" alt="Chủ đầu tư uy tín">
            <div class="card-overlay"></div>
            <div class="card-content">
              <h3>CHỦ ĐẦU TƯ UY TÍN</h3>
              <p class="card-description">
                Được phát triển và bảo chứng bởi chủ đầu tư DTK Land và các đối tác uy tín hàng đầu.
              </p>
            </div>
            <div class="card-border"></div>
          </div>
        </div>
        <div class="advantage-card">
          <div class="card-image">
            <img src="<?php echo esc_url($template_uri); ?>/assets/uuthe4.png" alt="Pháp lý minh bạch">
            <div class="card-overlay"></div>
            <div class="card-content">
              <h3>PHÁP LÝ MINH BẠCH</h3>
              <p class="card-description">
                Pháp lý minh bạch, rõ ràng tạo cơ sở vững chắc cho khách hàng về nhà đầu tư.
              </p>
            </div>
            <div class="card-border"></div>
          </div>
        </div>
        <div class="advantage-card">
          <div class="card-image">
            <img src="<?php echo esc_url($template_uri); ?>/assets/uuthe5.png" alt="Tiềm năng đầu tư">
            <div class="card-overlay"></div>
            <div class="card-content">
              <h3>TIỀM NĂNG ĐẦU TƯ</h3>
              <p class="card-description">
                Tiềm năng gia tăng giá trị tài sản tích luỹ trong tương lai và gia trị thương mại đất giá.
              </p>
            </div>
            <div class="card-border"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Thư viện -->
  <section class="library-section reveal-on-scroll" id="thu-vien">
    <div class="library-container">
      <h1 class="page-title">THƯ VIỆN</h1>
      <div class="library-tabs">
        <a href="#hinh-anh" class="tab-link active">HÌNH ẢNH</a>
        <a href="#video" class="tab-link">VIDEO</a>
      </div>
      <div class="library-gallery" id="hinh-anh">
        <div class="gallery-pages-wrap">
          <?php
          $gallery_ids = quanh_get_library_gallery_ids( $gallery_page_id );
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
              array( 'url' => $template_uri . '/assets/thuvien1.png', 'alt' => 'Rivera Thiên Hoa', 'label' => 'ẢNH DIỄN HỌA 3D' ),
              array( 'url' => $template_uri . '/assets/thuvien2.png', 'alt' => 'Rivera Thiên Hoa', 'label' => 'ẢNH DIỄN HỌA 3D' ),
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
          <span class="gallery-page-info"></span>
          <button type="button" class="nav-arrow next" aria-label="Trang sau"><span>Sau →</span></button>
        </div>
      </div>
      <div class="library-video" id="video" style="display: none;">
        <div class="video-grid">
          <?php
          $library_videos = quanh_get_library_videos( $gallery_page_id );
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
            echo '<p style="text-align: center; color: rgba(255, 255, 255, 0.7); padding: 60px 0;">Nội dung video sẽ được cập nhật sau</p>';
          }
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Liên hệ -->
  <section class="contact-rivera-section contact-rivera-section--landing reveal-on-scroll" id="lien-he">
    <div class="rv-container">
      <div class="rv-info-title">THÔNG TIN LIÊN HỆ:</div>
      <div class="rv-row">
        <div class="rv-col-info">
          <div class="rv-info-item">
            <div class="rv-info-icon-wrapper">
              <div class="rv-info-icon">
                <img src="<?php echo esc_url($template_uri); ?>/assets/tongquan6.png" alt="">
              </div>
              <div>
                <span class="rv-info-label">Địa chỉ dự án:</span>
                <div class="rv-info-text">Xã Tân Dương, Tỉnh Đồng Tháp.</div>
              </div>
            </div>
          </div>
          <div class="rv-info-item">
            <div class="rv-info-icon-wrapper">
              <div class="rv-info-icon">
                <img src="<?php echo esc_url($template_uri); ?>/assets/calllienhe.png" alt="">
              </div>
              <div>
                <span class="rv-info-label">Hotline CSKH:</span>
                <div class="rv-info-text">0909.xxx.xxx (Liên hệ trực tiếp)</div>
              </div>
            </div>
          </div>
          <div class="rv-info-item">
            <span class="rv-info-label">TÊN PHÁP LÝ:</span>
            <div class="rv-info-text">CÔNG TY TNHH ĐẦU TƯ RIVERA</div>
          </div>
          <div class="rv-info-item">
            <span class="rv-info-label">VĂN PHÒNG BÁN HÀNG:</span>
            <div class="rv-info-text">Số 123, Đường Hùng Vương, TP. Sa Đéc</div>
          </div>
        </div>
        <div class="rv-col-form">
          <h2 class="rv-form-title">ĐĂNG KÝ</h2>
          <div class="rv-form-subtitle">NHẬN THÔNG TIN DỰ ÁN</div>
          <form action="" method="post">
            <div class="rv-input-group">
              <input type="text" class="rv-input" placeholder="Họ và tên" required>
            </div>
            <div class="rv-form-row-dual">
              <div class="rv-input-group">
                <input type="tel" class="rv-input" placeholder="Số điện thoại" required>
              </div>
              <div class="rv-input-group">
                <input type="email" class="rv-input" placeholder="Email">
              </div>
            </div>
            <div class="rv-note">
              Tư vấn viên của chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất. Chân thành cảm ơn!
            </div>
            <button type="submit" class="rv-submit-btn">ĐĂNG KÝ NGAY</button>
          </form>
        </div>
      </div>
      <div class="rv-footer-with-wave">
        <div class="rv-disclaimer">* Thông tin, hình ảnh, các tiện ích trên website chỉ mang tính chất tương đối và có thể được điều chỉnh theo quyết định của Chủ đầu tư tại từng thời điểm, đảm bảo phù hợp quy hoạch và thực tế thi công Dự án.</div>
      </div>
    </div>
  </section>
</main>

<script>
(function() {
  'use strict';
  var descriptions = [
    "Tọa lạc tại Phường Tân Phú Đông, Rivera Thiên Hoa sở hữu vị trí đắng mơ ước với khả năng kết nối giao thông thuận tiện cùng đặc quyền thu hưởng nền tảng giá trị văn hoá lâu đời trên miền đất di sản đã sớm phồn nét phồn hoa nức tiếng cách đây cả trăm năm.",
    "Dễ dàng di chuyển đến các khu vực trọng điểm của tỉnh Đồng Tháp và các tỉnh lân cận thông qua hệ thống giao thông hiện đại, tiện lợi.",
    "Gần trung tâm thành phố, trường học, bệnh viện, siêu thị và các tiện ích công cộng phục vụ nhu cầu sinh hoạt hàng ngày."
  ];
  var currentSlide = 0;
  var infoText = document.querySelector('#vi-tri .info-text');
  var dots = document.querySelectorAll('#vi-tri .nav-dots .dot');
  var prevBtn = document.getElementById('locationPrevBtn');
  var nextBtn = document.getElementById('locationNextBtn');
  if (!infoText || !dots.length) return;
  function updateSlide(animate) {
    if (animate) {
      infoText.classList.add('is-changing');
      setTimeout(function() {
        infoText.textContent = descriptions[currentSlide];
        infoText.classList.remove('is-changing');
      }, 300);
    } else {
      infoText.textContent = descriptions[currentSlide];
    }
    dots.forEach(function(dot, idx) {
      dot.classList.toggle('active', idx === currentSlide);
    });
    if (prevBtn) prevBtn.disabled = currentSlide === 0;
    if (nextBtn) nextBtn.disabled = currentSlide === descriptions.length - 1;
  }
  if (prevBtn) prevBtn.addEventListener('click', function() {
    if (currentSlide > 0) { currentSlide--; updateSlide(true); }
  });
  if (nextBtn) nextBtn.addEventListener('click', function() {
    if (currentSlide < descriptions.length - 1) { currentSlide++; updateSlide(true); }
  });
  dots.forEach(function(dot, idx) {
    dot.addEventListener('click', function() {
      if (currentSlide !== idx) { currentSlide = idx; updateSlide(true); }
    });
  });
})();
</script>
<script>
(function() {
  var tabs = document.querySelectorAll('#thu-vien .tab-link');
  var gallerySection = document.getElementById('hinh-anh');
  var videoSection = document.getElementById('video');
  if (!tabs.length || !gallerySection || !videoSection) return;
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

  var wrap = document.querySelector('#thu-vien .library-gallery .gallery-pages-wrap');
  var pages = wrap ? wrap.querySelectorAll('.gallery-page') : [];
  var prevBtn = document.querySelector('#thu-vien .library-gallery .gallery-nav .nav-arrow.prev');
  var nextBtn = document.querySelector('#thu-vien .library-gallery .gallery-nav .nav-arrow.next');
  var infoEl = document.querySelector('#thu-vien .library-gallery .gallery-page-info');
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
})();
</script>

<?php get_footer(); ?>

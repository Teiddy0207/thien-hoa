<?php
/*
Template Name: Tổng Quan Dự Án
*/
get_header();
?>

<section class="overview-section">
  <div class="overview-container">
    
    <h1 class="page-title">TỔNG QUAN DỰ ÁN</h1>

    <div class="overview-content">
      
      <!-- Tên thương mại -->
      <div class="info-group">
        <div class="info-icon">🏢</div>
        <div class="info-details">
          <div class="info-label">Tên thương mại:</div>
          <div class="info-value">RIVERA THIÊN HOA</div>
        </div>
      </div>

      <!-- Vị trí -->
      <div class="info-group">
        <div class="info-icon">📍</div>
        <div class="info-details">
          <div class="info-label">Vị trí:</div>
          <div class="info-value">ẤP PHÚ LONG, XÃ TÂN PHÚ ĐÔNG,<br>TP. SA ĐÉC, TỈNH ĐỒNG THÁP</div>
        </div>
      </div>

      <!-- Chủ đầu tư -->
      <div class="info-group">
        <div class="info-icon">💼</div>
        <div class="info-details">
          <div class="info-label">Chủ Đầu tư:</div>
          <div class="info-value">CÔNG TY TNHH THƯƠNG MẠI<br>ĐẦU TƯ XÂY DỰNG<br>DTK LAND SA ĐÉC (DTK LAND)</div>
        </div>
      </div>

      <!-- Quy mô -->
      <div class="info-group">
        <div class="info-icon">📐</div>
        <div class="info-details">
          <div class="info-label">Quy mô:</div>
          <div class="info-value">2.94 ha</div>
        </div>
      </div>

      <!-- Đơn vị hợp tác phát triển -->
      <div class="info-group">
        <div class="info-icon">📊</div>
        <div class="info-details">
          <div class="info-label">Đơn vị hợp tác phát triển dự án:</div>
          <div class="info-value">CÔNG TY CP ĐẦU TƯ VÀ<br>PHÁT TRIỂN ĐÔ THỊ LONG GIANG<br>(LONG GIANG LAND)</div>
        </div>
      </div>

      <!-- Loại hình sản phẩm -->
      <div class="info-group">
        <div class="info-icon">🏘️</div>
        <div class="info-details">
          <div class="info-label">Loại hình sản phẩm:</div>
          <div class="info-value">43 CĂN NHÀ Ở LIỀN KỀ,<br>121 LÔ ĐẤT NỀN</div>
        </div>
      </div>

    </div>

    <!-- PROJECT IMAGE -->
    <div class="project-image">
      <?php
      if (has_post_thumbnail()) {
        the_post_thumbnail('full');
      } else {
        echo '<img src="' . get_template_directory_uri() . '/assets/images/project-overview.jpg" alt="Rivera Thiên Hoa Project">';
      }
      ?>
    </div>

  </div>
</section>

<?php get_footer(); ?>
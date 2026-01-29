<?php
/*
Template Name: Mặt Bằng
*/
get_header();
?>

<section class="matbang-section">
  <div class="matbang-container">
    
    <!-- Hero Section -->
    <div class="matbang-intro">
      
      <!-- Left: Image -->
      <div class="matbang-image">
        <div class="matbang-image-wrapper">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail('full');
          } else {
            echo '<img src="' . get_template_directory_uri() . '/assets/house3.png" alt="Rivera Thiên Hoa Shophouse">';
          }
          ?>
          <div class="matbang-image-overlay"></div>
        </div>
      </div>

      <!-- Right: Description -->
      <div class="matbang-content">
        <div class="matbang-title">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/matbangtext2.png" alt="Sống cảm hứng nơi vẻ đẹp thăng hoa">
        </div>

        <div class="matbang-description">
          <p>
            Lấy cảm hứng từ những đô thị phồn hoa phương Tây, Rivera Thiên Hoa chắt lọc tinh hoa kiến trúc Pháp hào hoa kết hợp ngôn ngữ kiến trúc mang hơi thở hiện đại làm chất riêng toả sáng và góp phần tạo nên không gian sống đầy cảm hứng và tự hào của cư dân tương lai.
          </p>
          <p>
            Với vẻ đẹp bề thế, điểm lẻ, tôn vinh sự cân bằng trong từng bố cục, đường nét, Rivera Thiên Hoa vừa nổi bật, vừa hài hoà trong tổng thể cảnh quan miền di sản hoa hoa Sa Đéc.
          </p>
        </div>

        <a href="#product-types" class="matbang-cta-button">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/lienhe2.png" alt="Xem mặt bằng">
          <span class="matbang-cta-text">XEM MẶT BẰNG</span>
        </a>
      </div>
    </div>

    <!-- Product Types -->
    <!-- <div id="product-types" class="product-section">
      <h2 class="section-title">PHÂN KHU SẢN PHẨM</h2>


      <div class="type-selector">
        <button class="type-btn active" data-type="shophouse">NHÀ PHỐ THƯƠNG MẠI</button>
        <button class="type-btn" data-type="land">ĐẤT NỀN</button>
      </div>

      <div class="product-details">
        <div class="detail-card">
          <div class="detail-icon">🏘️</div>
          <div class="detail-label">Loại hình</div>
          <div class="detail-value" id="product-title">NHÀ PHỐ THƯƠNG MẠI</div>
        </div>

        <div class="detail-card">
          <div class="detail-icon">📊</div>
          <div class="detail-label">Số lượng</div>
          <div class="detail-value gold" id="product-total">43 căn</div>
        </div>

        <div class="detail-card">
          <div class="detail-icon">📐</div>
          <div class="detail-label">Diện tích</div>
          <div class="detail-value" id="product-area">5x20m - 5x25m</div>
        </div>

        <div class="detail-card">
          <div class="detail-icon">🏗️</div>
          <div class="detail-label">Quy mô</div>
          <div class="detail-value" id="product-floors">4 tầng</div>
        </div>
      </div>

      <div class="floorplan-grid">
        <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="floorplan-card">
          <div class="floorplan-preview">
            <div class="preview-icon">📋</div>
            <div class="preview-title">Mặt bằng <?php echo $i; ?></div>
            <div class="preview-size">5x20m</div>
          </div>
          <div class="floorplan-footer">
            <button class="view-btn">XEM CHI TIẾT</button>
          </div>
        </div>
        <?php endfor; ?>
      </div>

      <div class="cta-section">
        <h3>Quan tâm đến dự án?</h3>
        <p>Liên hệ ngay để được tư vấn chi tiết về mặt bằng và bảng giá</p>
        <div class="cta-buttons">
          <a href="tel:0123456789" class="btn-primary">📞 GỌI NGAY</a>
          <a href="#lien-he" class="btn-secondary">ĐĂNG KÝ TƯ VẤN</a>
        </div>
      </div>
    </div> -->

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const products = {
    shophouse: {
      title: 'NHÀ PHỐ THƯƠNG MẠI',
      total: '43 căn',
      area: '5x20m - 5x25m',
      floors: '4 tầng'
    },
    land: {
      title: 'ĐẤT NỀN',
      total: '121 lô',
      area: '5x20m - 6x25m',
      floors: 'Đất trống'
    }
  };

  const typeBtns = document.querySelectorAll('.type-btn');
  
  typeBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      typeBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      
      const type = this.dataset.type;
      const product = products[type];
      
      document.getElementById('product-title').textContent = product.title;
      document.getElementById('product-total').textContent = product.total;
      document.getElementById('product-area').textContent = product.area;
      document.getElementById('product-floors').textContent = product.floors;
    });
  });
});
</script>


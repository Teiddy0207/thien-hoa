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
            echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/house3.png' ) . '" alt="Rivera Thiên Hoa Shophouse">';
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


<?php
/*
Template Name: Vị Trí
*/
get_header();
?>

<section class="location-section">
  <div class="location-container">
    
    <h1 class="page-title">VỊ TRÍ ĐẮC ĐỊA</h1>

    <div class="location-content">
      
      <!-- Left: Description -->
      <div class="location-info">
        <div class="info-box">
          <p class="info-text">
            Tọa lạc tại Phường Tân Phú Đông, Rivera Thiên Hoa sở hữu vị trí đắng mơ ước với khả năng kết nối giao thông thuận tiện cùng đặc quyền thu hưởng nền tảng giá trị văn hoá lâu đời trên miền đất di sản đã sớm phồn nét phồn hoa nức tiếng cách đây cả trăm năm.
          </p>
        </div>

        <!-- Navigation -->
        <div class="location-nav">
          <button class="nav-btn prev" id="prevBtn">
            <span class="arrow">←</span>
            <span>Trước</span>
          </button>

          <div class="nav-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
          </div>

          <button class="nav-btn next" id="nextBtn">
            <span>Sau</span>
            <span class="arrow">→</span>
          </button>
        </div>
      </div>

      <!-- Right: Map -->
      <div class="location-map">

        <!-- Bottom Text -->
        <div class="location-tagline">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/songtinhhoa2.png" alt="Sống TINH HOA nơi tâm điểm GIAO HOÀ">
        </div>
      </div>

    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Thêm class vào body để CSS có thể target
  document.body.classList.add('page-vi-tri');
  
  const descriptions = [
    "Tọa lạc tại Phường Tân Phú Đông, Rivera Thiên Hoa sở hữu vị trí đắng mơ ước với khả năng kết nối giao thông thuận tiện cùng đặc quyền thu hưởng nền tảng giá trị văn hoá lâu đời trên miền đất di sản đã sớm phồn nét phồn hoa nức tiếng cách đây cả trăm năm.",
    "Dễ dàng di chuyển đến các khu vực trọng điểm của tỉnh Đồng Tháp và các tỉnh lân cận thông qua hệ thống giao thông hiện đại, tiện lợi.",
    "Gần trung tâm thành phố, trường học, bệnh viện, siêu thị và các tiện ích công cộng phục vụ nhu cầu sinh hoạt hàng ngày."
  ];

  let currentSlide = 0;
  const infoText = document.querySelector('.info-text');
  const dots = document.querySelectorAll('.dot');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  function updateSlide() {
    infoText.textContent = descriptions[currentSlide];
    
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentSlide);
    });

    prevBtn.disabled = currentSlide === 0;
    nextBtn.disabled = currentSlide === descriptions.length - 1;
  }

  prevBtn.addEventListener('click', () => {
    if (currentSlide > 0) {
      currentSlide--;
      updateSlide();
    }
  });

  nextBtn.addEventListener('click', () => {
    if (currentSlide < descriptions.length - 1) {
      currentSlide++;
      updateSlide();
    }
  });

  dots.forEach((dot, idx) => {
    dot.addEventListener('click', () => {
      currentSlide = idx;
      updateSlide();
    });
  });
});
</script>

<!-- <?php get_footer(); ?> -->
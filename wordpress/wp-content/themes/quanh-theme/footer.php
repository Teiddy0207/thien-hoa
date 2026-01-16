<footer class="site-footer">
  <div class="footer-container">
    <!-- <p>&copy; <?php echo date('Y'); ?> Rivera Thiên Hoa. All rights reserved.</p> -->
  </div>
</footer>

<script>
// Hamburger Menu Toggle
(function() {
  'use strict';
  
  function initHamburgerMenu() {
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const mainMenu = document.getElementById('mainMenu');
    
    if (!hamburgerMenu || !mainMenu) {
      return;
    }

    // Toggle menu khi click hamburger
    hamburgerMenu.addEventListener('click', function(e) {
      e.stopPropagation(); // Ngăn event bubble
      e.preventDefault();
      hamburgerMenu.classList.toggle('active');
      mainMenu.classList.toggle('active');
    });

    // Đóng menu khi click vào menu item
    const menuLinks = mainMenu.querySelectorAll('a');
    menuLinks.forEach(function(link) {
      link.addEventListener('click', function() {
        hamburgerMenu.classList.remove('active');
        mainMenu.classList.remove('active');
      });
    });

    // Đóng menu khi click ra ngoài (nhưng không chặn click vào hamburger)
    document.addEventListener('click', function(event) {
      // Kiểm tra nếu click vào hamburger thì không làm gì (đã xử lý ở trên)
      if (hamburgerMenu.contains(event.target)) {
        return;
      }
      
      // Nếu menu đang mở và click ra ngoài menu
      if (mainMenu.classList.contains('active') && !mainMenu.contains(event.target)) {
        hamburgerMenu.classList.remove('active');
        mainMenu.classList.remove('active');
      }
    });

    // Đóng menu khi resize về desktop
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        hamburgerMenu.classList.remove('active');
        mainMenu.classList.remove('active');
      }
    });
  }

  // Chạy khi DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHamburgerMenu);
  } else {
    initHamburgerMenu();
  }
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
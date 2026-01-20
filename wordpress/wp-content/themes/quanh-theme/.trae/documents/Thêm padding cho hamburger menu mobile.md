## Hiện trạng
- Hamburger nằm trong header ([header.php](file:///wsl.localhost/Ubuntu/home/quanhenspire/wordpress-docker/wordpress/wp-content/themes/quanh-theme/header.php)) và đang bị giới hạn hit-area vì `.hamburger-menu` có `width/height: 30px` và `padding: 0` trong CSS.
- Responsive breakpoint chính cho mobile là `@media (max-width: 768px)` và `@media (max-width: 480px)` trong [style.css](file:///wsl.localhost/Ubuntu/home/quanhenspire/wordpress-docker/wordpress/wp-content/themes/quanh-theme/style.css).

## Cách sẽ làm
1. Sửa [style.css](file:///wsl.localhost/Ubuntu/home/quanhenspire/wordpress-docker/wordpress/wp-content/themes/quanh-theme/style.css):
   - Trong `@media (max-width: 768px)`, override `.hamburger-menu` để tăng padding và kích thước nút (hit-area) lên chuẩn dễ bấm (vd 44×44), đồng thời set độ rộng các thanh (span) cố định (vd 24px) để icon không bị “dài” quá.
   - Trong `@media (max-width: 480px)`, tinh chỉnh nhẹ (vd span 22px hoặc giữ nguyên) để vừa mắt trên màn nhỏ.
2. Giữ nguyên logic mở/đóng menu (JS đang toggle class `active`), chỉ đảm bảo thay đổi CSS không làm lệch animation của icon.

## Xác minh
- Kiểm tra ở chiều rộng ~768px và ~375px: hamburger không dính sát mép, bấm dễ hơn, menu xổ xuống vẫn đúng vị trí `top`.
- Test thao tác: mở/đóng menu nhiều lần, scroll trang, và resize qua lại >768px để chắc chắn class reset vẫn hoạt động.

## Phạm vi file dự kiến thay đổi
- [style.css](file:///wsl.localhost/Ubuntu/home/quanhenspire/wordpress-docker/wordpress/wp-content/themes/quanh-theme/style.css) (chỉ phần CSS responsive của hamburger).
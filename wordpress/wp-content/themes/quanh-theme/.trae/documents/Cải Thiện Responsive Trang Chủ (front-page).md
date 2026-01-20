## Hiện trạng (đã rà soát)
- Trang chủ hiện tại chỉ render 1 khối hero trong [front-page.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\front-page.php); mọi phần còn lại đến từ header/footer chung.
- Anchor CTA/Contact đều trỏ `#lien-he` trong [front-page.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\front-page.php) và [header.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\header.php) nhưng trang chủ không có phần tử `id="lien-he"` → nguy cơ click không cuộn/không đúng UX.
- [header.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\header.php) đặt Google Fonts `<link>` trước `<head>` (HTML không hợp lệ) và thiếu `wp_body_open()`.
- Menu đang bị bọc thêm `<ul class="menu">` bên ngoài `wp_nav_menu()` → dễ sinh markup lồng UL không mong muốn, làm CSS responsive khó ổn định.
- Hamburger JS đang inline trong [footer.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\footer.php) → kém cache, khó tối ưu hiệu năng.
- [style.css](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\style.css) có responsive rải rác nhiều breakpoint; hero dùng mix flex + absolute ở 1024px, dễ “vỡ” theo nhiều tỉ lệ màn hình.

## Mục tiêu cải thiện (theo yêu cầu)
- Responsive cân đối trên mobile/tablet/desktop: typographic scale hợp lý, spacing nhất quán, không tràn ngang, không bị che bởi header/floating buttons.
- UX: thứ tự ưu tiên rõ (hero → CTA), tap target tối thiểu ~44px, menu mobile dễ thao tác, anchor/CTA hoạt động đúng.
- Performance: giảm layout shift, tránh nền `background-attachment: fixed` trên mobile (thường gây giật), đưa JS ra file riêng và enqueue.
- Cross-browser/device: xác thực hiển thị và tương tác ở Chrome/Edge/Firefox + iOS Safari.

## Kế hoạch triển khai (sẽ thực hiện sau khi bạn xác nhận)
### 1) Audit có hệ thống (layout + UX + performance)
- Lập ma trận viewport mẫu: 320/360/375/414, 768/820/834, 1024/1280/1440/1920.
- Kiểm tra: header che nội dung, hero căn trái/phải, ảnh hero có bị cắt, CTA có nằm “above the fold”, trạng thái mở menu có che/đè floating buttons.
- Đo nhanh: CLS/LCP bằng Lighthouse (tập trung hero + header + font loading).

### 2) Sửa cấu trúc HTML để ổn định responsive
- [header.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\header.php)
  - Đưa link Google Fonts vào đúng trong `<head>` hoặc chuyển sang enqueue trong `functions.php`.
  - Thêm `wp_body_open()` ngay sau `<body>`.
  - Chuẩn hoá `wp_nav_menu()` (bỏ `<ul>` bọc ngoài; dùng `menu_class`/`container => false`) để markup ổn định.
  - Bổ sung thuộc tính a11y cho hamburger: `aria-controls`, `aria-expanded`.
- [front-page.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\front-page.php)
  - Bổ sung section liên hệ tối thiểu có `id="lien-he"` để CTA hoạt động (hoặc đổi CTA sang link sang trang liên hệ nếu cần).

### 3) Tối ưu CSS responsive theo hướng “fluid + ít breakpoint”
- [style.css](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\style.css)
  - Thêm hệ biến CSS (spacing/font/container) và dùng `clamp()` cho cỡ chữ/spacing chính.
  - Chuẩn hoá breakpoints trọng tâm (ví dụ 1200/1024/768/480) và gom các rule liên quan hero/header/contact về một cụm rõ ràng.
  - Hero: chuyển layout sang grid/flex thuần (giảm phụ thuộc absolute ở 1024px), đảm bảo ảnh không bị tràn/cắt, CTA luôn thấy và dễ bấm.
  - Header/menu mobile: tăng vùng bấm hamburger (padding/height), đảm bảo menu overlay có scroll nếu dài, khoá scroll body khi menu mở.
  - Floating contact buttons: tránh che menu/nội dung (ẩn/giảm ưu tiên khi menu mở; đảm bảo không che CTA trên mobile).
  - Performance: disable `background-attachment: fixed` trên mobile/tablet nếu gây giật.

### 4) Tối ưu JS và enqueue theo chuẩn WordPress
- [footer.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\footer.php)
  - Gỡ inline script hamburger.
- [functions.php](file:///\\wsl.localhost\Ubuntu\home\quanhenspire\wordpress-docker\wordpress\wp-content\themes\quanh-theme\functions.php)
  - Enqueue file JS mới (ví dụ `assets/js/hamburger-menu.js`) với `defer`/footer load.
  - (Nếu chọn) enqueue Google Fonts bằng `wp_enqueue_style` để head hợp lệ.
- Tạo file mới: `assets/js/hamburger-menu.js`
  - Toggle class + cập nhật `aria-expanded`, add/remove class `menu-open` lên `<body>` để CSS điều khiển scroll và ẩn contact buttons khi cần.

### 5) Bàn giao báo cáo + kiểm thử
- Tạo báo cáo Markdown: `.trae/documents/Responsive Front Page - Báo cáo.md`
  - Đánh giá hiện trạng (trước), danh sách điểm cần cải thiện, mô tả thay đổi đã làm, checklist test.
  - Kết quả kiểm thử theo ma trận thiết bị/trình duyệt (Chrome/Edge/Firefox + iOS Safari), kèm các ghi chú issue nếu có.

## Phạm vi thay đổi dự kiến (files)
- Sửa: front-page.php, header.php, footer.php, functions.php, style.css
- Thêm: assets/js/hamburger-menu.js, .trae/documents/Responsive Front Page - Báo cáo.md

## Tiêu chí chấp nhận
- Không tràn ngang ở mọi breakpoint; hero cân đối và CTA dễ bấm.
- Anchor/CTA `#lien-he` hoạt động đúng trên trang chủ.
- Menu mobile mở/đóng mượt, không bị contact buttons che; tap target đủ lớn.
- HTML head/body theo chuẩn WP (fonts/head hợp lệ, có `wp_body_open`).
- Báo cáo + kết quả test đầy đủ như yêu cầu.

Xác nhận giúp mình để bắt đầu thực hiện các thay đổi theo kế hoạch trên.
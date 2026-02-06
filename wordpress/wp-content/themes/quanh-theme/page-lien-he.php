<?php
/*
 Template Name: Liên Hệ Rivera
 */

get_header(); 
?>
<style>
    /* Background trang liên hệ - ưu tiên cao */
    body {
      background: url('<?php echo get_template_directory_uri(); ?>/assets/Lienhebgnew.png') !important;
      background-attachment: fixed;
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
    }
</style>
<style>
    /* Tổng thể section */
    .contact-rivera-section {
        color: #fff;
        padding: 150px 40px 60px;
        margin-top: 70px;
        font-family: 'Segoe UI', sans-serif;
        min-height: 80vh;
        display: flex;
        align-items: center;
        width: 100%;
        box-sizing: border-box;
    }

    .rv-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 170px;
        width: 100%;
        box-sizing: border-box;
    }

    .rv-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
    }

    /* Cột bên trái: Thông tin */
    .rv-col-info {
        flex: 1 1 420px;
        min-width: 0;
        padding: 32px 24px 32px 0;
        margin-bottom: 0;
    }

    .rv-info-title {
        font-family: 'Be Vietnam Pro', Arial, sans-serif;
        font-weight: 400;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 30px;
        color: #ffffff;
    }

    .rv-info-item {
        margin-bottom: 25px;
    }

    .rv-info-label {
        font-family: 'Be Vietnam Pro', Arial, sans-serif;
        font-weight: 500;
        display: block;
        margin-bottom: 5px;
        font-size: 16px;
        color: #ffffff;
    }

    .rv-info-text {
        font-family: 'Be Vietnam Pro', Arial, sans-serif;
        font-weight: 300;
        font-size: 15px;
        line-height: 1.6;
        color: #ffffff;
    }

    .rv-icon {
        margin-right: 10px;
        color: #d4af37;
    }

    /* Cột bên phải: Form */
    .rv-col-form {
        flex: 0 0 540px;
        min-width: 0;
        max-width: 100%;
        background: rgba(0, 30, 60, 0.6);
        padding: 48px 44px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .rv-form-title {
        text-align: center;
        font-size: 28px;
        text-transform: uppercase;
        margin-bottom: 5px;
        font-weight: bold;
        color: #fff;
    }

    .rv-form-subtitle {
        text-align: center;
        font-size: 14px;
        margin-bottom: 30px;
        color: #ccc;
        font-weight: 300;
    }

    .rv-input-group {
        margin-bottom: 20px;
    }

    .rv-input {
        width: 100%;
        padding: 12px 0;
        background: transparent;
        border: none;
        border-bottom: 1px solid #5a6b7c;
        color: #fff;
        font-size: 15px;
        outline: none;
        transition: border-color 0.3s;
    }

    .rv-input:focus {
        border-bottom-color: #d4af37;
    }

    .rv-input::placeholder {
        color: #7a8b9c;
    }

    .rv-form-row-dual {
        display: flex;
        gap: 20px;
    }
    
    .rv-form-row-dual .rv-input-group {
        flex: 1;
    }

    .rv-submit-btn {
        display: inline-block;
        /* justify-content: flex-end; */
        margin-top: 10px;
        padding: 12px 30px;
        background: transparent;
        border: 1px solid #d4af37;
        color: #ffffff;
        font-weight: bold;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        font-size: 16px;
    }

    .rv-submit-btn:hover {
        background: #d4af37;
        color: #000;
    }

    .rv-note {
        margin-top: 20px;
        font-size: 12px;
        font-style: italic;
        color: #7a8b9c;
        text-align: center;
    }
    .rv-info-icon-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Footer với disclaimer */
    .rv-footer-with-wave {
        position: relative;
        margin-top: 40px;
        padding: 20px 0 0;
        min-height: 200px;
        background-position: center bottom;
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    .rv-disclaimer {
        position: absolute;
        bottom: -17px;
        left: 0;
        z-index: 1;
        font-family: 'Be Vietnam Pro', Arial, sans-serif;
        font-weight: 300;
        font-style: italic;
        font-size: 11px;
        color: rgba(255,255,255,0.85);
        text-align: left;
        line-height: 1.6;
    }

    /* Responsive cho tablet */
    @media (max-width: 1024px) {
        .contact-rivera-section {
            padding: 130px 24px 50px;
        }
        .rv-container {
            padding: 0 24px;
        }
        .rv-info-title {
            text-align: center;
            margin-bottom: 28px;
        }
        .rv-row {
            flex-direction: column;
            align-items: center;
            gap: 36px;
        }
        .rv-col-info {
            flex: 1 1 auto;
            width: 100%;
            max-width: 540px;
            padding: 0;
            margin: 0 auto;
            text-align: center;
        }
        .rv-col-info .rv-info-icon-wrapper {
            justify-content: center;
        }
        .rv-col-form {
            flex: 1 1 auto;
            width: 100%;
            max-width: 540px;
            margin: 0 auto;
        }
        .rv-footer-with-wave {
            margin-top: 36px;
            padding: 20px 0 16px;
        }
    }

    /* Responsive cho iPad Pro / tablet ngang (1366x1024) */
    @media (max-width: 1400px) {
        .rv-container {
            padding: 0 60px;
        }
        .rv-row {
            gap: 32px;
            justify-content: center;
        }
        .rv-col-info {
            flex: 1 1 380px;
            max-width: 480px;
        }
        .rv-col-form {
            flex: 0 1 440px;
            max-width: 480px;
        }
    }

    /* Responsive cho mobile */
    @media (max-width: 768px) {
        .contact-rivera-section {
            padding: 120px 20px 40px;
            margin-top: 70px;
        }
        .rv-container {
            padding: 0 16px;
        }
        .rv-row {
            flex-direction: column;
            gap: 24px;
        }
        .rv-col-info {
            margin-bottom: 24px;
        }
        .rv-col-form {
            flex: 1 1 auto;
            width: 100%;
            padding: 24px 20px;
        }
        .rv-form-row-dual {
            flex-direction: column;
            gap: 0;
        }
        .rv-footer-with-wave {
            margin-top: 32px;
            padding: 20px 0 16px;
        }
    }

    @media (max-width: 480px) {
        .contact-rivera-section {
            padding: 100px 16px 30px;
        }
        .rv-container {
            padding: 0 12px;
        }
        .rv-footer-with-wave {
            margin-top: 24px;
            padding: 16px 0 12px;
        }
        .rv-disclaimer {
            font-size: 10px;
        }
    }
</style>
<section class="contact-rivera-section">
    <div class="rv-container">
                                <div class="rv-info-title">THÔNG TIN LIÊN HỆ:</div>

        <div class="rv-row">
            

            <div class="rv-col-info">

                <div class="rv-info-item">


                <div class="rv-info-icon-wrapper">
                    <div class="rv-info-icon">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/tongquan6.png" alt="">
                    </div>
                    <div>
                    <span class="rv-info-label">Địa chỉ dự án:</span>
                    <div class="rv-info-text">
                        Xã Tân Dương, Tỉnh Đồng Tháp.<br>
                    </div>
                    </div>
                    </div>

                </div>

                <div class="rv-info-item">
                    <div class="rv-info-icon-wrapper">
                 <div class="rv-info-icon">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/calllienhe.png" alt="">
                    </div>

                    <div>
                    <span class="rv-info-label">Hotline CSKH:</span>
                    <div class="rv-info-text">
                        0909.xxx.xxx (Liên hệ trực tiếp)
                    </div>
</div>
</div>
                </div>

                <div class="rv-info-item">
                    <span class="rv-info-label">TÊN PHÁP LÝ:</span>
                    <div class="rv-info-text">
                        CÔNG TY TNHH ĐẦU TƯ RIVERA
                    </div>
                </div>

                <div class="rv-info-item">
                    <span class="rv-info-label">VĂN PHÒNG BÁN HÀNG:</span>
                    <div class="rv-info-text">
                        Số 123, Đường Hùng Vương, TP. Sa Đéc
                    </div>
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


<?php
/*
 Template Name: Liên Hệ Rivera
 */

get_header(); 
?>

<style>
    /* Tổng thể section */
    .contact-rivera-section {
        /* background: linear-gradient(135deg, #021226 0%, #062a4d 100%); */
        color: #fff;
        padding: 150px 0 60px;
        margin-top: 70px;
        font-family: 'Segoe UI', sans-serif;
        min-height: 80vh; /* Đảm bảo full màn hình */
        display: flex;
        align-items: center;
    }

    .rv-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        width: 100%;
    }

    .rv-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
    }

    /* Cột bên trái: Thông tin */
    .rv-col-info {
        flex: 1;
        min-width: 300px;
        padding-right: 40px;
        margin-bottom: 40px;
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
        flex: 0 0 500px;
        max-width: 100%;
        background: rgba(0, 30, 60, 0.6); /* Nền tối trong suốt */
        padding: 40px;
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

    /* Responsive cho mobile */
    @media (max-width: 768px) {
        .contact-rivera-section {
            padding: 120px 0 40px;
            margin-top: 70px;
        }
        
        .rv-row {
            flex-direction: column;
        }
        .rv-col-form {
            flex: 1;
            width: 100%;
            padding: 20px;
        }
        .rv-form-row-dual {
            flex-direction: column;
            gap: 0;
        }
    }
    
    @media (max-width: 480px) {
        .contact-rivera-section {
            padding: 100px 0 30px;
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
        
        <div style="margin-top: 40px; font-family: 'Be Vietnam Pro', Arial, sans-serif; font-weight: 300; font-style: italic; font-size: 11px; color: #5a6b7c; text-align: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            * Thông tin, hình ảnh, các tiện ích trên website chỉ mang tính chất tương đối và có thể được điều chỉnh theo quyết định của Chủ đầu tư tại từng thời điểm.
        </div>
    </div>
</section>


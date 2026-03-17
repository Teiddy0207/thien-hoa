<?php
/**
 * Quản lý ảnh và video hiển thị trên page Thư viện (meta box trong WordPress admin).
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

define( 'QUANH_LIBRARY_META_GALLERY', '_library_gallery_ids' );
define( 'QUANH_LIBRARY_META_VIDEOS', '_library_videos' );

/**
 * Lấy danh sách ID ảnh thư viện (ưu tiên meta, fallback attached media).
 */
function quanh_get_library_gallery_ids( $page_id = null ) {
  if ( ! $page_id ) {
    $pages = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-thu-vien.php' ) );
    $page_id = ! empty( $pages[0] ) ? $pages[0]->ID : 0;
  }
  if ( ! $page_id ) {
    return array();
  }
  $ids = get_post_meta( $page_id, QUANH_LIBRARY_META_GALLERY, true );
  if ( is_array( $ids ) && ! empty( $ids ) ) {
    return array_map( 'intval', $ids );
  }
  $attachments = get_attached_media( 'image', $page_id );
  return array_values( array_map( function ( $a ) { return (int) $a->ID; }, $attachments ) );
}

/**
 * Lấy danh sách video thư viện (array of ['url' => '', 'title' => '']).
 */
function quanh_get_library_videos( $page_id = null ) {
  if ( ! $page_id ) {
    $pages = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-thu-vien.php' ) );
    $page_id = ! empty( $pages[0] ) ? $pages[0]->ID : 0;
  }
  if ( ! $page_id ) {
    return array();
  }
  $videos = get_post_meta( $page_id, QUANH_LIBRARY_META_VIDEOS, true );
  if ( is_array( $videos ) ) {
    return $videos;
  }
  return array();
}

/**
 * Đăng ký meta box chỉ với page dùng template Thư Viện.
 */
function quanh_library_register_meta_boxes() {
  $screen = get_current_screen();
  if ( ! $screen || $screen->post_type !== 'page' ) {
    return;
  }
  $post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : ( isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0 );
  if ( $post_id && get_page_template_slug( $post_id ) === 'page-thu-vien.php' ) {
    add_meta_box(
      'quanh_library_gallery',
      __( 'Ảnh Thư viện', 'quanh-theme' ),
      'quanh_library_gallery_meta_box',
      'page',
      'normal',
      'high'
    );
    add_meta_box(
      'quanh_library_videos',
      __( 'Video Thư viện', 'quanh-theme' ),
      'quanh_library_videos_meta_box',
      'page',
      'normal',
      'default'
    );
  }
}
add_action( 'add_meta_boxes', 'quanh_library_register_meta_boxes' );

/**
 * Thêm menu "Quản lý Thư viện" trong admin sidebar. Luôn dùng một callback để tránh trang trắng.
 */
function quanh_library_admin_menu() {
  add_theme_page(
    'Quản lý Thư viện',
    'Quản lý Thư viện',
    'edit_pages',
    'quanh-library',
    'quanh_library_admin_page_render'
  );
}
add_action( 'admin_menu', 'quanh_library_admin_menu', 20 );

/**
 * Nội dung trang Quản lý Thư viện: có trang Thư viện thì chuyển hướng (bằng JS), không thì hiện form tạo trang.
 */
function quanh_library_admin_page_render() {
  $pages = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-thu-vien.php', 'number' => 1 ) );
  $page_id = ! empty( $pages[0] ) ? (int) $pages[0]->ID : 0;

  if ( $page_id ) {
    $edit_url = admin_url( 'post.php?post=' . $page_id . '&action=edit' );
    ?>
    <div class="wrap">
      <h1>Quản lý Thư viện</h1>
      <p>Đang chuyển tới trang chỉnh sửa Thư viện…</p>
      <p><a href="<?php echo esc_url( $edit_url ); ?>" class="button button-primary">Vào chỉnh sửa trang Thư viện</a></p>
      <script>window.location.href = <?php echo json_encode( $edit_url ); ?>;</script>
    </div>
    <?php
    return;
  }

  quanh_library_admin_page_no_page();
}

/**
 * Tạo trang Thư viện (template sẵn) khi bấm nút "Tạo trang Thư viện ngay".
 */
function quanh_library_maybe_create_page() {
  if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'quanh-library' ) {
    return;
  }
  if ( ! isset( $_GET['quanh_create_library'] ) || $_GET['quanh_create_library'] !== '1' ) {
    return;
  }
  if ( ! current_user_can( 'edit_pages' ) || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'quanh_create_library_page' ) ) {
    return;
  }
  $existing = get_pages( array( 'meta_key' => '_wp_page_template', 'meta_value' => 'page-thu-vien.php', 'number' => 1 ) );
  if ( ! empty( $existing[0] ) ) {
    wp_safe_redirect( admin_url( 'post.php?post=' . (int) $existing[0]->ID . '&action=edit' ) );
    exit;
  }
  $page_id = wp_insert_post( array(
    'post_title'   => 'Thư viện',
    'post_name'    => 'thu-vien',
    'post_status'  => 'publish',
    'post_type'    => 'page',
    'post_author'  => get_current_user_id(),
  ), true );
  if ( ! is_wp_error( $page_id ) && $page_id ) {
    update_post_meta( $page_id, '_wp_page_template', 'page-thu-vien.php' );
    wp_safe_redirect( admin_url( 'post.php?post=' . $page_id . '&action=edit' ) );
    exit;
  }
}
add_action( 'admin_init', 'quanh_library_maybe_create_page' );

function quanh_library_admin_page_no_page() {
  $create_url = add_query_arg( array(
    'quanh_create_library' => '1',
    '_wpnonce'             => wp_create_nonce( 'quanh_create_library_page' ),
  ), admin_url( 'themes.php?page=quanh-library' ) );
  ?>
  <div class="wrap">
    <h1>Quản lý Thư viện</h1>
    <p>Chưa có trang nào dùng template <strong>Thư Viện</strong>. Tạo trang rồi thêm ảnh/video tại đó.</p>
    <p>
      <a href="<?php echo esc_url( $create_url ); ?>" class="button button-primary button-hero">Tạo trang Thư viện ngay</a>
    </p>
    <p>Sau khi tạo, bạn sẽ được chuyển tới trang chỉnh sửa — kéo xuống sẽ thấy 2 khung <strong>Ảnh Thư viện</strong> và <strong>Video Thư viện</strong>. Thêm ảnh/video xong bấm <strong>Cập nhật</strong>.</p>
    <hr style="margin: 20px 0;">
    <p><strong>Hoặc làm tay:</strong> <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">Trang</a> → Chỉnh sửa trang có tên Thư viện (hoặc tạo mới) → bên phải chọn <strong>Template: Thư Viện</strong> → Cập nhật. Rồi vào lại <strong>Giao diện → Quản lý Thư viện</strong>.</p>
  </div>
  <?php
}

function quanh_library_gallery_meta_box( $post ) {
  wp_nonce_field( 'quanh_library_save', 'quanh_library_nonce' );
  $ids = get_post_meta( $post->ID, QUANH_LIBRARY_META_GALLERY, true );
  if ( ! is_array( $ids ) ) {
    $ids = array();
  }
  $ids = array_map( 'intval', array_filter( $ids ) );
  ?>
  <p class="description" style="margin-bottom:10px;"><strong>Ảnh bạn chọn ở đây sẽ hiển thị trên trang Thư viện (và section Thư viện trang chủ).</strong> Bấm "Thêm ảnh" → chọn ảnh từ Thư viện Media (hoặc tải ảnh mới lên trước ở Media). Nếu không thêm ảnh nào, trang sẽ dùng ảnh mặc định.</p>
  <input type="hidden" name="quanh_library_gallery_ids" id="quanh_library_gallery_ids" value="<?php echo esc_attr( wp_json_encode( $ids ) ); ?>">
  <div id="quanh-library-gallery-list" style="display:flex;flex-wrap:wrap;gap:8px;margin:10px 0;"></div>
  <p>
    <button type="button" class="button button-primary" id="quanh-library-add-images">Thêm ảnh</button>
    <button type="button" class="button" id="quanh-library-clear-images">Xóa hết ảnh</button>
  </p>
  <p class="description">Nhớ bấm <strong>Cập nhật</strong> (hoặc Đăng) ở trên sau khi thêm/xóa ảnh.</p>
  <script>
  (function(){
    var input = document.getElementById('quanh_library_gallery_ids');
    var list = document.getElementById('quanh-library-gallery-list');
    var ids = input && input.value ? JSON.parse(input.value) : [];
    function render(){
      list.innerHTML = '';
      (ids || []).forEach(function(id){
        var wrap = document.createElement('div');
        wrap.style.cssText = 'position:relative;width:80px;height:80px;';
        var img = document.createElement('img');
        img.src = '<?php echo esc_url( admin_url( 'admin-ajax.php?action=quanh_library_thumb&id=' ) ); ?>' + id;
        img.style.cssText = 'width:80px;height:80px;object-fit:cover;border-radius:4px;';
        img.onerror = function(){ this.src = ''; this.style.background = '#ddd'; };
        var rm = document.createElement('button');
        rm.type = 'button';
        rm.className = 'button';
        rm.textContent = '×';
        rm.style.cssText = 'position:absolute;top:2px;right:2px;width:22px;height:22px;padding:0;line-height:20px;font-size:18px;min-width:22px;';
        rm.onclick = function(){ ids = ids.filter(function(i){ return i !== id; }); input.value = JSON.stringify(ids); render(); };
        wrap.appendChild(img);
        wrap.appendChild(rm);
        list.appendChild(wrap);
      });
    }
    function openMedia(){
      if (typeof wp === 'undefined' || !wp.media) return;
      var frame = wp.media({ multiple: true, library: { type: 'image' } });
      frame.on('select', function(){
        var selection = frame.state().get('selection');
        selection.forEach(function(att){ att = att.toJSON(); if(att.id) ids.push(att.id); });
        ids = ids.filter(function(v,i,a){ return a.indexOf(v)===i; });
        input.value = JSON.stringify(ids);
        render();
      });
      frame.open();
    }
    document.getElementById('quanh-library-add-images').onclick = openMedia;
    document.getElementById('quanh-library-clear-images').onclick = function(){ ids = []; input.value = '[]'; render(); };
    render();
  })();
  </script>
  <?php
}

function quanh_library_videos_meta_box( $post ) {
  $videos = get_post_meta( $post->ID, QUANH_LIBRARY_META_VIDEOS, true );
  if ( ! is_array( $videos ) ) {
    $videos = array();
  }
  ?>
  <p class="description"><strong>Video bạn thêm ở đây sẽ hiển thị tại tab Video trên trang Thư viện.</strong> Dán link YouTube hoặc Vimeo (vd: https://www.youtube.com/watch?v=xxx). Bấm <strong>Cập nhật</strong> sau khi thêm.</p>
  <div id="quanh-library-videos-wrap">
    <?php
    foreach ( $videos as $i => $v ) {
      $url = is_array( $v ) ? ( isset( $v['url'] ) ? $v['url'] : '' ) : (string) $v;
      $title = is_array( $v ) && isset( $v['title'] ) ? $v['title'] : '';
      ?>
      <p class="quanh-video-row" style="margin-bottom:8px;">
        <input type="text" name="quanh_library_videos_url[]" value="<?php echo esc_attr( $url ); ?>" placeholder="https://www.youtube.com/watch?v=..." style="width:70%;">
        <input type="text" name="quanh_library_videos_title[]" value="<?php echo esc_attr( $title ); ?>" placeholder="Tiêu đề (tùy chọn)" style="width:20%;margin-left:4px;">
        <button type="button" class="button quanh-remove-video">Xóa</button>
      </p>
      <?php
    }
    ?>
  </div>
  <p><button type="button" class="button" id="quanh-library-add-video">Thêm video</button></p>
  <script>
  (function(){
    var wrap = document.getElementById('quanh-library-videos-wrap');
    document.getElementById('quanh-library-add-video').onclick = function(){
      var p = document.createElement('p');
      p.className = 'quanh-video-row';
      p.style.marginBottom = '8px';
      p.innerHTML = '<input type="text" name="quanh_library_videos_url[]" placeholder="https://www.youtube.com/watch?v=..." style="width:70%"> <input type="text" name="quanh_library_videos_title[]" placeholder="Tiêu đề (tùy chọn)" style="width:20%;margin-left:4px"> <button type="button" class="button quanh-remove-video">Xóa</button>';
      p.querySelector('.quanh-remove-video').onclick = function(){ p.remove(); };
      wrap.appendChild(p);
    };
    wrap.querySelectorAll('.quanh-remove-video').forEach(function(btn){
      btn.onclick = function(){ btn.closest('.quanh-video-row').remove(); };
    });
  })();
  </script>
  <?php
}

function quanh_library_save_meta( $post_id ) {
  if ( ! isset( $_POST['quanh_library_nonce'] ) || ! wp_verify_nonce( $_POST['quanh_library_nonce'], 'quanh_library_save' ) ) {
    return;
  }
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
    return;
  }
  if ( get_page_template_slug( $post_id ) !== 'page-thu-vien.php' ) {
    return;
  }

  if ( isset( $_POST['quanh_library_gallery_ids'] ) ) {
    $raw = stripslashes( $_POST['quanh_library_gallery_ids'] );
    $ids = json_decode( $raw, true );
    if ( is_array( $ids ) ) {
      update_post_meta( $post_id, QUANH_LIBRARY_META_GALLERY, array_map( 'intval', array_filter( $ids ) ) );
    }
  }

  if ( isset( $_POST['quanh_library_videos_url'] ) && is_array( $_POST['quanh_library_videos_url'] ) ) {
    $urls = array_map( 'esc_url_raw', array_map( 'stripslashes', $_POST['quanh_library_videos_url'] ) );
    $titles = isset( $_POST['quanh_library_videos_title'] ) && is_array( $_POST['quanh_library_videos_title'] ) ? array_map( 'sanitize_text_field', array_map( 'stripslashes', $_POST['quanh_library_videos_title'] ) ) : array();
    $videos = array();
    foreach ( $urls as $i => $url ) {
      if ( $url !== '' ) {
        $videos[] = array( 'url' => $url, 'title' => isset( $titles[ $i ] ) ? $titles[ $i ] : '' );
      }
    }
    update_post_meta( $post_id, QUANH_LIBRARY_META_VIDEOS, $videos );
  }
}
add_action( 'save_post_page', 'quanh_library_save_meta', 10, 1 );

/**
 * AJAX trả về thumbnail cho admin (để hiển thị trong meta box).
 */
function quanh_library_ajax_thumb() {
  $id = isset( $_GET['id'] ) ? (int) $_GET['id'] : 0;
  if ( ! $id || ! current_user_can( 'upload_files' ) ) {
    status_header( 404 );
    exit;
  }
  $url = wp_get_attachment_image_url( $id, 'thumbnail' );
  if ( ! $url ) {
    status_header( 404 );
    exit;
  }
  wp_redirect( $url );
  exit;
}
add_action( 'wp_ajax_quanh_library_thumb', 'quanh_library_ajax_thumb' );

/**
 * Enqueue script/style cho meta box (media modal).
 */
function quanh_library_admin_scripts( $hook ) {
  if ( $hook !== 'post.php' && $hook !== 'post-new.php' ) {
    return;
  }
  $screen = get_current_screen();
  if ( ! $screen || $screen->post_type !== 'page' ) {
    return;
  }
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'quanh_library_admin_scripts' );

<div class="col-md-9 content">

    <!-- bài 7 _ file này để hiển thị nội dung của các file templates  khi có giá trị của tham số tab -->
    <?php
 
    // Phân trang content
    // Lấy tham số tab//tham số này chính là tên của các file ở trong templates có xuất hiện trong file .htaccess//lấy từ GET nè
    if (isset($_GET['tab']))
    {
        $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
    }
    else
    {
        $tab = '';
    }
 
    // Nếu có tham số tab
    if ($tab != '')
    {
        // Hiển thị template chức năng theo tham số tab
        if ($tab == 'profile')
        {
            // Hiển thị template hồ sơ cá nhân
            require_once 'templates/profile.php';
        }
        else if ($tab == 'posts')
        {
            // Hiển thị template bài viết
            require_once 'templates/posts.php';
        }
        else if ($tab == 'photos')
        {
            // Hiển thị template hình ảnh
            require_once 'templates/photos.php';
        }
        else if ($tab == 'categories')
        {
            // Hiển thị template chuyên mục
            require_once 'templates/categories.php';
        }
        else if ($tab == 'setting')
        {
            // Hiển thị template cài đặt chung
            require_once 'templates/setting.php';
        }
    }
    // Ngược lại không có tham số tab
    else
    {
        // Hiển thị template bảng điều khiển
        require_once 'templates/dashboard.php';
    }
 
    ?>
</div><!-- div.content -->
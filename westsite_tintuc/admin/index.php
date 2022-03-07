<?php
 // lấy kết quả từ init
// Require database & thông tin chung
require_once 'core/init.php';
 

// Require header//hiển thị đầu_thanh ngang của index
require_once 'includes/header.php';
 
//check login
// Nếu đăng nhập
if ($user)
{
 

 //bài 7
// Hiển thị sidebar//thanh bên
require_once 'templates/sidebar.php';
 
// Hiển thị content//nội dung của các file templates khi ta click vào các mục tương ứng
require_once 'templates/content.php';


}

// Nếu không đăng nhập
else
{
    // Hiển thị form đăng nhập
    require_once 'templates/signin.php';
}




// Require footer
 require_once 'includes/footer.php';
 
?>
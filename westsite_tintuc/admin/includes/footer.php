 
<!-- file này chứa các thư viện js và tạo class active  cho các thẻ chứa thẻ a active khi ta thao tác với chúng -->

 <!-- Liên kết thư viện jQuery Form -->
 <script src="<?php echo $_DOMAIN; ?>js/jquery.form.min.js"></script>  


 <!-- Liên kết thư viện hàm xử lý form _bài 6-->
<script src="<?php echo $_DOMAIN; ?>js/form.js"></script>

<!-- bài 13 _thư viện ck editor-->

<!-- Liên kết thư viện CKEditor -->
<script src="<?php echo $_DOMAIN; ?>ckeditor/ckeditor.js"></script>
<script>
    config = {};
    config.entities_latin = false;
    config.language = "vi";
    CKEDITOR.replace("body_edit_post", config);
</script>



<!-- bài 7 -->
<?php
 



// Active sidebar

// Lấy tham số tab//nếu có biến tab và biến tab có giá trị ko phải là rỗng
if (isset($_GET['tab']))
{

	// xử lý giá trị được lấy từ phương thức GET và POST _ học mãi rồi
    $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
}

else
{
    $tab = '';
}
 


// Nếu có tham số tab///kiểm tra giá trị của $tab
if ($tab != '')
{
    // Tháo active của Bảng điều khiển

//    [ .eq(n): Xác định thành phần ở vị trí thứ n.
// Trong đó n có thể mang giá trị âm.
// .eq(0) ứng với thành phần ở vị trí đầu tiên.
// .eq(-1) ứng với thành phần ở vị trí cuối cùng. ]
	//ở đây là từ lấy từ thẻ có class=sidebar trong thẻ đó có thẻ ul thẻ ul này lại bao các thẻ a



// + Tác dụng:

// Thêm class active vào chuyên mục trên menu khi truy cập các bài viết thuộc chuyên mục đó có tác dụng làm nổi bật chuyên mục đó giúp người đọc biết được đang đọc bài thuộc chuyên mục nào và họ có thể tìm kiếm bài thuộc chuyên mục đó.
	//vứa active khỏi thanh sidebar
    echo '<script>$(".sidebar ul a:eq(1)").removeClass("active");</script>';


    // Active theo giá trị của tham số tab

    if ($tab == 'profile')
    {
    	//thêm actve theo giá trị của $tab
        echo '<script>$(".sidebar ul a:eq(2)").addClass("active");</script>';
    }
    else if ($tab == 'posts')
    {
        echo '<script>$(".sidebar ul a:eq(3)").addClass("active");</script>';
    }
    else if ($tab == 'photos')
    {
        echo '<script>$(".sidebar ul a:eq(4)").addClass("active");</script>';
    }
    else if ($tab == 'categories')
    {
        echo '<script>$(".sidebar ul a:eq(5)").addClass("active");</script>';
    }
    else if ($tab == 'setting')
    {
        echo '<script>$(".sidebar ul a:eq(6)").addClass("active");</script>';
    }
}
 
?>
</body>
</html>
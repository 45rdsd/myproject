
<!-- file này để hiển thị giao diện thanh bên và các link a ẩn chứa phía nó tùy theo dữ liệu đã có -->

<div class="col-md-3 sidebar">

<!-- thanh bên bài 7 -->

    <ul class="list-group">

        <li class="list-group-item">
<!-- thẻ div chứa ảnh và thông tin tài khoản -->
            <div class="media">





                <a class="pull-left">

                    <img class="media-object" src="

                    <?php
                    // Thuộc tính src -> Đây là thuộc tính chứa đường dẫn trỏ đến file hình.
                        // URL ảnh đại diện tài khoản//nếu này rỗng
                        if ($data_user['url_avatar'] == '')
                        {
                            echo $_DOMAIN.'images/profile.png';//đường link dẫn đến nơi có ảnh// đường dẫn trỏ đến hình ảnh//thẻ a này ở vị trí 0 nhé
                        }
                        else//nếu khác rỗng//hiện url đó ra
                        {
                            echo $data_user['url_avatar'];
                        }
                    ?>

                    " alt="Ảnh đại diện của <?php echo $data_user['display_name']; ?>" width="64" height="64">
                </a>
                <!-- Thuộc tính alt
Đây là thuộc tính sẽ hiển thị trong trường hợp bạn truyền URL image bị sai, lúc này nó sẽ hiển thị đoạn text này thay vì hình ảnh.

 -->

 <!-- thẻ div hiển thị thông tin tài khoản cạnh ảnh -->
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $data_user['display_name']; ?></h4>
                    <!-- tên hiển thị bên cạnh ảnh -->

                    <?php
 
                    // Hiển thị cấp bậc tài khoản
                    // Nếu tài khoản là admin
                    if ($data_user['position'] == '1')
                    {
                        echo '<span class="label label-primary">Quản trị viên</span>';
                    }
                    // Ngược lại tài khoản là tác giả
                    else
                    {
                        echo '<span class="label label-success">Tác giả</span>';
                    }
 
                    ?>
                </div>






            </div>
        </li>


<!-- $_DOMAIN = 'http://localhost:8080/newspaper/admin/'; -->


        <a class="list-group-item active" href=" <?php echo $_DOMAIN; ?> ">
         
            <span class="glyphicon glyphicon-dashboard"></span> Bảng điều khiển
            <!-- vị trí 1 -->
        </a>


        <a class="list-group-item" href=" <?php echo $_DOMAIN; ?>profile">
            <!-- trỏ đến folder profile _ 2-->
            <span class="glyphicon glyphicon-user"></span> Hồ sơ cá nhân
        </a>


        <a class="list-group-item" href="<?php echo $_DOMAIN; ?>posts">
            <!-- hình như là trỏ đến folder posts _vị trí 3 -->
            <span class="glyphicon glyphicon-edit"></span> Bài viết
        </a>  


        <a class="list-group-item" href="<?php echo $_DOMAIN; ?>photos">
            <span class="glyphicon glyphicon-picture"></span> Hình ảnh
            <!-- trỏ đến folder photos _vị trí 4 -->
        </a>
<!-- đây là html xịn sò -->





        <?php
 
// còn đây là chèn html vào trong code php cho nên cấu trúc nó sẽ khác

        // Phân quyền sidebar
        // Nếu tài khoản là admin thì hiển thị 2 link này
        if ($data_user['position'] == '1')
        {
            // thẻ a lần lượt ở vị trí 5 và 6
            echo
            '
                <a class="list-group-item" href=" ' . $_DOMAIN . 'categories ">
                    <span class="glyphicon glyphicon-tag"></span> Chuyên mục
                </a>

                <a class="list-group-item" href=" ' . $_DOMAIN . 'setting ">
                    <span class="glyphicon glyphicon-cog"></span> Cài đặt chung
                </a>  
            ';
        }
 
        ?>



        <a class="list-group-item" href="<?php echo $_DOMAIN; ?>signout.php">
            <span class="glyphicon glyphicon-off"></span> Thoát
        </a>
    </ul><!-- ul.list-group -->
</div><!-- div.sidebar -->
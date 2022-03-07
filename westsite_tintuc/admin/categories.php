<?php
 
// Kết nối database và thông tin chung
require_once 'core/init.php';
 
// Nếu đăng nhập
if ($user) 
{
    // Nếu tồn tại POST action//nếu nhận được biến action và giá trị của nó
    if (isset($_POST['action']))
    {
        // Xử lý POST action
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));
 





        // Tải chuyên mục cha trong chức năng thêm chuyên mục///tạo data để hiển thị để hiện ra các chuyên mục cha sát vách (hiện ra các chuyên mục có thể làm cha)
        if ($action == 'load_add_parent_cate')//nếu giá trị của nó là chuỗi này//túc là cần xử lý value nhận được là $type_add_cate để tạo ra các thẻ option có các giá trị tương ứng
        {
            // Xử lý giá trị
            $type_add_cate = trim(addslashes(htmlspecialchars($_POST['type_add_cate'])));
 
            // Nếu type đúng dạng số//trả về True vì preg_match('/\D/', $type_add_cate)  chỉ trả về True nếu $type_add_cate là số
            // vì  chỉ cần tham số type=2 hoặc type=3 thì sẽ có chuyên mục mẹ
            if (!preg_match('/\D/', $type_add_cate)) 
            {
                $type_add_parent_cate = $type_add_cate - 1; // Lấy type parent
                $sql_get_cate = "SELECT * FROM categories WHERE type = '$type_add_parent_cate'";
                if ($db->num_rows($sql_get_cate))
                {
                    // In danh sách các chuyên mục cha(lấy tất cả data chuyên mục có type nhỏ hơn 1 vì đó là chuyên mục cha của nó) theo type parent
                    foreach ($db->fetch_assoc($sql_get_cate, 0) as $key => $data_cate)
                    {///từng data categories lấy được ta điều echo thẻ option//tất cả data trong thẻ option chính là nội dung html của thẻ select
                        echo '<option value="' . $data_cate['id_cate'] . '">' . $data_cate['label'] . '</option>';
                    }//như vậy ta sẽ có rất nhiều thẻ option 
                    //label là nhãn mác thôi mà
                }
                else
                {
                    echo '<option value="0">Hiện chưa có chuyên mục cha nào</option>';
                }
            }
        }





        // Tạo chuyên mục
        else if ($action == 'add_cate')
        {
            // Xử lý các giá trị //các giá trị được gửi bằng pt post
            $label_add_cate = trim(addslashes(htmlspecialchars($_POST['label_add_cate'])));
            $url_add_cate = trim(addslashes(htmlspecialchars($_POST['url_add_cate'])));
            $type_add_cate = trim(addslashes(htmlspecialchars($_POST['type_add_cate'])));
            $parent_add_cate = trim(addslashes(htmlspecialchars($_POST['parent_add_cate'])));
            $sort_add_cate = trim(addslashes(htmlspecialchars($_POST['sort_add_cate'])));
 
 
            // Các biến xử lý thông báo
            $show_alert = '<script>$("#formAddCate .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formAddCate .alert").addClass("hidden");</script>';
            $success = '<script>$("#formAddCate .alert").attr("class", "alert alert-success");</script>';
 
            // Nếu các giá trị rỗng
            if ($label_add_cate == '' || $url_add_cate == '' || $type_add_cate == '' || $sort_add_cate == '')
            {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin';
            }
            // Ngược lại
            else
            {
                // Nếu type chuyên mục không phải số
                if (preg_match('/\D/', $type_add_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.';
                }
                // Nếu sort chuyên mục không phải số nguyên dương
                else if (preg_match('/\D/', $sort_add_cate) || $sort_add_cate < 1)
                {
                    echo $show_alert.'Sort chuyên mục phải là một số nguyên dương.';
                }
                // Nếu id parent chuyên mục không phải số
                else if (preg_match('/\D/', $parent_add_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.1';
                }
                // Nếu đúng 
                else
                {
                    // Thực thi tạo chuyên mục
                    $sql_add_cate = "INSERT INTO categories VALUES (
                        '',
                        '$label_add_cate',
                        '$url_add_cate',
                        '$type_add_cate',
                        '$sort_add_cate',
                        '$parent_add_cate',
                        '$date_current'
                    )";
                    $db->query($sql_add_cate);
                    echo $show_alert.$success.'Tạo chuyên mục thành công.';
                    $db->close(); // Giải phóng
                    // new Redirect($_DOMAIN.'categories'); // Trở về trang danh sách chuyên mục
                }
            }
        }
        
        // Tải chuyên mục cha trong chức năng chinh sửa chuyên mục
        //bài 9.2.3
            // Tải chuyên mục cha trong chức năng chinh sửa chuyên mục//tùy theo khi ta click 3 mục :LỚN VỪA NHỎ
        else if ($action == 'load_edit_parent_cate')
        {
            // Xử lý giá trị//là type đang dùng checked và id của data muôn sửa
            $type_edit_cate = trim(addslashes(htmlspecialchars($_POST['type_edit_cate'])));
            $id_edit_cate = trim(addslashes(htmlspecialchars($_POST['id_edit_cate'])));

            // Nếu type đúng dạng số//type
            if (!preg_match('/\D/', $type_edit_cate)) 
            {
                $type_edit_parent_cate = $type_edit_cate - 1; // Lấy type parent
                $sql_get_cate = "SELECT * FROM categories WHERE type = '$type_edit_parent_cate'";//lấy ra type mẹ của type được checked
                if ($db->num_rows($sql_get_cate))
                {
                    // In danh sách các chuyên mục cha theo type parent
                    foreach ($db->fetch_assoc($sql_get_cate, 0) as $key => $data_cate)
                    {
                        if ($id_edit_cate != $data_cate['id_cate']) {//nếu id của data sửa khác  với id của data mẹ khác(ở đây là các mẹ không phải là mẹ ruột)
                            echo '<option value="' . $data_cate['id_cate'] . '">' . $data_cate['label'] . '</option>';

                        }
                    }
                }
                else
                {
                    echo '<option value="0">Hiện chưa có chuyên mục cha nào' . $type_edit_cate .'</option>';
                }
            }
        }//kết thúc else if bài 9



        // Chỉnh sửa chuyên mục
//bài 9
        // Chỉnh sửa chuyên mục
        else if ($action == 'edit_cate') 
        {
            // Xử lý các giá trị nhận được từ POST Ajax
            $label_edit_cate = trim(addslashes(htmlspecialchars($_POST['label_edit_cate'])));
            $url_edit_cate = trim(addslashes(htmlspecialchars($_POST['url_edit_cate'])));
            $type_edit_cate = trim(addslashes(htmlspecialchars($_POST['type_edit_cate'])));
            $parent_edit_cate = trim(addslashes(htmlspecialchars($_POST['parent_edit_cate'])));
            $sort_edit_cate = trim(addslashes(htmlspecialchars($_POST['sort_edit_cate'])));
            $id_edit_cate = trim(addslashes(htmlspecialchars($_POST['id_edit_cate'])));

            // Các biến xử lý thông báo//thẻ được áp dụng đây là thẻ div có class=alert trong form#formEditCate 
            $show_alert = '<script>$("#formEditCate .alert").removeClass("hidden");</script>';
            $hide_alert = '<script>$("#formEditCate .alert").addClass("hidden");</script>';
            $success = '<script>$("#formEditCate .alert").attr("class", "alert alert-success");</script>';

            // Nếu các giá trị rỗng
            if ($label_edit_cate == '' || $url_edit_cate == '' || $type_edit_cate == '' || $sort_edit_cate == '')
            {
                echo $show_alert.'Vui lòng điền đầy đủ thông tin';
            }
            // Ngược lại
            else
            {
                // Nếu type chuyên mục không phải số
                if (preg_match('/\D/', $type_edit_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau.';
                }
                // Nếu sort chuyên mục không phải số nguyên dương
                else if (preg_match('/\D/', $sort_edit_cate) || $sort_edit_cate < 1)
                {
                    echo $show_alert.'Sort chuyên mục phải là một số nguyên dương.';
                }
                // Nếu id parent chuyên mục không phải số
                else if (preg_match('/\D/', $parent_edit_cate))
                {
                    echo $show_alert.'Đã có lỗi xảy ra, hãy thử lại sau';
                }
                // Nếu đúng 
                else
                {
                    // Thực thi chỉnh sửa chuyên mục
                    $sql_edit_cate = "UPDATE categories SET 
                        label = '$label_edit_cate',
                        url = '$url_edit_cate',
                        type = '$type_edit_cate',
                        parent_id = '$parent_edit_cate',
                        sort = '$sort_edit_cate'
                        WHERE id_cate = '$id_edit_cate'
                    ";
                    $db->query($sql_edit_cate);
                    echo $show_alert.$success.'Tạo chuyên mục thành công.';
                    $db->close(); // Giải phóng
                    // new Redirect($_DOMAIN.'categories'); // Trở về trang danh sách chuyên mục
                }
            }
        }//kết thúc else if(edit_cate)


else if ($action == 'delete_cate_list')///đây là hàng động xóa cả lũ
{
    foreach ($_POST['id_cate'] as $key => $id_cate)//dùng foreach để xóa tất cả data ứng với mảng id đã gửi sang//lặp từng cái id một 
    {
        $sql_check_id_cate_exist = "SELECT id_cate FROM categories WHERE id_cate = '$id_cate'";///kiểm tra xem có cái data nào có id như trong mảng $id_cate không .
        if ($db->num_rows($sql_check_id_cate_exist))//nếu có 
        {
            $sql_delete_cate = "DELETE FROM categories WHERE id_cate = '$id_cate'";//thì xóa thôi
            $db->query($sql_delete_cate);//thực thi
        }
    }   
    $db->close();
}//đóng else if(xóa hết)



else if ($action == 'delete_cate')///xóa 1 mục được chỉ định
        {       
            $id_cate = trim(htmlspecialchars(addslashes($_POST['id_cate'])));//xử lý id được gửi
            $sql_check_id_cate_exist = "SELECT id_cate FROM categories WHERE id_cate = '$id_cate'";///kiểm tra xem có cate nào có id đó đó ko
            if ($db->num_rows($sql_check_id_cate_exist))//nếu ko
            {
                $sql_delete_cate = "DELETE FROM categories WHERE id_cate = '$id_cate'";
                $db->query($sql_delete_cate);//thực thi
                $db->close();
            }       
        }//kết thúc else if //xóa 1 mục được chỉ định









    }
    // Ngược lại không tồn tại POST action
    else
    {
        new Redirect($_DOMAIN);
    }
}
// Nếu không đăng nhập
else
{
    new Redirect($_DOMAIN);
}
 
?>
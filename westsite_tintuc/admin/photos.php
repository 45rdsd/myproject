<?php
//  ///bài 10///file xử lý dữ liệu ảnh upload




// Kết nối database và thông tin chung
require_once 'core/init.php';

// Nếu đăng nhập
if ($user) 
{
    // Nếu có file upload
    if (isset($_FILES['img_up'])) 
    {
        foreach($_FILES['img_up']['name'] as $name => $value)///tạo địa chỉ folder để lưu ảnh (thực chất là tạo folder trong bộ code để chứa ảnh).Tên folder(địa chỉ) lưu trữ ảnh được đặt theo năm_tháng_ngày.để chương trình code khi nếu cần có thể lấy nó
        {


            $dir = "../upload/"; 
             // Hàm stripslashes() sẽ loại bỏ các dấu backslashes ( \ ) có trong chuỗi.VD:this is a \n \"test\" 
//             this is a n "test"
            $name_img = stripslashes($_FILES['img_up']['name'][$name]);//tên file ảnh + đuôi

            $source_img = $_FILES['img_up']['tmp_name'][$name];

            // Lấy ngày, tháng, năm hiện tại
            $day_current = substr($date_current, 8, 2);
            $month_current = substr($date_current, 5, 2);
            $year_current = substr($date_current, 0, 4);

            // Tạo folder năm hiện tại
            if (!is_dir($dir.$year_current))
            {
                mkdir($dir.$year_current.'/');
            } 

            // Tạo folder tháng hiện tại
            if (!is_dir($dir.$year_current.'/'.$month_current))
            {
                mkdir($dir.$year_current.'/'.$month_current.'/');
            }   

            // Tạo folder ngày hiện tại
            if (!is_dir($dir.$year_current.'/'.$month_current.'/'.$day_current))
            {
                mkdir($dir.$year_current.'/'.$month_current.'/'.$day_current.'/');
            }

            $path_img = $dir.$year_current.'/'.$month_current.'/'.$day_current.'/'.$name_img; // Đường dẫn thư mục chứa file

            move_uploaded_file($source_img, $path_img); // Upload file

// Hàm explode() trong PHP là hàm có chức năng chuyển đổi một chuỗi thành một mảng và mỗi phần tử được tách bởi một chuỗi con hay một ký tự nào đó. Hàm này được sử dụng trên PHP4, PHP5 và PHP7. explode( string $characters, string $string[, int $limit ]);
// //Hàm array_pop() sẽ loại bỏ phần tử cuối cùng của mảng truyền vào. trả về phần tử bị loại bỏ.
//             $type_img = array_pop(explode("\.", $name_img)); // Loại file//lấy đuôi từ tên ảnh(đuôi này sẽ nằm sau ký tự "\.")

            $tmp_bien = explode(".", $name_img); // Loại file///ví dụ "jpg"

            //hàm array_pop chỉ nhận biến tham chiếu của một mảng cụ thể nào đó nhé nên ta ko thể truyền trực tiếp giá trị một mảng cụ thể được nhé
            $type_img=array_pop($tmp_bien);
            $url_img = substr($path_img, 3); // Đường dẫn file

            $size_img = $_FILES['img_up']['size'][$name]; // Dung lượng file//tính là byte

            // Thêm dữ liệu vào table
            $sql_up_file = "INSERT INTO images VALUES (
                '',
                '$url_img',
                '$type_img',
                '$size_img',
                '$date_current'
            )";
            $db->query($sql_up_file);
        }
        echo 'Upload thành công.';
        $db->close();
        echo "</br>";
        echo $name_img ;//tên file ảnh + đuôi(jpg)
        echo "</br>";
        echo $type_img ;//đuôi ảnh (jpg)

        echo "</br>";
       echo $source_img;///địa chỉ lưu trữ file ảnh trên serve ảo(ở đây là xampp)
          echo "</br>";
        echo $size_img ;///size ảnh đơn vị byte
         echo "</br>";
        echo  $url_img  ; // đường dẫn đến folder_thư mục địa chỉ chứa ảnh của chương trình_sẵn có trong bộ code nhé



        // new Redirect($_DOMAIN.'photos');




    } ///phần chính bài 10



////bài 11//nhận ajax//xóa nhiều ảnh 1 lúc nè
    // Nếu tồn tại POST action
    else if (isset($_POST['action']))
    {
        $action = trim(addslashes(htmlspecialchars($_POST['action'])));

        // Xoá nhiều ảnh cùng lúc
        if ($action == 'delete_img_list') 
        {
            foreach ($_POST['id_img'] as $key => $id_img)
            {
                $sql_check_id_img_exist = "SELECT * FROM images WHERE id_img = '$id_img'";
                if ($db->num_rows($sql_check_id_img_exist))
                {
                    $data_img = $db->fetch_assoc($sql_check_id_img_exist, 1);
                    if (file_exists('../'.$data_img['url']))
                    {
                        unlink('../'.$data_img['url']);
                    }

                    $sql_delete_img = "DELETE FROM images WHERE id_img = '$id_img'";
                    $db->query($sql_delete_img);
                }
            }   
            $db->close();
        }
        // Xoá ảnh chỉ định
        else if ($action == 'delete_img')
        {       
            $id_img = trim(htmlspecialchars(addslashes($_POST['id_img'])));
            $sql_check_id_img_exist = "SELECT * FROM images WHERE id_img = '$id_img'";
            if ($db->num_rows($sql_check_id_img_exist))
            {
                $data_img = $db->fetch_assoc($sql_check_id_img_exist, 1);
                if (file_exists('../'.$data_img['url']))
                {
                    // Hàm unlink() php giúp chúng ta xóa đi những file trên hệ thống không dùng đến như ảnh, tài liệu
                    unlink('../'.$data_img['url']);///đây là xóa file ảnh lưu trong thư mục của bộ code///thư mục của bộ code là nơi chứa ảnh đẻ lấy lên serve
                }

                $sql_delete_img = "DELETE FROM images WHERE id_img = '$id_img'";
                $db->query($sql_delete_img);//còn đây là xóa database của serve
                $db->close();
            }       
        }
    }
    else
    {
        new Redirect($_DOMAIN); 
    }////kết thúc bài 11//xóa nhiều ảnh 1 lúc và xóa ảnh chỉ định



}
// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
 
?>
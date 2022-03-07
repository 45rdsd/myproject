<?php


 //bài 8_file chứa code phân trang chức năng cho chuyên mục như hiển thị giao diện  thêm sửa xóa ứng với giá trị biến ac và id thu được
// Nếu đăng nhập
if ($user)
{



    // Nếu tài khoản là tác giả
    if ($data_user['position'] == 0)
    {
        echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
    }


    // Ngược lại tài khoản là admin
    else if ($data_user['position'] == 1)
    {
        echo '<h3>Chuyên mục</h3>';//lúc nào cũng có từ này


        // Lấy tham số ac//tham số ac ứng với các giá trị là add/edit//Lấy từ GET
        if (isset($_GET['ac']))
        {
            $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
        }
        else
        {
            $ac = '';
        }
 
        // Lấy tham số id//id của chuyên mục//lấy từ GET
        if (isset($_GET['id']))
        {
            $id = trim(addslashes(htmlspecialchars($_GET['id'])));
        }
        else
        {
            $id = '';
        }
 


        // Nếu có tham số ac
        if ($ac != '') 
        {
            // Trang thêm chuyên mục
            if ($ac == 'add')
            {
                // Dãy nút của thêm chuyên mục
                echo//Hiện nút trở về index
                '
                    <a href="' . $_DOMAIN . 'categories" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                    </a> 
                ';
 



                // Content thêm chuyên mục
                //phần 4 bài 8//khi đã bấm vào thêm rồi thì sẽ có nút Trở về  và form dưới đây _đường dẫn lúc đó sẽ là "$_DOMAIN/categories/add" tức lúc này đã có tham số add
echo
'   
    <p class="form-add-cate">

        <form method="POST" id="formAddCate" onsubmit="return false;">
            <div class="form-group">
                <label>Tên chuyên mục</label>
                <input type="text" class="form-control title" id="label_add_cate">
            </div>

            <div class="form-group">
                <label>URL chuyên mục</label>
                <input type="text" class="form-control slug" placeholder="Nhấp vào để tự tạo" id="url_add_cate">
            </div>


            <div class="form-group">

                <label>Loại chuyên mục</label>

                <div class="radio">
                    <label>
                        <input type="radio" name="type_add_cate" value="1" checked class="type-add-cate-1"> Lớn
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="type_add_cate" value="2" class="type-add-cate-2"> Vừa
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="type_add_cate" value="3" class="type-add-cate-3"> Nhỏ
                    </label>
                </div>

            </div>



            <div class="form-group hidden parent-add-cate">
                <label>Parent chuyên mục</label>
                <select id="parent_add_cate" class="form-control">
                </select>
            </div>





            <div class="form-group">
                <label>Sort chuyên mục</label>
                <input type="text" class="form-control" id="sort_add_cate">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tạo</button>
            </div>

            <div class="alert alert-danger hidden"></div>

        </form>

    </p>
';





            } 
            // Trang chỉnh sửa chuyên mục
            else if ($ac == 'edit')
            {
                $sql_check_id_cate = "SELECT id_cate FROM categories WHERE id_cate = '$id'";
                // Nếu tồn tại tham số id(lấy từ GET) của chuyên mục trong table categories
                if ($db->num_rows($sql_check_id_cate)) 
                {
                    // Dãy nút của chỉnh sửa chuyên mục
                    echo//nút xóa và nút trở về
                    '
                        <a href="' . $_DOMAIN . 'categories" class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                        </a>
                        <a class="btn btn-danger" id="del_cate" data-id="' . $id . '">
                            <span class="glyphicon glyphicon-trash"></span> Xoá
                        </a> 
                    ';  
 





                    // Content chỉnh sửa chuyên mục
//bài 9_2.1 templates chỉnh sửa chuyên mục//tải khung html chứa data là nội dung chỉnh sửa



                    //lấy ra  datagories  cần sửa
                    $sql_get_data_cate = "SELECT * FROM categories WHERE id_cate = '$id'";
if ($db->num_rows($sql_get_data_cate))
{


    //lấy 1 cái duy nhất thôi
    $data_cate = $db->fetch_assoc($sql_get_data_cate, 1);//data cần sửa 
 
    // Chỉnh sửa loại chuyên mục
    $checked_type_1 = '';
    $checked_type_2 = '';
    $checked_type_3 = '';
     $parent_edit_cate='';




//Tạo  chuyên mục  "parent chuyên mục "
    if ($data_cate['type'] == 1)//nếu data cần sửa là chuyên mục loại lớn///thì data sửa ko có data mẹ
    {
        $checked_type_1 = 'checked';

        //biến tạo ra thẻ div lần lượt chứa thẻ label và select//ta chưa echo biến này đâu nhés
                $parent_edit_cate .= 
        '
            <div class="form-group parent-edit-cate hidden">
                <label>Parent chuyên mục</label>
                <select id="parent_edit_cate" class="form-control">
                </select>
            </div>
        ';
    }



    else if ($data_cate['type'] == 2)//data cần sủa là loại vừa nên chắc chắn nó data mẹ
    {
        $checked_type_2 = 'checked';
        $parent_edit_cate .= 
        '
            <div class="form-group parent-edit-cate">
                <label>Parent chuyên mục</label>
                <select id="parent_edit_cate" class="form-control">
        ';
 
        $sql_get_cate_parent= "SELECT * FROM categories WHERE type = '1'";
        if ($db->num_rows($sql_get_cate_parent))
        {


            // In danh sách các chuyên mục cha loại 1
            foreach ($db->fetch_assoc($sql_get_cate_parent, 0) as $key => $data_cate_parent)
            {


                // $data_cate_parent là data có type=1
                if ($data_cate['parent_id'] == $data_cate_parent['id_cate'])////nếu là data mẹ của data sửa thì dùng selected

                {///nếu chuyên mục mẹ vừa lặp có id bằng vơi parent_id của chuyên mục sửa//tức là data lặp có type=1 là mẹ của data sửa

                    //tiếp tục bổ xung code html cho biến $parent_edit_cate  viết thêm thẻ option 
                    $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '" selected>' . $data_cate_parent['label'] . '</option>';//label của nó sẽ được in lên đầu tiên
                }
                else//còn không thì cứ in ra thẻ option những ko có selected
                {
                    $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '">' . $data_cate_parent['label'] . '</option>';
                }
            }
        }
        else///nếu ko có data type=1
        {
            echo '<option value="0">Hiện chưa có chuyên mục cha nào</option>';
        }
 
        $parent_edit_cate .= //echo kết thúc thẻ select và div sau khi foreach xong
        '
                </select>
            </div>
        ';
    }///xong lấy data mẹ cho data type=2




    else if ($data_cate['type'] == 3)///data sửa loại nhỏ nên chắc chắn nó có data mẹ luôn
    {
        $checked_type_3 = 'checked';
        $parent_edit_cate .= 
        '
            <div class="form-group parent-edit-cate">
                <label>Parent chuyên mục</label>
                <select id="parent_edit_cate" class="form-control">
        ';
                             


                             //lấy ra data mẹ có type=2 ra
        $sql_get_cate_parent= "SELECT * FROM categories WHERE type = '2'";

        if ($db->num_rows($sql_get_cate_parent))
        {
            // In danh sách các chuyên mục cha loại 2
            foreach ($db->fetch_assoc($sql_get_cate_parent, 0) as $key => $data_cate_parent)
            {
                if ($data_cate['parent_id'] == $data_cate_parent['id_cate'])//nếu là data mẹ của data sửa thì dùng selected
                {
                    $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '" selected>' . $data_cate_parent['label'] . '</option>';
                }
                else//còn ko phải data mẹ ruột của data sửa
                {
                    $parent_edit_cate .= '<option value="' . $data_cate_parent['id_cate'] . '">' . $data_cate_parent['label'] . '</option>';
                }
            }
            }





        else
        {
            echo '<option value="0">Hiện chưa có chuyên mục cha nào</option>';
        }
 
        $parent_edit_cate .= //echo kết thúc thẻ select và div sau khi foreach xong
        '
                </select>
            </div>
        ';
    }///kết thúc foreach với type bằng 3///lấy mẹ xong cho data sửa có type bằng 2
 




   
                        echo
                        '   <p class="form-edit-cate">
                                <form method="POST" id="formEditCate" data-id="' . $data_cate['id_cate'] . '" onsubmit="return false;" class="form-cate">
                                    <div class="form-group">
                                        <label>Tên chuyên mục</label>
                                        <input type="text" class="form-control title" value="' . $data_cate['label'] . '" id="label_edit_cate">
                                    </div>
                                    <div class="form-group">
                                        <label>URL chuyên mục</label>
                                        <input type="text" class="form-control slug" value="' . $data_cate['url'] . '" id="url_edit_cate">
                                    </div>
                                    <div class="form-group">
                                        <label>Loại chuyên mục</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type_edit_cate" value="1" class="type-edit-cate-1" ' . $checked_type_1 . '> Lớn
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type_edit_cate" value="2" class="type-edit-cate-2" ' . $checked_type_2 . '> Vừa
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type_edit_cate" value="3" class="type-edit-cate-3" ' . $checked_type_3 . '> Nhỏ
                                            </label>
                                        </div>
                                    </div>
                                                    ' . $parent_edit_cate . '
                                    <div class="form-group">
                                        <label>Sort chuyên mục</label>
                                        <input type="text" class="form-control" value="' . $data_cate['sort'] . '" id="sort_edit_cate">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                    <div class="alert alert-danger hidden"></div>
                                </form>
                            </p>
                        ';
}///bài 9.2.1 templates chỉnh sửa chuyên mục










                }
                else
                {
                    // Hiển thị thông báo lỗi
                    echo
                    '
                        <div class="alert alert-danger">ID chuyên mục đã bị xoá hoặc không tồn tại.</div>
                    ';
                }
            }
        }



        // Ngược lại không có tham số ac
        // Trang danh sách chuyên mục
        else
        {
            // Dãy nút của danh sách chuyên mục//Thêm  , reload,xóa
            echo
            '

                <a href="' . $_DOMAIN . 'categories/add" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus"></span> Thêm
                </a> 
                <a href="' . $_DOMAIN . 'categories" class="btn btn-default">
                    <span class="glyphicon glyphicon-repeat"></span> Reload
                </a> 
                <a class="btn btn-danger" id="del_cate_list">
                    <span class="glyphicon glyphicon-trash"></span> Xoá
                </a> 
            ';
 



            // Content danh sách chuyên mục









//bài 9//list tất cả chuyên mục//1
            $sql_get_list_cate = "SELECT * FROM categories ORDER BY id_cate DESC";
// Nếu có chuyên mục//lấy giảm dần theo id
if ($db->num_rows($sql_get_list_cate))
{
    echo//tạo dòng và các cột//echo tạo thẻ table và thẻ div
    '
        <br><br>
        <div class="table-responsive">
            <table class="table table-striped list"     id="list_cate">




                <tr>
                    <td><input type="checkbox"></td>
                    <td><strong>ID</strong></td>
                    <td><strong>Tên chuyên mục</strong></td>

                    <td><strong>Loại</strong></td>
                    <td><strong>Chuyên mục cha</strong></td>
                    <td><strong>Sort</strong></td>

                    <td><strong>Tools</strong></td>
                </tr>
    ';


 
    // In danh sách chuyên mục//lấy ra tất cả các chuyên mục rồi cho vào vòng lặp foreach
    foreach ($db->fetch_assoc($sql_get_list_cate, 0) as $key => $data_cate)
    {


        //Lọc dữ liệu để hiển thị cột giá trị chuyên mục cha
        // Hiển thị chuyên mục cha///lặp được cái nào mà có id_cate là parent_id của chuyên mục con nào đó//thì đó chính là chuyên mục cha rồi
        $sql_get_cate_parent = "SELECT * FROM categories WHERE id_cate = '$data_cate[parent_id]'";
//lặp được cái $data_cate nào thì ta lấy chuyên mục cha ứng với $data_cate đó




///kiểm tra dữ liệu chuyên mục cha con lưu trong database có hợp lệ ko
        if ($db->num_rows($sql_get_cate_parent))
        {

            // lấy ra 1 cái chuyên mục cha  đầu tiên thôi
            $data_cate_parent = $db->fetch_assoc($sql_get_cate_parent, 1);
 

     //nếu chuyên mục cha vừa lấy có type=1 và chuyên mục con của nó có type=3 thì là lỗi rồi(vì cha con chỉ hơn 1 đơn vị)//vì type của cha và type của con chỉ ít hơn 1 đơn vị thôi(1-2,2-3)
            //1-3
            if ($data_cate_parent['type'] == '1' && $data_cate['type'] == '3')
            {
                $label_cate_parent = '<p class="text-danger">Lỗi</p>';
            }


            //type cha ko thể lớn hơn type con(3-2)
            else if ($data_cate_parent['type'] == '3' && $data_cate['type'] == '2') 
            {
                $label_cate_parent = '<p class="text-danger">Lỗi</p>';
            }
//3-1
            else if ($data_cate_parent['type'] == '3' && $data_cate['type'] == '1') 
            {
                $label_cate_parent = '<p class="text-danger">Lỗi</p>';
            }


            //type của cha ko thể bằng type con được
            else if ($data_cate_parent['type'] == $data_cate['type']) 
            {
                $label_cate_parent = '<p class="text-danger">Lỗi</p>';
            }
            else///những giá trị type của cha và con hợp lệ thì 
            {
                $label_cate_parent = $data_cate_parent['label'];
            }
        }
        else //nếu categories ko chuyên mục con 
        {
            $label_cate_parent = '';//
        }




        // như vậy sau tất cả ta sẽ gán giá trị là chuỗi cho biến//đó chính là giá trị của label của cột chuyên mục cha nếu nó lỗi
 
        // Hiển thị loại chuyên mục///chuỗi Lớn-Vừa-Nhỏ tùy theo tham số
        if ($data_cate['type'] == 1)
        {
            $data_cate['type'] = 'Lớn';
        }
        else if ($data_cate['type'] == 2)
        {
            $data_cate['type'] = 'Vừa';
        }
        else if ($data_cate['type'] == 3)
        {
            $data_cate['type'] = 'Nhỏ';
        }
     


     ///hiển thi giá trị cho các cột(tức là điền các dòng giá trị cho table ở trên)//từ con đến cha.cứ như vậy cho đến hết(hiển thị hết record nhỏ-đến record vừa-đến record lớn)
        echo//nếu fore
        '

            <tr>
                <td><input type="checkbox" name="id_cate[]" value="' . $data_cate['id_cate'] .'"></td>

                <td>' . $data_cate['id_cate'] .'</td>

                <td><a href="' . $_DOMAIN . 'categories/edit/' . $data_cate['id_cate'] .'">' . $data_cate['label'] . '</a></td>

                <td>' . $data_cate['type'] . '</td>
                <td>' . $label_cate_parent . '</td>
                <td>' . $data_cate['sort'] . '</td>

                <td>
                    <a href="' . $_DOMAIN . 'categories/edit/' . $data_cate['id_cate'] .'" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a class="btn btn-danger btn-sm del-cate-list" data-id="' . $data_cate['id_cate'] . '">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>


        </tr>
        ';



    }///kết thúc foreach
 









    echo//echo hiện thể kết thúc table và thẻ div
    '

            </table>
        </div>
    ';
}


// Nếu không có chuyên mục trong table categories
else
{
    echo '<br><br><div class="alert alert-info">Chưa có chuyên mục nào.</div>';
}












        }
    }
}




// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index để đăng nhập
}
 
?>
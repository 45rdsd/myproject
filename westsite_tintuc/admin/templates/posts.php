<?php
  


  //bài 12//hiển thị giao diện ứng với add bài viết và edit/id bài viết
// Nếu đăng nhập
if ($user)
{
    echo '<h3>Bài viết</h3>';

    // Lấy tham số ac///khi có $tab=posts//thì liền sau nó sẽ là biến $ac

    if (isset($_GET['ac']))
    {
        $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
    }
    else
    {
        $ac = '';
    }
  




    // Lấy tham số id
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
        // Trang thêm bài viết
        if ($ac == 'add')///nếu $tab=posts và $ac=add
        {
            // Dãy nút của thêm bài viết
            echo
            '
                <a href="' . $_DOMAIN . 'posts" class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                </a> 
            ';
  



            // Content thêm bài viết//giao diện khi bấm thêm bài biết///bài 12
            echo
'
    <p class="form-add-post">
        <form method="POST" id="formAddPost" onsubmit="return false;">

            <div class="form-group">
                <label>Tiêu đề bài viết</label>
                <input type="text" class="form-control title" id="title_add_post">
            </div>
            <div class="form-group">
                <label>URL chuyên mục</label>
                <input type="text" class="form-control slug" placeholder="Nhấp vào để tự tạo" id="slug_add_post">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tạo</button>
            </div>
            <div class="alert alert-danger hidden"></div>
        </form>
    </p>  
';



        } 






        // Trang chỉnh sửa bài viết
        else if ($ac == 'edit')
        {
            $sql_check_id_cate = "SELECT id_post, author_id FROM posts WHERE id_post = '$id'";
            // Nếu tồn tại tham số id trong table
            if ($db->num_rows($sql_check_id_cate)) 
            {
                $data_post = $db->fetch_assoc($sql_check_id_cate, 1);
 
                if ($data_post['author_id'] == $data_user['id_acc'] || $data_user['position'] == '1')
                {
                    // Dãy nút của chỉnh sửa bài viết
                    echo
                    '
                        <a href="' . $_DOMAIN . 'posts" class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                        </a>
                        <a class="btn btn-danger" id="del_post" data-id="' . $id . '">
                            <span class="glyphicon glyphicon-trash"></span> Xoá
                        </a> 
                    ';  
      
                    // Content chỉnh sửa bài viết
                }
                else
                {
                    echo '<div class="alert alert-danger">ID bài viết không thuộc quyền sở hữu của bạn.</div>';
                }
            }
            else
            {
                // Hiển thị thông báo lỗi
                echo
                '
                    <div class="alert alert-danger">ID bài viết đã bị xoá hoặc không tồn tại.</div>
                ';
            }
        }




   }



    // Ngược lại không có tham số ac
    // Trang danh sách bài viết
    else
    {
        // Dãy nút của danh sách bài viết
        echo
        '
            <a href="' . $_DOMAIN . 'posts/add" class="btn btn-default">
                <span class="glyphicon glyphicon-plus"></span> Thêm
            </a> 

            <a href="' . $_DOMAIN . 'posts" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a> 

            <a class="btn btn-danger" id="del_post_list">
                <span class="glyphicon glyphicon-trash"></span> Xoá
            </a> 
        ';
  






        // Content danh sách bài viết///bài 13
        // Nếu là admin thì lấy toàn bộ bài viết
if ($data_user['position'] == '1') {
    $sql_get_list_post = "SELECT * FROM posts ORDER BY id_post DESC";
// Nếu là tác giả thì chỉ lấy những bài thuộc sở hữu
} else {
    $sql_get_list_post = "SELECT * FROM posts WHERE author_id = '$data_user[id_acc]' ORDER BY id_post DESC";
}
// Nếu có bài viết
if ($db->num_rows($sql_get_list_post))
{
    // Lấy số trang
    if (isset($_GET['page'])) {
        $current_page = trim(htmlspecialchars(addslashes($_GET['page']))); ///lấy là giá trị tham số $page
    } else {
        $current_page = '';
    }
 
    $limit = 1; // Giới hạn số bài viết trong 1 trang//trong 1 trang chứa có $limit record
    $total_page = ceil($db->num_rows($sql_get_list_post) / $limit); // Tổng  số trang chứa
    $start = ($current_page - 1) * $limit; // Vị trí bắt đầu lấy trang(tức là record bắt đầu trong một trang chứa là record thứ bao nhiêu
 
    // Nếu số trang hiện tại > tổng trang
    if ($current_page > $total_page) {
        new Redirect($_DOMAIN . 'posts&page=' . $total_page); // Tới số trang lớn nhất//tới trang chứa lớn nhất
    // Nếu số trang hiện tại < 1
    } else if ($current_page < 1){
        new Redirect($_DOMAIN . 'posts&page=1'); // Tới trang đầu tiên
    }   
 




    // Form tìm kiếm
    echo
    '
        <p>
            <form method="POST" id="formSearchPost" onsubmit="return false;">
                <div class="input-group">         
                    <input type="text" class="form-control" id="kw_search_post" placeholder="Nhập ID, tiêu đề, slug ...">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
        </p>
    ';
 






    echo//echo thể mở div table và tr
    '
        <div class="table-responsive" id="list_post">
            <table class="table table-striped list">
                <tr>
                    <td><input type="checkbox"></td>
                    <td><strong>ID</strong></td>
                    <td><strong>Tiêu đề</strong></td>
                    <td><strong>Trạng thái</strong></td>
                    <td><strong>Chuyên mục</strong></td>
                    <td><strong>Lượt xem</strong></td>
    ';
 
    // Nếu tài khoản là admin///hiển thị thêm cột td này
    if ($data_user['position'] == '1') {
        echo '<td><strong>Tác giả</strong></td>';
    }



    ///lúc nào cũng có tools
 
    echo '
                    <td><strong>Tools</strong></td>
                </tr>
    ';
 
     
    // Nếu là admin thì lấy toàn bộ bài viết
    if ($data_user['position'] == '1') {
        $sql_get_list_post_limit = "SELECT * FROM posts ORDER BY id_post DESC LIMIT $start, $limit";
    // Nếu là tác giả thì chỉ lấy những bài thuộc sở hữu của tài khoản tác giả đang login
    } else {
        $sql_get_list_post_limit = "SELECT * FROM posts WHERE author_id = '$data_user[id_acc]' ORDER BY id_post DESC LIMIT $start, $limit";
    }
    // In danh sách bài viết
    foreach ($db->fetch_assoc($sql_get_list_post_limit, 0) as $key => $data_post) 
    {
        // Trạng thái bài viết
        if ($data_post['status'] == 0) {

            $stt_post = '<label class="label label-warning">Ẩn</label>';

        } else if ($data_post['status'] == 1) {

            $stt_post = '<label class="label label-success">Xuấn bản</label>';
        }
 
        // Chuyên mục bài viết
        $cate_post = '';///tạo biến $cate_post



   ///lấy data cate ứng với cột cate_1_id
        $sql_check_id_cate_1 = "SELECT label, id_cate FROM categories WHERE id_cate = '$data_post[cate_1_id]' AND type = '1'";

        if ($db->num_rows($sql_check_id_cate_1)) {
            $data_cate_1 = $db->fetch_assoc($sql_check_id_cate_1, 1);
            $cate_post .= $data_cate_1['label'];//nhãn dán là giá trị của $cate_post
        } else {
            $cate_post .= '<span class="text-danger">Lỗi</span>';
        }
 

 //tương tự lấy cate ứng với cột cate_2_id
        $sql_check_id_cate_2 = "SELECT label, id_cate FROM categories WHERE id_cate = '$data_post[cate_2_id]' AND type = '2'";
        if ($db->num_rows($sql_check_id_cate_2)) {
            $data_cate_2 = $db->fetch_assoc($sql_check_id_cate_2, 1);

            $cate_post .= ' , ' . $data_cate_2['label'];//tức là $cate_post sẽ nối tiếp bằng label của $data_cate_2 nếu có
        } else {
            $cate_post .= ', <span class="text-danger">Lỗi</span> ';///ko thì nối tiếp biến php là một thẻ html
        }
 


 //tương tự với cột cate_3_id
        $sql_check_id_cate_3 = "SELECT label, id_cate FROM categories WHERE id_cate = '$data_post[cate_3_id]' AND type = '3'";
        if ($db->num_rows($sql_check_id_cate_3)) {
            $data_cate_3 = $db->fetch_assoc($sql_check_id_cate_3, 1);
            $cate_post .= ' , ' . $data_cate_3['label'];
        } else {
            $cate_post .= ', <span class="text-danger">Lỗi</span>';
        }
 



// Tác giả bài viết///data tác giả bài viết chính là data trong table accounts
        $sql_get_author = "SELECT display_name FROM accounts WHERE id_acc = '$data_post[author_id]'";
        if ($db->num_rows($sql_get_author)) {
            $data_author = $db->fetch_assoc($sql_get_author, 1);
            $author_post = $data_author['display_name'];
        } else {
            $author_post = '<span class="text-danger">Lỗi</span>';
        }
 

 //echo data của  các cột
        echo
        '
            <tr>
                <td><input type="checkbox" name="id_post[]" value="' . $data_post['id_post'] .'"></td>
                <td>' . $data_post['id_post'] . '</td>
                <td style="width: 30%;"><a href="' . $_DOMAIN . 'posts/edit/' . $data_post['id_post'] . '">' . $data_post['title'] . '</a></td>
                <td>' . $stt_post . '</td>
                <td>' . $cate_post . '</td>
                <td>' . $data_post['view'] . '</td>
        ';
 
        // Tác giả bài viết
        if ($data_user['position'] == '1') {
            echo '<td>' . $author_post . '</td>';
        }
 
 //tiếp tục echo data của các cột ứng với nút sửa và xóa
        echo '
                <td>
                    <a href="' . $_DOMAIN . 'posts/edit/' . $data_post['id_post'] .'" class="btn btn-primary btn-sm">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a class="btn btn-danger btn-sm del-post-list" data-id="' . $data_post['id_post'] . '">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        ';
    }//kết thúc foreach
 
    echo///echo thẻ đóng table
    '
            </table>
    ';
 
    // Nút phân trang//mở thẻ div///các nút hiển thị ây
    echo '<div class="btn-group" id="paging_post">';

    // Nếu trang hiện tại > 1 và tổng trang > 1 thì hiển thị nút prev
    if ($current_page > 1 && $total_page > 1){
        echo '<a class="btn btn-default" href="' . $_DOMAIN . 'posts&page=' . ($current_page - 1) . '"><span class="glyphicon glyphicon-chevron-left"></span> Prev</a>';
    }
      
    // In số nút trang//dùng vòng lặp for
    for ($i = 1; $i <= $total_page; $i++){
///nếu lặp đến $i mà là $current_page đang hiển thị data
        // Nếu trùng với trang  chứa hiện tại thì active//tức là làm nổi bật lên
        if ($i == $current_page){
            echo '<a class="btn btn-default active">' . $i . '</a>';
        // Ngược lại
        } else {
            echo '<a class="btn btn-default" href="' . $_DOMAIN . 'posts&page=' . $i . '">' . $i . '</a>';
        }
    }
      
    // Nếu trang hiện tại < tổng số trang > 1 thì hiển thị nút next
    if ($current_page < $total_page && $total_page > 1){
        echo '<a class="btn btn-default" href="' . $_DOMAIN . 'posts&page=' . ($current_page + 1) . '">Next <span class="glyphicon glyphicon-chevron-right"></span></a>';
    }
    echo '<br><br><br></div>';///đóng thẻ div hiển thị nút
 


    echo//echo thẻ đóng div (thẻ div sát thể table)
     '
        </div>
    ';
}///kết thúc vòng lặp if(khi có bài posts)




// Nếu không có bài viết
else
{
    echo '<br><br><div class="alert alert-info">Chưa có bài viết nào.</div>';
}



    }
}
// Ngược lại chưa đăng nhập
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
  
?>

// FILE NÀY ĐỂ nhận data từ form templates/sign.php validate qua



$_DOMAIN = 'http://localhost:8080/newspaper/admin/';


 //bài 6// nhận data từ form templates/sign.php validate qua
// Đăng nhập
$('#formSignin button').on('click', function() {
    $this = $('#formSignin button');//thẻ button trong form điền data login
    $this.html('Đang tải ...');
 
    // Gán các giá trị trong các biến
    $user_signin = $('#formSignin #user_signin').val();
    $pass_signin = $('#formSignin #pass_signin').val();
 
    // Nếu các giá trị rỗng
    if ($user_signin == '' || $pass_signin == '')
    {
        $('#formSignin .alert').removeClass('hidden');
        $('#formSignin .alert').html('Vui lòng điền đầy đủ thông tin.');
        $this.html('Đăng nhập');
    }
    // Ngược lại//nếu data gõ đăng nhập oke
    else
    {
        $.ajax({
            url : $_DOMAIN + 'signin.php',//file nhận data là file templates/signin.php nhé
            type : 'POST',
            data : {
                user_signin : $user_signin,
                pass_signin : $pass_signin
            }, success : function(data) {
                $('#formSignin .alert').removeClass('hidden');
                $('#formSignin .alert').html(data);
                $this.html('Đăng nhập');
            }, error : function() {
                $('#formSignin .alert').removeClass('hidden');
                $('#formSignin .alert').html('Không thể đăng nhập vào lúc này, hãy thử lại sau.');
                $this.html('Đăng nhập');
            }
        });
    }
}); 



//bài h8:tạo hàm tự động js tạo slug

// Tự động tạo slug
function ChangeToSlug()
{
    var title, slug;
    title = $('.title').val();
    slug = title.toLowerCase();
  
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');


    $('.slug').val(slug);///gán giá trị slug ứng với title (vào input có class=slug)
}////khi thực thi hàm này thì đã có slug trong input có class=slug rồi
 
$('.slug').on('click', function() {
    ChangeToSlug();
});//cái này cũng áp dụng cho việc tự động tạo slug ở bài 12 nhé///để ý sẽ thấy 


//bài 8//hiển thị các chuyên mục cha sát vách(tùy theo type) khi ta tạo một chuyên mục nào đó
// Tải chuyên mục cha ở chức năng thêm chuyên mục
//TỪ FORM VỪA THÊM BÊN CATEGORIES TA LẦN VÀO CÁC THẺ INPUT CÓ TYPE=RADIO. ĐỂ BẮT SỰ KIỆN KHI CLICK VÀO NÓ
$('#formAddCate input[type="radio"]').on('click', function() {

    ///từ #formAddCate class=type-add-cate-1 đưa đến thuộc tính checked dùng prop để kiểm tra nó
    //khi ta vào thêm chuyên mục thì checked mặc định là dùng cho loại chuyên mục lớn
  

// // nếu checked dùng cho input-radio-vừa//lần đến thuộc tính checked để kiểm tra xem nó đã dùng cho đối tượng này chưa
    if ($('#formAddCate .type-add-cate-1:checked').prop("checked") == true) 
    {
        $('.parent-add-cate').addClass('hidden');//ẩn div.parent-add-cate
        $('.parent-add-cate select').html('');//nội dung thẻ select bên trong thẻ divclass=parent-add-cate sẽ rỗng nhé
    }


    // nếu checked dùng cho input-radio-vừa
    else if ($('#formAddCate .type-add-cate-2:checked').prop("checked") == true) 
    {
        $type_add_cate = $('#formAddCate .type-add-cate-2').val();//value=2
 
        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',//chưa tạo file này
            data : {
                action : 'load_add_parent_cate',//biến action có giá trị là chuỗi này
                type_add_cate : $type_add_cate
            }, success : function(data) {
                $('.parent-add-cate').removeClass('hidden');//hiện thẻ div class=parent-add-cate
                $('.parent-add-cate select').html(data);//gán data làm nội dung của thẻ select
            }, error : function() {//nếu có lỗi phát sinh do hệ thống như serve hay ko nhận được data đã được xử lý 
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    } 



// nếu checked dùng cho input-radio-nhỏ
    else if ($('#formAddCate .type-add-cate-3:checked').prop("checked") == true) 
    {
        $type_add_cate = $('#formAddCate .type-add-cate-3').val();
        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_add_parent_cate',
                type_add_cate : $type_add_cate
            }, success : function(data) {
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate select').html(data);
            }, error : function() {
                $('.parent-add-cate').removeClass('hidden');
                $('.parent-add-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    }
});








///bài 8///js///khi bấm vào nút tạo
// Thêm chuyên mục
// Thêm chuyên mục
$('#formAddCate button').on('click', function() {
    $this = $('#formAddCate button');
    $this.html('Đang tải ...');

    // Gán các giá trị trong các biến
    $label_add_cate = $('#formAddCate #label_add_cate').val();
    $url_add_cate = $('#formAddCate #url_add_cate').val();
    $type_add_cate = $('#formAddCate input[name="type_add_cate"]:radio:checked').val();
    $parent_add_cate = $('#formAddCate #parent_add_cate').val();
    $sort_add_cate = $('#formAddCate #sort_add_cate').val();

    // Nếu các giá trị rỗng
    if ($label_add_cate == '' || $url_add_cate == '' || $type_add_cate == '' || $sort_add_cate == '')
    {
        $('#formAddCate .alert').removeClass('hidden');
        $('#formAddCate .alert').html('Vui lòng điền đầy đủ thông tin.');
        $this.html('Tạo');
    }
    // Ngược lại
    else
    {
        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                label_add_cate : $label_add_cate,
                url_add_cate : $url_add_cate,
                type_add_cate : $type_add_cate,
                parent_add_cate : $parent_add_cate,
                sort_add_cate : $sort_add_cate,
                action : 'add_cate'
            }, success : function(data) {
                $('#formAddCate .alert').removeClass('hidden');
                $('#formAddCate .alert').html(data);
                $this.html('Tạo');
            }, error : function() {
                $('#formAddCate .alert').removeClass('hidden');
                $('#formAddCate .alert').html('Không thể tạo chuyên mục vào lúc này, hãy thử lại sau.');
                $this.html('Tạo');
            }
        });
    }
});





// ////bài 9.2.2 viết ajax gửi dữ liệu

//nhận dữ liệu data chỉnh sửa
// Tải chuyên mục cha ở chức năng chỉnh sửa chuyên mục
$('#formEditCate input[type="radio"]').on('click', function() {//khi click vào cac thẻ input radion//tức là click vào trong 3 mục LỚN,NHỎ,VỪA

    $id_edit_cate = $('#formEditCate').attr('data-id');//giá trị id của data sửa nằm ở thẻ form này






    if ($('#formEditCate .type-edit-cate-1:checked').prop("checked") == true)///nếu checked đang dùng cho div.radio label Lớn 
    {//tức là đang tích thẻ input radio LỚN//mặc định thì ta sửa data LỚN thì nó ở sẵn đây mà
        $('.parent-edit-cate').addClass('hidden');//ẩn thẻ các thẻ div class=parent-edit-cate//tức là ẩn cái mục parent chuyên mục đi
        $('.parent-edit-cate select').html('');///thì nội dung thẻ select bên trong là trống
    }




  ///khi click vào 1 trong nút VỪA và nhỏ
    else if ($('#formEditCate .type-edit-cate-2:checked').prop("checked") == true) //Nếu checked dùng cho mục VỪA
    {
        $type_edit_cate = $('#formEditCate .type-edit-cate-2').val();///Lấy type ứng với data dùng checked là value=2

        $.ajax({///gọi ajax gửi nhận dữ liệu gửi loại type đã lick vào(ở đây là vừa) và id của data sửa
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_edit_parent_cate',
                type_edit_cate : $type_edit_cate,///type của data sửa
                id_edit_cate : $id_edit_cate///id của data sửa
            }, success : function(data) {
                $('.parent-edit-cate').removeClass('hidden');//hiện thẻ div.parent-edit-cate
                $('.parent-edit-cate select').html(data);//gán code hiển thị nhận được từ file xử lý  cho thẻ select trong div.parent-edit-cate  
            }, error : function() {
                $('.parent-edit-cate').removeClass('hidden');
                $('.parent-edit-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    } 



    else if ($('#formEditCate .type-edit-cate-3:checked').prop("checked") == true) ///nếu đang tích ở ô nhỏ//tức type của data sửa là NHỎ
    {
        $type_edit_cate = $('#formEditCate .type-edit-cate-3').val();///LẤY GIÁ TRỊ = 3
        $.ajax({
            type : 'POST',
            url : $_DOMAIN + 'categories.php',
            data : {
                action : 'load_edit_parent_cate',
                type_edit_cate : $type_edit_cate,
                id_edit_cate : $id_edit_cate
            }, success : function(data) {
                $('.parent-edit-cate').removeClass('hidden');///là thẻ div có class=parent-edit-cate nằm trong form#formEditCate
                $('.parent-edit-cate select').html(data);//thẻ select là thẻ nằm trong thẻ div trên
            }, error : function() {
                $('.parent-edit-cate').removeClass('hidden');
                $('.parent-edit-cate').html('Đã có lỗi xảy ra, hãy thử lại sau.');
            }
        });
    }
});







// Chỉnh sửa chuyên mục///Nhận data đã sửa ở form edit-categories và validate qua trước khi gửi cho file xử lý
$('#formEditCate button').on('click', function() {///khi click vào nút Lưu nhé
    $this = $('#formEditCate button');//TẠO HIỆU ỨNG "ĐANG TẢI..." cho nút lưu
    $this.html('Đang tải ...');

    // Gán các giá trị trong các biến
    $label_edit_cate = $('#formEditCate #label_edit_cate').val();//lấy label
    $url_edit_cate = $('#formEditCate #url_edit_cate').val();///lấy url
    $type_edit_cate = $('#formEditCate input[name="type_edit_cate"]:radio:checked').val();//lấy type ứng với mục được checked
    $parent_edit_cate = $('#formEditCate #parent_edit_cate').val();//giá trị  nội dung của thẻ select(thực ra là value của thẻ option được chọn trong thẻ select)
    $sort_edit_cate = $('#formEditCate #sort_edit_cate').val();
    $id_edit_cate = $('#formEditCate').attr('data-id');///id của data sửa

    // Nếu các giá trị rỗng
    if ($label_edit_cate == '' || $url_edit_cate == '' || $type_edit_cate == '' || $sort_edit_cate == '')
    {
        $('#formEditCate .alert').removeClass('hidden');
        $('#formEditCate .alert').html('Vui lòng điền đầy đủ thông tin.');
        $this.html('Lưu thay đổi');
    }
    // Ngược lại
    else
    {
        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                label_edit_cate : $label_edit_cate,
                url_edit_cate : $url_edit_cate,
                type_edit_cate : $type_edit_cate,
                parent_edit_cate : $parent_edit_cate,
                sort_edit_cate : $sort_edit_cate,
                id_edit_cate : $id_edit_cate,
                action : 'edit_cate'
            }, success : function(data) {///chạy code hiển thị đã chạy được ở thẻ có id#formEditCate class=alert
                $('#formEditCate .alert').removeClass('hidden');
                $('#formEditCate .alert').html(data);
                $this.html('Lưu thay đổi');
            }, error : function() {
                $('#formEditCate .alert').removeClass('hidden');
                $('#formEditCate .alert').html('Không thể chỉnh sửa chuyên mục vào lúc này, hãy thử lại sau.');
                $this.html('Lưu thay đổi');
            }
        });
    }
});









// bài 9.3  

// Checkbox all///CÁI NÀY DÙNG CHO CẢ KHI TA CHỌN/BỎ CHỌN TẤT CẢ KHI XÓA ẢNH NHÉ_Ở BÀI 11

// đối tượng tác động là những  thẻ này  // <td><input type="checkbox"></td>//thẻ input đầu tiên  của thẻ table có class=list
$('.list input[type="checkbox"]:eq(0)').change(function() {
//Hàm change()/////giá trị của  input_checkbox đầu tiên thay đổi thì hàm trong change sẽ thay đổi
// Hàm change() dùng để gắn hành động cho sự kiện thay đổi giá trị trên các thẻ select, textarea, input.. Nó có một tham số truyền vào, đó chính là hàm sẽ được gọi khi giá trị của các thẻ đó bị thay đổi. Ví dụ dưới đây sẽ hiển thị một thông báo khi bạn chọn thành phố trong select box.


    $('.list input[type="checkbox"]').///lấy tất cả input[type="checkbox"]

    // $this trong jquery chính là đối tượng ta đang dùng hàm tác động lên nó
///gọi thuộc tính checked ra và gán nó vào tất cả đối tượng này (chính là $(this))//đây là gán giá trị này "$(this).prop("checked")"
  

//$this chính là input[type="checkbox"]:eq(0)//vì đối tượng này lúc này nếu được tích sẽ là true còn ko được tích sẽ là false
    prop('checked', $(this).prop("checked"));
    //prop để gọi thuộc tính checkvà gán giá trị true của checked (giá trị này là của thẻ input[type="checkbox"]:eq(0) vì thẻ này đã được dùng checked)
});



// Xoá nhiều chuyên mục cùng lúc///bài 9//khi ta đã checked tất cả checkbox
$('#del_cate_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các chuyên mục đã chọn không?');
    if ($confirm == true)//nếu chắc chắn và bấm xóa
    {
        $id_cate = [];///khai báo mảng chứa id
//i chỉ là biến để đánh số index các phần tử tác động thôi
        $('#list_cate input[type="checkbox"]:checkbox:checked').each(function(i) {///lấy id trong từng checkbox có checked ra đưa từng id vào trong mảng $id_cate
            $id_cate[i] = $(this).val();///đưa từng giá giá trị id của từng data(các mảng này sẽ bị xóa) vào trong mảng $id_cate
        });///vậy là ta được mảng $id_cate///i từ đối tượng đầu tiên thì tính là 0

        if ($id_cate.length === 0)///nếu ta ko chọn data nào//tức là mảng ko có id được gửi đi
        {
            alert('Vui lòng chọn ít nhất một chuyên mục.');
        }
        else
        {
            $.ajax({//gọi gửi nhận ajax
                url : $_DOMAIN + 'categories.php',
                type : 'POST',
                data : {
                    id_cate : $id_cate,//gửi mảng id
                    action : 'delete_cate_list'//gửi chuỗi này để nhận biết hành động
                },
                success : function(data) {
                    location.reload();//load lại trang web thi nhận được data đã xử lý
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;///nếu bấm nút ko muốn xóa //thì đóng của sổ confirm
    }
});





///bài 9//xóa chuyên mục chỉ định

// Xoá chuyên mục chỉ định trong bảng danh sách
$('.del-cate-list').on('click', function() {///khi click vào thẻ a có class=del-cate-list//nút xóa bên cạnh nút edit
    $confirm = confirm('Bạn có chắc chắn muốn xoá chuyên mục này không?');
    if ($confirm == true)///nếu nhấn vào có
    {
        $id_cate = $(this).attr('data-id');///lấy giá trị của 'data-id nằm trong thẻ a có class=del-cate-list//$(this) chính là đối tượng làm xảy ra sự kiện

        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                id_cate : $id_cate,
                action : 'delete_cate'///xóa 1 chuyên mục riêng biệt//xóa bằng nút xóa bên cạnh nút edit
            },
            success : function() {
                location.reload();//tải lại trang
            }
        });
    }
    else
    {
        return false;
    }
});

// Xoá chuyên mục chỉ định trong trang chỉnh sửa//tức là khi ta vào chỉnh sửa 1 data chuyên mục nào đó thì ta sẽ có 2 nút là xóa và trở về ///nút xóa này có id=del_cate
//thực chất nút xóa đó là thẻ a có chứa data-id=$id sửa

$('#del_cate').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá chuyên mục này không?');
    if ($confirm == true)
    {
        $id_cate = $(this).attr('data-id');

        $.ajax({
            url : $_DOMAIN + 'categories.php',
            type : 'POST',
            data : {
                id_cate : $id_cate,
                action : 'delete_cate'///xóa nó bằng nút xóa trong trang edit
            },
            success : function() {
                location.href = $_DOMAIN + 'categories/';//chuyển hướng trở lại trang list categories
            }
        });
    }
    else
    {
        return false;
    }
});






//bài 10//viết ajax gửi dữ liệu ảnh//khi khác xem lại




// Xem ảnh trước
function preUpImg() {
    img_up = $('#img_up').val();///lấy ảnh//id=img_up của thẻ input="Chọn tệp"///tức là giá trị của thẻ input="chọn tệp"
    count_img_up = $('#img_up').get(0).files.length;
    $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');///<div class="form-group box-pre-img hidden"> thẻ div ẩn này của form nhé
    $('#formUpImg .box-pre-img').removeClass('hidden');

    // Nếu đã chọn ảnh
    if (img_up != '')
    {
        $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
        $('#formUpImg .box-pre-img').removeClass('hidden');
        for (i = 0; i <= count_img_up - 1; i++)
        {
            $('#formUpImg .box-pre-img').append('<img src="' + URL.createObjectURL(event.target.files[i]) + '" style="border: 1px solid #ddd; width: 50px; height: 50px; margin-right: 5px; margin-bottom: 5px;"/>');
        }
    } 
    // Ngược lại chưa chọn ảnh
    else
    {
        $('#formUpImg .box-pre-img').html('');
        $('#formUpImg .box-pre-img').addClass('hidden');
    }
}

// Nút reset form  hình ảnh
$('#formUpImg button[type=reset]').on('click', function() {
    $('#formUpImg .box-pre-img').html('');
    $('#formUpImg .box-pre-img').addClass('hidden');
});

// Upload hình ảnh
$('#formUpImg').submit(function(e) {
    img_up = $('#img_up').val();
    count_img_up = $('#img_up').get(0).files.length;
    error_size_img = 0;
    error_type_img = 0;
    $('#formUpImg button[type=submit]').html('Đang tải ...');

    // Nếu có chọn ảnh
    if (img_up) {
        e.preventDefault();
        
        // Kiểm tra dung lượng ảnh
        for (i = 0; i <= count_img_up - 1; i++)
        {
            size_img_up = $('#img_up')[0].files[i].size;
            if (size_img_up > 5242880) { // 5242880 byte = 5MB 
                error_size_img += 1; // Lỗi
            } else {
                error_size_img += 0; // Không lỗi
            }
        }

        // Kiểm tra định dạng ảnh
        for (i = 0; i <= count_img_up - 1; i++)
        {
            type_img_up = $('#img_up')[0].files[i].type;
            if (type_img_up == 'image/jpeg' || type_img_up == 'image/png' || type_img_up == 'image/gif') {
                error_type_img += 0;
            } else {
                error_type_img += 1;
            }
        }

        // Nếu lỗi về size ảnh
        if (error_size_img >= 1) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Một trong các tệp đã chọn có dung lượng lớn hơn mức cho phép.');
        // Nếu số lượng ảnh vượt quá 20 file
        } else if (count_img_up > 20) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Số file upload cho mỗi lần vượt quá mức cho phép.');
        } else if (error_type_img >= 1) {
            $('#formUpImg button[type=submit]').html('Upload');
            $('#formUpImg .alert').removeClass('hidden');
            $('#formUpImg .alert').html('Một trong những file ảnh không đúng định dạng cho phép.');
        } else {
            $(this).ajaxSubmit({ 
                beforeSubmit: function() {
                    target:   '#formUpImg .alert', 
                    $("#formUpImg .box-progress-bar").removeClass('hidden');
                    $("#formUpImg .progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){ 
                    $("#formUpImg .progress-bar").animate({width: percentComplete + '%'});
                    $("#formUpImg .progress-bar").html(percentComplete + '%');
                },
                success: function (data) {     
                    $('#formUpImg button[type=submit]').html('Upload');
                    $('#formUpImg .alert').attr('class', 'alert alert-success'); 
                    $('#formUpImg .alert').html(data);
                },
                error: function() {
                    $('#formUpImg button[type=submit]').html('Upload');
                    $('#formUpImg .alert').removeClass('hidden');  
                    $('#formUpImg .alert').html('Không thể upload hình ảnh vào lúc này, hãy thử lại sau.');
                },
                resetForm: true 
            }); 
            return false;
        }
    // Ngược lại không chọn ảnh
    } else {
        $('#formUpImg button[type=submit]').html('Upload');
        $('#formUpImg .alert').removeClass('hidden');
        $('#formUpImg .alert').html('Vui lòng chọn tệp hình ảnh.');
    }
});

///kết thúc bài 10 nhé_khi khác rồi xem lại sau






//BÀI 11 : BẮT SỰ KIỆN XÓA NHIỀU  ẢNH

// Xoá nhiều hình ảnh cùng lúc
$('#del_img_list').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá các hình ảnh đã chọn không?');
    if ($confirm == true)
    {
        $id_img = [];

        $('#list_img input[type="checkbox"]:checkbox:checked').each(function(i) {
            $id_img[i] = $(this).val();
        });

        if ($id_img.length === 0)
        {
            alert('Vui lòng chọn ít nhất một hình ảnh.');
        }
        else
        {
            $.ajax({
                url : $_DOMAIN + 'photos.php',
                type : 'POST',
                data : {
                    id_img : $id_img,
                    action : 'delete_img_list'
                },
                success : function(data) {
                    location.reload();
                }, error : function() {
                    alert('Đã có lỗi xảy ra, hãy thử lại.');
                }
            });
        }
    }
    else
    {
        return false;
    }
  
});



// Xoá ảnh chỉ định
$('.del-img').on('click', function() {
    $confirm = confirm('Bạn có chắc chắn muốn xoá ảnh này không?');
    if ($confirm == true)
    {
        $id_img = $(this).attr('data-id');
 
        $.ajax({
            url : $_DOMAIN + 'photos.php',
            type : 'POST',
            data : {
                id_img : $id_img,
                action : 'delete_img'
            },
            success : function() {
                location.reload();
            }
        });
    }
    else
    {
        return false;
    }
});







///bài 12
// Thêm bài viết
$('#formAddPost button').on('click', function() {///khi click vào nút tạo


    $title_add_post = $('#title_add_post').val();//lấy value input điền tiêu đề
    $slug_add_post = $('#slug_add_post').val();//lấy giá trị slug
 
    if ($title_add_post == '' || $slug_add_post == '') {
        $('#formAddPost .alert').removeClass('hidden');
        $('#formAddPost .alert').html('Vui lòng điền đầy đủ thông tin.');
    } else {
        $.ajax({
            url : $_DOMAIN + 'posts.php',///địa chỉ xử lý data
            type : 'POST',
            data : {
                title_add_post : $title_add_post,
                slug_add_post : $slug_add_post,
                action : 'add_post'
            }, success : function(data) {
                $('#formAddPost .alert').html(data);///sử dụng data hiển thị nhận được
            }, error : function() {
                $('#formAddPost .alert').removeClass('hidden');
                $('#formAddPost .alert').html('Đã có lỗi xảy ra, hãy thử lại.');
            }
        });
    }
});






///bài 13// chức nắng tìm kiếm bài viết
// Tìm kiếm bài viết///nếu click vào button của form tìm kiếm (trong templates/posts.php)
$('#formSearchPost button').on('click', function() {




    $kw_search_post = $('#kw_search_post').val();///nhận giá trị từ input
 
    if ($kw_search_post != '') {
        $.ajax({
            url : $_DOMAIN + 'posts.php',
            type : 'POST',
            data : {
                kw_search_post : $kw_search_post,
                action : 'search_post'
            }, success : function(data) {
                $('#list_post').html(data);
                $('#paging_post').hide();
            }
        });
    }
});
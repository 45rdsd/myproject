// Bắt sự kiện khi click vào nút tạo
$('#submit_create_note').on('click', function() {
	// Gán các giá trị trong form tạo note vào các biến
	$title_create_note = $('#title_create_note').val();
	$body_create_note = $('#body_create_note').val();
	$ac = 'create'; // Hành động

	// Nếu một trong các biến này rỗng
	if ($title_create_note == '' || $title_create_note == '')
	{
		// Hiển thị thông báo lỗi
		$('#formCreateNote .alert').removeClass('hidden');
		$('#formCreateNote .alert').html('Vui lòng điền đầy đủ thông tin bên trên.');
	}
	// Ngược lại
	else
	{
		// Thực thi gửi dữ liệu bằng Ajax
		$.ajax({
			url : 'note.php', // Đường dẫn file nhận dữ liệu
			type : 'POST', // Phương thức gửi dữ liệu
			// Các dữ liệu
			data : {
				title_create_note : $title_create_note,
				body_create_note : $body_create_note,
				ac : $ac
			// Thực thi khi gửi dữ liệu thành công
			}, success : function(data) {
				$('#formCreateNote .alert').removeClass('hidden');
				$('#formCreateNote .alert').html(data);
			}
		});
	}
});

// Bắt sự kiện khi click vào nút Sửa
$('#submit_edit_note').on('click', function() {
	// Gán các giá trị trong form tạo note vào các biến
	$title_edit_note = $('#title_edit_note').val();
	$body_edit_note = $('#body_edit_note').val();
	$ac = 'edit'; // Hành động
	$id_edit_note = $('#id_edit_note').val(); // Lấy ID trong field ẩn//của file edit-note-form

	// Nếu một trong các biến này rỗng
	if ($title_edit_note == '' || $title_edit_note == '')
	{
		// Hiển thị thông báo lỗi
		$('#formEditNote .alert').removeClass('hidden');
		$('#formEditNote .alert').html('Vui lòng điền đầy đủ thông tin bên trên.');
	}
	// Ngược lại
	else
	{
		// Thực thi gửi dữ liệu bằng Ajax
		$.ajax({
			url : 'note.php', // Đường dẫn file nhận dữ liệu
			type : 'POST', // Phương thức gửi dữ liệu
			// Các dữ liệu
			data : {
				title_edit_note : $title_edit_note,
				body_edit_note : $body_edit_note,
				ac : $ac,
				id_edit_note : $id_edit_note
			// Thực thi khi gửi dữ liệu thành công
			}, success : function(data) {
				$('#formEditNote .alert').html(data);
			}
		});
	}
});






// Bắt sự kiện khi click vào nút Xoá
$('#submit_delete_note').on('click', function() {
	$ac = 'delete'; // Hành động//tạo biến $ac
	$id_edit_note = $('#id_edit_note').val(); // Lấy ID trong field ẩn//id trong trường này có thẻ bị hacker thay đổi

	// Thực thi gửi dữ liệu bằng Ajax
	$.ajax({
		url : 'note.php', // Đường dẫn file nhận dữ liệu
		type : 'POST', // Phương thức gửi dữ liệu
		// Các dữ liệu
		data : {
			ac : $ac,
			id_edit_note : $id_edit_note
		// Thực thi khi gửi dữ liệu thành công
		}, success : function(data) {
			$('#a .alert').html(data);//kết quả hiển thị thu được từ file note.php khi click vào nút đồng ý
			// sẽ được đưa vào thẻ div#modalDeleteNote .alert của file footer để tiếp tục chạy hiển thị bên đó
		}
	});
});
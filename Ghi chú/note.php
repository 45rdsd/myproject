<?php

// Kết nối database, session, general info
require_once 'core/init.php';

// Nếu không tồn tại $user
if (!$user)
{
	header('Location: index.php'); // Di chuyển đến trang chủ
}

// Nếu tồn tại hành động nào đó gửi đến//ac rỗng thì chẳng hiện gì đâu //ta lại dùng giá trị $id_edit_note ở file note.js
if (isset($_POST['ac']))
{	
	$ac = $_POST['ac'];
	// Nếu hành động là create
	if ($ac == 'create')
	{
		// Nhận dữ liệu và gán vào các biến đồng thời xử lý chuỗi
		$title_create_note = $db->real_escape_string(@$_POST['title_create_note']);
		$body_create_note = $db->real_escape_string(@$_POST['body_create_note']);

		$title_create_note = trim(htmlentities($title_create_note));
		$body_create_note = htmlentities($body_create_note);

		// Các biến chứa code JS về thông báo
		$show_alert = "<script>$('#formCreateNote .alert').removeClass('hidden');</script>";
		$hide_alert = "<script>$('#formCreateNote .alert').addClass('hidden');</script>";
		$success_alert = "<script>$('#formCreateNote .alert').attr('class', 'alert alert-success');</script>";

		// Lệnh SQL tạo note
		$sql_create_note = "INSERT INTO notes VALUES (
			'',
			'$data_user[id_user]',
			'$title_create_note',
			'$body_create_note',
			'$date_current'
		)";
		// Thực thi truy vấn
		$db->query($sql_create_note);

		// Hiển thị thông báo và di chuyển đến trang edit của note vừa tạo
		echo $show_alert.$success_alert." Tạo note thành công
			<script>
				location.href = 'index.php?ac=edit_note&&id=".$db->insert_id()."';
			</script>
		";
	}
	// Nếu hành động là edit//nhận dữ liệu để edit
	else if ($ac == 'edit')
	{
		// Nhận dữ liệu và gán vào các biến đồng thời xử lý chuỗi//gửi chuỗi xuống mysql để xử lý các ký tự đặc biệt của chuỗi//lát sẽ update vào database đó
		$title_edit_note = $db->real_escape_string(@$_POST['title_edit_note']);
		$body_edit_note = $db->real_escape_string(@$_POST['body_edit_note']);
		$id_edit_note = $db->real_escape_string(@$_POST['id_edit_note']);

		$title_edit_note = trim(htmlentities($title_edit_note));//giữ số lượng những khoảng trắng ở giữa //sau đó xóa khoảng trắng ở đầu và cuối chuỗi mới đó
		$body_edit_note = htmlentities($body_edit_note);//giữ số lượng khoảng trắng
		$id_edit_note = trim(htmlentities($id_edit_note));////giữ số lượng những khoảng trắng ở giữa //sau đó xóa khoảng trắng ở đầu và cuối chuỗi mới đó

		// Các biến chứa code JS về thông báo có thẻ là thêm hoặc xóa 1 giá trị thuộc tính trong class hoặc gán giá trị mới hẳn
		$show_alert = "<script>$('#formEditNote .alert').removeClass('hidden');</script>";
		$hide_alert = "<script>$('#formEditNote .alert').addClass('hidden');</script>";
		$success_alert = "<script>$('#formEditNote .alert').attr('class', 'alert alert-success');</script>";



//vì hacker có thể tha đổi giá trị value= $data_note['id_note'] của thẻ input#id_edit_note của file edit-note-form thành mã độc để chúng truyền giá trị đó vào database để hack dữ liệu của chúng ta .nên chúng ta phải kiểm tra lại là với giá trị $id_edit_note lúc này liệu rằng có khớp với id_note của bản note đang sửa hay không. 

		// Lệnh SQL kiểm tra có tồn tại ID note	

		$sql_check_id_exist = "SELECT id_note, user_id FROM notes WHERE user_id = '$data_user[id_user]' AND id_note = '$id_edit_note'";



		// Nếu có (tức là id hợp lệ ko bị sửa đi)
		if ($db->num_rows($sql_check_id_exist))
		{

			// Lệnh SQL chỉnh sửa note
			$sql_edit_note = "UPDATE notes SET
				body = '$body_edit_note',
				title = '$title_edit_note' 
				WHERE user_id = '$data_user[id_user]' AND id_note = '$id_edit_note'
			";
			// Thực thi truy vấn//tiến hành upload data mới vào database
			$db->query($sql_edit_note);
			// Giải phóng kết nối//ngắt kết nối
			$db->close();

			// Hiển thị thông báo và tải lại trang
			echo $show_alert.$success_alert." Đã chỉnh sửa note
				<script>
					location.reload();	
				</script>
			";
		}
		// Ngược lại không 
		else
		{
			// Hiển thị thông báo lỗi//nếu bị sửa giá trị value của thẻ input thành giá trị mã độc
			echo $show_alert.'Bạn đã cố tình sửa chữa ID note, nhưng rất tiếc ID note này không tồn tại hoặc không thuộc quyền sở hữu của bạn._Note.php nhé';
		}

		//nội dung code kết quả hiển thị của lệnh echo sẽ được đưa vào hiển thị tại file edit-note-form ở thẻ div#alert
	}





	// Nếu hành động là delete
	else if ($ac == 'delete')
	{
		// Nhận dữ liệu và gán vào các biến đồng thời xử lý chuỗi//xử lý các ký tự đặc biệt trong giá trị @$_POST['id_edit_note'] nếu có
		$id_edit_note = $db->real_escape_string(@$_POST['id_edit_note']);
		$id_edit_note = trim(htmlentities($id_edit_note));

		// Các biến chứa code JS về thông báo//div chứa là là div#modalDeleteNote.alert ở file footer.php
		$show_alert = "<script>$('#a .alert').removeClass('hidden');</script>";
		$hide_alert = "<script>$('#a .alert').addClass('hidden');</script>";
		$success_alert = "<script>$('#a .alert').attr('class', 'alert alert-success');</script>";
			
		// Lệnh SQL kiểm tra có tồn tại ID note và thuộc quyền sở hữu//phòng trường hợp hacker sửa value của thẻ "<input type="hidden" value="mã độc" id="id_edit_note">" thành các mã độc
		$sql_check_id_exist = "SELECT id_note, user_id FROM notes WHERE user_id = '$data_user[id_user]' AND id_note = '$id_edit_note'";

		// Nếu có//tức là ko bị sửa thành giá trị có hại
		if ($db->num_rows($sql_check_id_exist))
		{
			// Lệnh SQL xoá note//bản note này của user đang đăng nhập và có id cần xóa
			$sql_delete_note = "DELETE FROM notes WHERE user_id = '$data_user[id_user]' AND id_note = '$id_edit_note'";
			// Thực thi truy vấn//xóa
			$db->query($sql_delete_note);
			// Giải phóng kết nối
			$db->close();

			// Hiển thị thông báo và trở về trang chủ
			echo $show_alert.$success_alert." Xoá note thành công.
				<script>
					location.href = 'index.php';
				</script>
			";
		}
		// Ngược lại không 
		else
		{
			// Hiển thị thông báo lỗi
			echo $show_alert.'Bạn đã cố tình sửa chữa ID note, nhưng rất tiếc ID note này không tồn tại hoặc không thuộc quyền sở hữu của bạn._delete nhé';
		}
	}
}

//nội dung code hiển thị của echo thu được (tức là kết quả hiển thị thu được khi chạy file này) sẽ gửi lại sang file note.js để xử lý tiếp

?>

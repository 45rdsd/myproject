<?php

// Lệnh SQL lấy dữ liệu note theo ID//lấy data note ra để điền vào form //lấy ra record note ứng với url rồi điền vào form ở dưới luôn

//lúc này thẻ input#id_edit_note sẽ có value= $data_note['id_note'] (id_note của note đang muốn sửa)
$sql_get_data_note = "SELECT * FROM notes WHERE user_id = '$data_user[id_user]' AND id_note = '$get_id'";



///$get_id được lấy từ khi ta tạo xong 1 note mới khi đó tự động chuyển sang file index với id của note và biến ac=edit (địa chỉ là url lúc đó sẽ có những thông số này)
//lấy record trong bảng notes mà record đó phải có đặc điểm là giá trị 2 cột user_id và id_note lần lượt là id của user đang login và giá trị biến id trên url (tức là $get_id)

// Lấy dữ liệu//vì sẽ chỉ có 1 bản note được lấy ra thôi
$data_note = $db->fetch_assoc($sql_get_data_note, 1);

$date_created = $data_note['date_created'];
	$day_created = substr($date_created, 8, 2); // Ngày tạo
	$month_created = substr($date_created, 5, 2); // Tháng tạo
	$year_created = substr($date_created, 0, 4); // Năm tạo
	$hour_created = substr($date_created, 11, 2); // Giờ tạo
	$min_created = substr($date_created, 14, 2); // Phút tạo

?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-primary">Chỉnh sửa note</h3>
			<div class="alert alert-info">Đã tạo vào ngày
			<?php
				// Hiển thị ngày tháng tạo
				echo $day_created.' tháng
					 '.$month_created.' năm
					 '.$year_created.' lúc
					 '.$hour_created.':'.$min_created;
			?>
			</div>
			<form method="POST" onsubmit="return false;" id="formEditNote">
				<div class="form-group">
	    			<label for="user_signin">Tiêu đề</label>
	    			<input type="text" class="form-control" id="title_edit_note" value="<?php echo $data_note['title'];  ?>">
	  			</div>
	  			<div class="form-group">
	    			<label for="pass_signin">Nội dung</label>
	    			<textarea class="form-control" id="body_edit_note" rows="5"><?php echo $data_note['body'];  ?></textarea>
	  			</div>
	  			<input type="hidden" value="<?php echo $data_note['id_note']; ?>" id="id_edit_note">
	  			<a href="index.php" class="btn btn-default">
					<span class="glyphicon glyphicon-arrow-left"></span> Trở về
				</a>




	  			<button class="btn btn-danger pull-right" data-toggle="modal" data-target="#a">
	  				<!-- data-target="#myModal" là dùng để xác định popup nào được gọi (nếu có nhiều popup trên cùng trang), trong ví dụ trên là popup có id là #myModal -->
	  				<!-- Khi click vào button này sẽ hiển thị nội dung của thẻ div có id="modalDeleteNote" (ở đây chính là file footer.php ) với nội dung hiển thị dưới popup  -->
					<span class="glyphicon glyphicon-trash"></span> Xoá note nè
				</button>



	  			<button class="btn btn-primary" id="submit_edit_note">
					<span class="glyphicon glyphicon-ok"></span> Lưu_oke nhé
				</button>

	  			<br><br>
	  			<div class="alert alert-danger hidden">ở đây</div>
			</form>
		</div>
	</div>
</div>
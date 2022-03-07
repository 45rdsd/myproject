<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3 class="text-primary">Tạo note mới</h3>
			<form method="POST" onsubmit="return false;" id="formCreateNote">
				<div class="form-group">
	    			<label for="user_signin">Tiêu đề</label>
	    			<input type="text" class="form-control" id="title_create_note">
	  			</div>
	  			<div class="form-group">
	    			<label for="pass_signin">Nội dung</label>
	    			<textarea class="form-control" id="body_create_note" rows="5"></textarea>
	  			</div>
	  			<a href="index.php" class="btn btn-default">
	  				<span class="glyphicon glyphicon-arrow-left"></span> Trở về
	  			</a>
	  			<button class="btn btn-primary" id="submit_create_note">
	  				<span class="glyphicon glyphicon-ok"></span> Tạo note
	  			</button>
	  			<br><br>
	  			<div class="alert alert-danger hidden"></div>
			</form>
		</div>
	</div>
</div>
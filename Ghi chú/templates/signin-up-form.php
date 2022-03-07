<div class="container">
	<div class="row">
		<div class="col-md-5">
			<h3 class="text-primary">Đăng nhập</h3>
			<form method="POST" onsubmit="return false;" id="formSignin">
				<div class="form-group">
	    			<label for="user_signin">Tên đăng nhập</label>
	    			<input type="text" class="form-control" id="user_signin">
	  			</div>
	  			<div class="form-group">
	    			<label for="pass_signin">Mật khẩu</label>
	    			<input type="password" class="form-control" id="pass_signin">
	  			</div>
	  			<button class="btn btn-primary" id="submit_signin">Đăng nhập</button>
	  			<br><br>
	  			<div class="alert alert-danger hidden"></div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<h3 class="text-success">Đăng ký tài khoản</h3>
			<p class="text-danger">* Vui lòng nhập đầy đủ thông tin dưới đây để đăng ký tài khoản :</p>
			<form method="POST" onsubmit="return false;" id="formSignup">
				<div class="form-group">
	    			<input type="text" class="form-control" placeholder="Tên đăng nhập" id="user_signup">
	  			</div>
	  			<div class="form-group">
	    			<input type="password" class="form-control" placeholder="Mật khẩu" id="pass_signup">
	  			</div>
	  			<div class="form-group">
	    			<input type="password" class="form-control" placeholder="Nhập lại mật khẩu" id="repass_signup">
	  			</div>
	  			<button class="btn btn-success" id="submit_signup">Tạo tài khoản</button>
	  			<br><br>
	  			<div class="alert alert-danger hidden"></div>
			</form>
		</div>
	</div>
</div>
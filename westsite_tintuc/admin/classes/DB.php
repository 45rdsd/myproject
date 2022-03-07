<?php

// Lớp database
class DB
{
	// Các biến thông tin kết nối
	private $hostname = 'localhost',
			$username = 'root',
			$password = '',
			$dbname = 'newspaper';

	// Biến lưu trữ kết nối// Biến lưu trữ kết nối//sẽ dùng cho tất cả các hàm bên dưới nên đây sẽ là biến toàn cục
	public $cn = NULL;

	// Hàm kết nối
	public function connect()
	{
		$this->cn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
	}

	// Hàm ngắt kết nối
	public function close()
	{
	    if ($this->cn)
	    {
	        mysqli_close($this->cn);
	    }
	}

	// Hàm truy vấn
	public function query($sql = null) 
	{		
	    if ($this->cn)
	    {
			mysqli_query($this->cn, $sql);
	    }
	}

	// Hàm đếm số hàng
	public function num_rows($sql = null) 
	{
		$query = mysqli_query($this->cn, $sql);
		if ($query)
		{
			$row = mysqli_num_rows($query);
			return $row;
		}			
	}

	// Hàm lấy dữ liệu
	public function fetch_assoc($sql = null, $type)
	{
		if ($this->cn)
		{
			$query = mysqli_query($this->cn, $sql);
			if ($query)
			{
				if ($type == 0)
				{
					// Lấy nhiều dữ liệu gán vào mảng
					while ($row = mysqli_fetch_assoc($query))
					{
						$data[] = $row;
					}
					return $data;
				}
				else if ($type == 1)
				{
					// Lấy một hàng dữ liệu gán vào biến
					$data = mysqli_fetch_assoc($query);
					return $data;
				}
			}		
		}
	}


	// Hàm lấy ID cao nhất
	public function insert_id() {
		if ($this->cn)
		{
			$count = mysqli_insert_id($this->cn);//hàm này để lấy id của data vừa được thao tác với database
			if ($count == '0')//nếu id của data vừa insert =0 thì ta chuyển thành 1
			{
				$count = '1';//gán bẳng 1
			}
			else
			{
				$count = $count ;
			}
			return $count;
		}
	}

	// Hàm chọn charset cho database
	public function set_char($uni) {
		if ($this->cn)
		{
			mysqli_set_charset($this->cn, $uni);
		}
	}
}

?>
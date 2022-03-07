<?php
 
// Lớp session
class Session {
    // Hàm bắt đầu session
    public function start()
    {
        session_start();
    }
 
    // Hàm lưu session//tạo ra session  
    public function send($user)
    {
        $_SESSION['user'] = $user;
    }
 
    // Hàm lấy dữ liệu session
    public function get() 
    {
        if (isset($_SESSION['user']))//kiểm tra biến này tồn tại và có giá trị hay chưa
        {
            $user = $_SESSION['user'];
        }
        else//ngược lại nếu chưa tồn tại hoặc mang giá trị null
        {
            $user = '';
        }
        return $user;
    }
 
    // Hàm xoá session
    public function destroy() 
    {
        session_destroy();
    }
}
 
?>
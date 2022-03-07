<?php
 
// Hàm điều hướng trang
class Redirect {
    public function __construct($url = null) {
        if ($url)
        {
            echo '<script>location.href="'.$url.'";</script>';//nếu có url thì sẽ chuyển trang web sang địa chỉ là url
        }
    }
}
 
?>
<?php
class HomeController {
    public function index() {
        echo "<h1>Trang chủ (Giả lập)</h1>";
        echo "<p><a href='index.php?controller=course&action=index'>Vào trang Quản lý Khóa học (Giảng viên)</a></p>";
    }
}
?>
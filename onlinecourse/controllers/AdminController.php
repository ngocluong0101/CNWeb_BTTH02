<?php
// session_start();

class AdminController {

    // Hàm kiểm tra quyền admin (dùng chung)
    private function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
            header("Location: /cse485/CNWeb_BTTH02/onlinecourse/login");
            exit;
        }
    }

    // Dashboard admin
    public function dashboard() {
        $this->checkAdmin();
        include "views/admin/dashboard.php";
    }

    // Quản lý tài khoản người dùng
    public function users() {
        $this->checkAdmin();

        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $users = $userModel->getAll();

        include "views/admin/users/manage.php";
    }

    // Khóa / mở tài khoản người dùng
    public function updateUserStatus() {
        $this->checkAdmin();

        if (!isset($_GET['id'], $_GET['status'])) {
            header("Location: /cse485/CNWeb_BTTH02/onlinecourse/admin/users");
            exit;
        }

        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $userModel->updateStatus($_GET['id'], $_GET['status']);

        header("Location: /cse485/CNWeb_BTTH02/onlinecourse/admin/users");
    }

    // Đổi role người dùng
    public function updateUserRole() {
        $this->checkAdmin();

        if (!isset($_POST['id'], $_POST['role'])) {
            header("Location: /cse485/CNWeb_BTTH02/onlinecourse/admin/users");
            exit;
        }

        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $userModel->updateRole($_POST['id'], $_POST['role']);

        header("Location: /cse485/CNWeb_BTTH02/onlinecourse/admin/users");
    }
}

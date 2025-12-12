<?php
class AuthController {

    public function loginPage() {
        include "views/auth/login.php";
    }

    public function registerPage() {
        include "views/auth/register.php";
    }

    public function login() {
        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $u = $userModel->findUser($_POST["username"]);

        if ($u && password_verify($_POST["password"], $u["password"])) {
            $_SESSION["user"] = $u;

            if ($u["role"] == 2) header("Location: admin/users");
            if ($u["role"] == 1) echo "Instructor dashboard (tạo sau)";
            if ($u["role"] == 0) echo "Student dashboard (tạo sau)";
            exit;
        }

        $error = "Sai tài khoản hoặc mật khẩu!";
        include "views/auth/login.php";
    }

    public function register() {
        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $ok = $userModel->register(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['fullname']
        );

        if ($ok) {
            header("Location: /cse485/CNWeb_BTTH02/onlinecourse/login");
        } else {
            $error = "Đăng ký thất bại!";
            include "views/auth/register.php";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /cse485/CNWeb_BTTH02/onlinecourse/login");
    }
}

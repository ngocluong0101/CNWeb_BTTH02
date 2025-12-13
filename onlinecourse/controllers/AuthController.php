<?php
class AuthController {

    public function loginPage() {
        include "views/auth/login.php";
    }

    public function registerPage() {
        include "views/auth/register.php";
    }

    public function login() {

        // ✅ CHỐNG LỖI: truy cập trực tiếp /auth/login hoặc chưa submit form
        if (!isset($_POST['username'], $_POST['password'])) {
            header("Location: /cse485/CNWeb_BTTH02/onlinecourse/login");
            exit;
        }

        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $u = $userModel->findUser($_POST["username"]);

        if ($u && password_verify($_POST["password"], $u["password"])) {
            $_SESSION["user"] = $u;

            if ($u["role"] == 2)
                header("Location: /cse485/CNWeb_BTTH02/onlinecourse/admin/users");
            elseif ($u["role"] == 1)
                echo "Instructor dashboard (tạo sau)";
            else
                echo "Student dashboard (tạo sau)";

            exit;
        }

        $error = "Sai tài khoản hoặc mật khẩu!";
        include "views/auth/login.php";
    }

    public function register() {

        // (không bắt buộc, nhưng thêm thì rất sạch)
        if (!isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['fullname'])) {
            header("Location: /cse485/CNWeb_BTTH02/onlinecourse/register");
            exit;
        }

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

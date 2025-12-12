<?php
session_start();

class AuthController {

    public function loginPage() {
        include "./views/auth/login.php";
    }

    public function login() {
        require "./config/Database.php";
        require "./models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = $userModel->findUser($username);

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['user'] = $data;

            // Điều hướng theo role
            switch ($data['role']) {
                case 0: header("Location: /student/dashboard.php"); break;
                case 1: header("Location: /instructor/dashboard.php"); break;
                case 2: header("Location: /admin/dashboard.php"); break;
            }
            exit();
        }

        $error = "Sai tài khoản hoặc mật khẩu";
        include "./views/auth/login.php";
    }

    public function registerPage() {
        include "./views/auth/register.php";
    }

    public function register() {
        require "./config/Database.php";
        require "./models/User.php";

        $db = (new Database())->connect();
        $user = new User($db);

        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $user->fullname = $_POST['fullname'];
        $user->password = $_POST['password'];
        $user->role = 0;  // mặc định học viên

        if ($user->register()) {
            header("Location: /login");
        } else {
            $error = "Đăng ký thất bại";
            include "./views/auth/register.php";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
    }
}

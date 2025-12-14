<?php

// Bật error reporting (TẮT trong production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set UTF-8 encoding
header('Content-Type: text/html; charset=UTF-8');

// Start session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = isset($_GET['url']) ? $_GET['url'] : '';

function requireRole($role) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != $role) {
        header("Location: /cse485/CNWeb_BTTH02/onlinecourse/login");
        exit;
    }
}

switch ($url) {

    // ===== AUTH =====
    case "":
    case "login":
        require "controllers/AuthController.php";
        (new AuthController())->loginPage();
        break;

    case "auth/login":
        require "controllers/AuthController.php";
        (new AuthController())->login();
        break;

    case "register":
        require "controllers/AuthController.php";
        (new AuthController())->registerPage();
        break;

    case "auth/register":
        require "controllers/AuthController.php";
        (new AuthController())->register();
        break;

    case "logout":
        require "controllers/AuthController.php";
        (new AuthController())->logout();
        break;

    // ===== ADMIN =====
    case "admin":
        requireRole(2);
        require "controllers/AdminController.php";
        (new AdminController())->dashboard();
        break;

    case "admin/users":
        requireRole(2);
        require "controllers/AdminController.php";
        (new AdminController())->users();
        break;

    case "admin/users/status":
        requireRole(2);
        require "controllers/AdminController.php";
        (new AdminController())->updateUserStatus();
        break;

    case "admin/users/role":
        requireRole(2);
        require "controllers/AdminController.php";
        (new AdminController())->updateUserRole();
        break;

    default:
        echo "<h1>404 NOT FOUND</h1>";
}
// Get controller and action
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';  // 

// Sanitize inputs
$controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
$action = preg_replace('/[^a-zA-Z0-9]/', '', $action);

// Route to appropriate controller
try {
    switch ($controller) {
        case 'course':
            require_once __DIR__ . '/controllers/CourseController.php';
            $c = new CourseController();
            if (method_exists($c, $action)) {
                $c->$action();
            } else {
                $c->index();
            }
            break;

        case 'enrollment':
            require_once __DIR__ . '/controllers/EnrollmentController.php';
            $ec = new EnrollmentController();
            if (method_exists($ec, $action)) {
                $ec->$action();
            } else {
                throw new Exception('Action not found');
            }
            break;
        
        case 'course':
        // Kiểm tra file tồn tại trước khi require để tránh lỗi trắng trang
        if (file_exists('controllers/CourseController.php')) {
            require_once 'controllers/CourseController.php';
            $courseController = new CourseController();
            if (method_exists($courseController, $action)) {
                $courseController->{$action}();
            } else {
                echo "Action '$action' không tồn tại trong CourseController.";
            }
        } else {
            echo "Lỗi: File controllers/CourseController.php chưa được tạo.";
        }
        break;
        
        case 'lesson':
        if (file_exists('controllers/LessonController.php')) {
            require_once 'controllers/LessonController.php';
            $lessonController = new LessonController();
            if (method_exists($lessonController, $action)) {
                $lessonController->{$action}();
            } else {
                echo "Action '$action' không tồn tại trong LessonController.";
            }
        } else {
             echo "Lỗi: File controllers/LessonController.php chưa được tạo.";
        }
        break;
        
        case 'auth':
        require_once 'controllers/AuthController.php';
        $authController = new AuthController();
        if (method_exists($authController, $action)) {
            $authController->{$action}();
        } else {
            echo "Action không tồn tại.";
        }
        break;

        case 'home':
        require_once 'controllers/HomeController.php';
        $homeController = new HomeController();
        $homeController->index();
        break;
        default:
            // Redirect to course list as home page
            header('Location: index.php?controller=course&action=index');
            exit;
    }
} catch (Exception $e) {
    error_log('Router error: ' . $e->getMessage());
    die('Có lỗi xảy ra. Vui lòng thử lại sau.');
}


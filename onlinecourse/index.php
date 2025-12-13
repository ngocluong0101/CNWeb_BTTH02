<?php
// Bật hiển thị lỗi để dễ debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// --- ĐOẠN CODE "HACK" ĐỂ TEST (Xóa đi khi nộp bài) ---
// Nếu URL có ?auto_login=true, tự động set quyền Giảng viên
if (isset($_GET['auto_login']) && $_GET['auto_login'] == 'true') {
    $_SESSION['user_id'] = 1; // ID giả định của giảng viên
    $_SESSION['role'] = 1;    // Role 1 = Giảng viên (theo đề bài) [cite: 28]
    $_SESSION['fullname'] = 'Giảng viên Test';
    header("Location: index.php?controller=course&action=index");
    exit();
}
// -----------------------------------------------------

// Lấy controller và action từ URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $homeController = new HomeController();
        $homeController->index();
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

    default:
        echo "404 Not Found - Controller '$controller' chưa được định nghĩa.";
        break;
}
?>
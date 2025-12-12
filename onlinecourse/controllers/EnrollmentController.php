<?php
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Course.php';

class EnrollmentController {
    
    public function enroll() {
        $this->startSession();
        
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
            $this->setFlash('error', 'Vui lòng đăng nhập với tài khoản học viên');
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        $studentId = (int)$_SESSION['user_id'];
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$courseId) {
            $this->setFlash('error', 'Khóa học không hợp lệ');
            header('Location: index.php?controller=course&action=index');
            exit;
        }
        
        // Kiểm tra khóa học có tồn tại
        $course = Course::getById($courseId);
        if (!$course) {
            $this->setFlash('error', 'Khóa học không tồn tại');
            header('Location: index.php?controller=course&action=index');
            exit;
        }
        
        // Kiểm tra đã đăng ký chưa
        if (Enrollment::isEnrolled($studentId, $courseId)) {
            $this->setFlash('warning', 'Bạn đã đăng ký khóa học này rồi');
        } else {
            // Đăng ký
            if (Enrollment::enroll($studentId, $courseId)) {
                $this->setFlash('success', 'Đăng ký khóa học thành công!');
            } else {
                $this->setFlash('error', 'Có lỗi xảy ra. Vui lòng thử lại');
            }
        }
        
        header('Location: index.php?controller=student&action=myCourses');
        exit;
    }
    
    // Helper methods
    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    private function setFlash($type, $message) {
        $this->startSession();
        $_SESSION['flash_' . $type] = $message;
    }
}

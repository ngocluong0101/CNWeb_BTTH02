<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';

class CourseController {
    
    public function index() {
        $this->startSession();
        
        $categories = Category::getAll();
        $courses = Course::getAll();
        
        require __DIR__ . '/../views/courses/index.php';
    }

    public function search() {
        $this->startSession();
        
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $category = isset($_GET['category']) ? (int)$_GET['category'] : null;
        
        $categories = Category::getAll();
        
        if (empty($keyword) && empty($category)) {
            header('Location: index.php?controller=course&action=index');
            exit;
        }
        
        $courses = Course::search($keyword, $category);
        
        require __DIR__ . '/../views/courses/search.php';
    }

    public function detail() {
        $this->startSession();
        
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            $this->setFlash('error', 'Khóa học không tồn tại');
            header('Location: index.php?controller=course&action=index');
            exit;
        }
        
        $course = Course::getById($id);
        
        if (!$course) {
            $this->setFlash('error', 'Khóa học không tồn tại');
            header('Location: index.php?controller=course&action=index');
            exit;
        }
        
        require __DIR__ . '/../views/courses/detail.php';
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

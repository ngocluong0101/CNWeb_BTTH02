<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';

class CourseController
{
    private const MAX_KEYWORD_LENGTH = 100;

    public function __construct()
    {
        $this->startSession();
    }

    public function index()
    {
        $categories = Category::getAll();
        $courses = Course::getAll();

        require __DIR__ . '/../views/courses/index.php';
    }

    public function search()
{
    $keyword = $this->sanitizeKeyword($_GET['keyword'] ?? '');
    
    // SỬA ĐÂY: Chuyển empty string thành null
    $categoryInput = $_GET['category'] ?? '';
    $category = (!empty($categoryInput) && $categoryInput !== '') ? (int)$categoryInput : null;

    // Validate category exists
    if ($category && !Category::exists($category)) {
        $this->setFlash('error', 'Danh mục không hợp lệ');
        $this->redirect('course', 'index');
    }

    $categories = Category::getAll();

    // Redirect if no search criteria
    if (empty($keyword) && $category === null) {
        $this->redirect('course', 'index');
    }

    $courses = Course::search($keyword, $category);

    require __DIR__ . '/../views/courses/search.php';
}
    public function detail()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$id) {
            $this->setFlash('error', 'Khóa học không tồn tại');
            $this->redirect('course', 'index');
        }

        $course = Course::getById($id);

        if (!$course) {
            $this->setFlash('error', 'Khóa học không tồn tại');
            $this->redirect('course', 'index');
        }

        require __DIR__ . '/../views/courses/detail.php';
    }

    // Helper methods
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function setFlash($type, $message)
    {
        $_SESSION['flash_' . $type] = $message;
    }

    private function redirect($controller, $action)
    {
        header("Location: index.php?controller=$controller&action=$action");
        exit;
    }

    private function sanitizeKeyword($keyword)
    {
        $keyword = trim($keyword);
        $keyword = preg_replace('/\s+/u', ' ', $keyword);
        
        if (strlen($keyword) > self::MAX_KEYWORD_LENGTH) {
            $keyword = mb_substr($keyword, 0, self::MAX_KEYWORD_LENGTH, 'UTF-8');
        }
        
        return $keyword;
    }
}
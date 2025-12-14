
<?php


require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';

class CourseController
{
    private const MAX_KEYWORD_LENGTH = 100;

    public function __construct()
    {
        // session đã được start ở index.php
    }

    /* ===================== PUBLIC – STUDENT / INSTRUCTOR ===================== */

    public function index()
    {
        $categories = Category::getAll();
        $courses = Course::getAll();

        require __DIR__ . '/../views/courses/index.php';
    }

    public function search()
    {
        $keyword = $this->sanitizeKeyword($_GET['keyword'] ?? '');

        $categoryInput = $_GET['category'] ?? '';
        $category = (!empty($categoryInput)) ? (int)$categoryInput : null;

        if ($category && !Category::exists($category)) {
            $this->setFlash('error', 'Danh mục không hợp lệ');
            $this->redirect('course', 'index');
        }

        if (empty($keyword) && $category === null) {
            $this->redirect('course', 'index');
        }

        $categories = Category::getAll();
        $courses = Course::search($keyword, $category);

        require __DIR__ . '/../views/courses/search.php';
    }

    public function detail()
    {
        $id = (int)($_GET['id'] ?? 0);

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

    /* ===================== INSTRUCTOR ONLY ===================== */

    public function myCourses()
    {
        $this->requireInstructor();

        $instructorId = $_SESSION['user']['id'];

        $courseModel = new Course();
        $courses = $courseModel->getByInstructor($instructorId);

        require __DIR__ . '/../views/instructor/my_courses.php';
    }

    public function create()
    {
        $this->requireInstructor();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel = new Course();
            $courseModel->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'instructor_id' => $_SESSION['user']['id']
            ]);

            $this->redirect('course', 'myCourses');
        }

        require __DIR__ . '/../views/instructor/course/create.php';
    }

    public function edit()
    {
        $this->requireInstructor();

        $id = (int)($_GET['id'] ?? 0);
        $courseModel = new Course();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel->update($id, $_POST);
            $this->redirect('course', 'myCourses');
        }

        $course = $courseModel->find($id);
        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    public function delete()
    {
        $this->requireInstructor();

        $id = (int)($_GET['id'] ?? 0);
        $courseModel = new Course();
        $courseModel->delete($id);

        $this->redirect('course', 'myCourses');
    }

    /* ===================== HELPERS ===================== */

    private function requireInstructor()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            header("Location: index.php?controller=course&action=index");
            exit;
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

        if (mb_strlen($keyword, 'UTF-8') > self::MAX_KEYWORD_LENGTH) {
            $keyword = mb_substr($keyword, 0, self::MAX_KEYWORD_LENGTH, 'UTF-8');
        }

        return $keyword;
    }
}

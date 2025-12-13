<?php
require_once 'models/Course.php';

class CourseController {

    // ⭐ BẮT BUỘC PHẢI CÓ
    public function index() {
        $this->myCourses();
    }

    public function myCourses() {
        // Tương thích với session bạn đang dùng
        $instructorId = $_SESSION['user_id'];

        $courseModel = new Course();
       $courses = $courseModel->getAll();
        require 'views/instructor/my_courses.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel = new Course();
            $courseModel->create([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'instructor_id' => $_SESSION['user_id']
            ]);
            header("Location: index.php?controller=course&action=index");
            exit();
        }
        require 'views/instructor/course/create.php';
    }

    public function edit() {
        $courseModel = new Course();
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel->update($id, $_POST);
            header("Location: index.php?controller=course&action=index");
            exit();
        }

        $course = $courseModel->find($id);
        require 'views/instructor/course/edit.php';
    }

    public function delete() {
        $courseModel = new Course();
        $courseModel->delete($_GET['id']);
        header("Location: index.php?controller=course&action=index");
        exit();
    }
}

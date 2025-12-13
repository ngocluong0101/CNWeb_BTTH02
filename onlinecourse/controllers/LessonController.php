<?php
require_once 'models/Lesson.php';

class LessonController {

    public function manage() {
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($_GET['course_id']);
        require 'views/instructor/lessons/manage.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel = new Lesson();
            $lessonModel->create($_POST);
            header("Location: index.php?controller=lesson&action=manage&course_id=".$_POST['course_id']);
        }
        require 'views/instructor/lessons/create.php';
    }

    public function edit() {
        $lessonModel = new Lesson();
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel->update($id, $_POST);
            header("Location: index.php?controller=lesson&action=manage&course_id=".$_POST['course_id']);
        }

        $lesson = $lessonModel->find($id);
        require 'views/instructor/lessons/edit.php';
    }

    public function delete() {
        $lessonModel = new Lesson();
        $lessonModel->delete($_GET['id']);
        header("Location: ".$_SERVER['HTTP_REFERER']);
    }
}

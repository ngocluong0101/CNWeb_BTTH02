<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=UTF-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ===================== HELPER ===================== */

function requireRole($role) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != $role) {
        header("Location: index.php?url=login");
        exit;
    }
}

/* ===================== ROUTER ƯU TIÊN AUTH / ADMIN ===================== */

if (isset($_GET['url'])) {

    $url = $_GET['url'];

    switch ($url) {

        case "":
        case "login":
            require "controllers/AuthController.php";
            (new AuthController())->loginPage();
            exit;

        case "auth/login":
            require "controllers/AuthController.php";
            (new AuthController())->login();
            exit;

        case "register":
            require "controllers/AuthController.php";
            (new AuthController())->registerPage();
            exit;

        case "auth/register":
            require "controllers/AuthController.php";
            (new AuthController())->register();
            exit;

        case "logout":
            require "controllers/AuthController.php";
            (new AuthController())->logout();
            exit;

        case "admin":
            requireRole(2);
            require "controllers/AdminController.php";
            (new AdminController())->dashboard();
            exit;

        case "admin/users":
            requireRole(2);
            require "controllers/AdminController.php";
            (new AdminController())->users();
            exit;

        case "admin/users/status":
            requireRole(2);
            require "controllers/AdminController.php";
            (new AdminController())->updateUserStatus();
            exit;

        case "admin/users/role":
            requireRole(2);
            require "controllers/AdminController.php";
            (new AdminController())->updateUserRole();
            exit;
    }
}

/* ===================== ROUTER CONTROLLER / ACTION ===================== */

$controller = $_GET['controller'] ?? 'course';
$action     = $_GET['action'] ?? 'index';

$controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
$action     = preg_replace('/[^a-zA-Z0-9]/', '', $action);

try {
    switch ($controller) {

        case 'course':
            require_once 'controllers/CourseController.php';
            $c = new CourseController();
            method_exists($c, $action) ? $c->$action() : $c->index();
            break;

        case 'enrollment':
            require_once 'controllers/EnrollmentController.php';
            $e = new EnrollmentController();
            method_exists($e, $action) ? $e->$action() : die('Action not found');
            break;

        case 'lesson':
            require_once 'controllers/LessonController.php';
            $l = new LessonController();
            method_exists($l, $action) ? $l->$action() : die('Action not found');
            break;

        case 'auth':
            require_once 'controllers/AuthController.php';
            $a = new AuthController();
            method_exists($a, $action) ? $a->$action() : die('Action not found');
            break;

        default:
            header("Location: index.php?controller=course&action=index");
            exit;
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Có lỗi xảy ra.");
}


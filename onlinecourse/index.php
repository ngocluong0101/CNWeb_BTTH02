<?php
session_start();

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

    // ===== ADMIN – QUẢN LÝ USER =====
    case "admin/users":
        requireRole(2);
        require "controllers/AdminController.php";
        (new AdminController())->users();
        break;


    default:
        echo "<h1>404 NOT FOUND</h1>";
}

<?php
$uri = trim($_SERVER['REQUEST_URI'], '/');

switch ($uri) {
    case "":
    case "login":
        require "./controllers/AuthController.php";
        (new AuthController())->loginPage();
        break;

    case "auth/login":
        require "./controllers/AuthController.php";
        (new AuthController())->login();
        break;

    case "register":
        require "./controllers/AuthController.php";
        (new AuthController())->registerPage();
        break;

    case "auth/register":
        require "./controllers/AuthController.php";
        (new AuthController())->register();
        break;

    default:
        echo "404 NOT FOUND";
}

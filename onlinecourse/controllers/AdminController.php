<?php
class AdminController {

    public function dashboard() {
        include "views/admin/dashboard.php";
    }

    public function users() {
        require "config/Database.php";
        require "models/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $users = $userModel->getAll();

        include "views/admin/users/manage.php";
    }
}

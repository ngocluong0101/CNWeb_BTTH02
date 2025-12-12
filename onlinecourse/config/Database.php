<?php
class Database {
    private $host = "localhost";
    private $dbname = "onlinecourse";
    private $username = "root";
    private $password = "";

    public function connect() {
        try {
            $conn = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname",
                $this->username,
                $this->password
            );
            $conn->exec("SET NAMES utf8");
            return $conn;
        } catch (PDOException $e) {
            die("Lỗi: " . $e->getMessage());
        }
    }
}

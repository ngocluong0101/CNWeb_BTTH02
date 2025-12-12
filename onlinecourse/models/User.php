<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tìm người dùng qua username/email
    public function findUser($usernameOrEmail) {
        $sql = "SELECT * FROM $this->table WHERE username=? OR email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký
    public function register($username, $email, $password, $fullname) {
        $sql = "INSERT INTO $this->table (username, email, password, fullname, role, created_at)
                VALUES (?, ?, ?, ?, 0, NOW())";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $username,
            $email,
            password_hash($password, PASSWORD_BCRYPT),
            $fullname
        ]);
    }

    // Lấy tất cả user (admin)
    public function getAll() {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        return $this->conn->query($sql);
    }
}

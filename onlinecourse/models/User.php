<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tìm người dùng qua username/email (login)
    public function findUser($usernameOrEmail) {
        $sql = "SELECT * FROM $this->table 
                WHERE (username=? OR email=?) AND status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký
    public function register($username, $email, $password, $fullname) {
        $sql = "INSERT INTO $this->table 
                (username, email, password, fullname, role, status, created_at)
                VALUES (?, ?, ?, ?, 0, 1, NOW())";

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
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Khóa / mở tài khoản
    public function updateStatus($id, $status) {
        $sql = "UPDATE $this->table SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // Đổi role user
    public function updateRole($id, $role) {
        $sql = "UPDATE $this->table SET role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$role, $id]);
    }
}

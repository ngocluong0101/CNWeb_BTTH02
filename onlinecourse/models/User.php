<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy user qua username/email
    public function findUser($usernameOrEmail) {
        $sql = "SELECT * FROM $this->table WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Đăng ký
    public function register() {
        $sql = "INSERT INTO $this->table (username, email, password, fullname, role, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $this->username,
            $this->email,
            password_hash($this->password, PASSWORD_BCRYPT),
            $this->fullname,
            $this->role
        ]);
    }

    // Lấy toàn bộ user (admin)
    public function getAll() {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        return $this->conn->query($sql);
    }
}

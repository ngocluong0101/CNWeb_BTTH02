<?php
class Database {
    private static $host = "localhost";
    private static $dbname = "onlinecourse";
    private static $username = "root";
    private static $password = "";
    private static $conn = null;

    // STATIC – dùng cho Category, Course (student)
    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Lỗi kết nối DB: " . $e->getMessage());
            }
        }
        return self::$conn;
    }

    // INSTANCE – để KHÔNG PHÁ code cũ (instructor)
    public function getConnection() {
        return self::connect();
    }
}

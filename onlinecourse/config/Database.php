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
//     private static $host = '127.0.0.1';
//     private static $db   = 'onlinecourse';
//     private static $user = 'root';
//     private static $pass = 'dinhan125';
//     private static $charset = 'utf8mb4';
//     private static $pdo = null;

//     public static function connect() {
//         if (self::$pdo === null) {
//             $dsn = "mysql:host=".self::$host.";dbname=".self::$db.";charset=".self::$charset;
//             $opt = [
//                 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                 PDO::ATTR_EMULATE_PREPARES => false,
//             ];
//             try {
//                 self::$pdo = new PDO($dsn, self::$user, self::$pass, $opt);
//             } catch (PDOException $e) {
//                 error_log('Database connection failed: ' . $e->getMessage());
//                 die('Không thể kết nối database. Vui lòng thử lại sau.');
//             }
//         }
//         return self::$pdo;
//     }
// }

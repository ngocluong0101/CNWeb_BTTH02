<?php
require_once 'config/Database.php';

class Course {
    private $conn;

    public function __construct() {
        $database = new Database();           // TẠO OBJECT Database
        $this->conn = $database->getConnection(); // LẤY PDO
    }

    public function getAll() {
        $sql = "SELECT * FROM courses";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO courses (title, description, price, instructor_id, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['price'],
            $data['instructor_id']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare(
            "UPDATE courses SET title=?, description=?, price=? WHERE id=?"
        );
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['price'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id=?");
        return $stmt->execute([$id]);
    }
}

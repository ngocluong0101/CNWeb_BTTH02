<?php
require_once 'config/Database.php';

class Lesson {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getByCourse($courseId) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM lessons WHERE course_id = ? ORDER BY id ASC"
        );
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM lessons WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO lessons (course_id, title, content, `order`, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([
            $data['course_id'],
            $data['title'],
            $data['content'],
            $data['order']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare(
            "UPDATE lessons SET title=?, content=?, `order`=? WHERE id=?"
        );
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['order'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM lessons WHERE id=?");
        return $stmt->execute([$id]);
    }
}

<?php
require_once __DIR__ . '/../config/Database.php';

class Course {
    
    public static function getAll() {
        try {
            $db = Database::connect();
            $sql = "SELECT c.*, 
                           u.fullname AS instructor_name, 
                           cat.name AS category_name,
                           COUNT(DISTINCT e.id) as total_students
                    FROM courses c
                    LEFT JOIN users u ON u.id = c.instructor_id
                    LEFT JOIN categories cat ON cat.id = c.category_id
                    LEFT JOIN enrollments e ON e.course_id = c.id
                    GROUP BY c.id
                    ORDER BY c.created_at DESC";
            return $db->query($sql)->fetchAll();
        } catch (PDOException $e) {
            error_log('Error in Course::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public static function search($keyword, $category_id = null) {
        try {
            $db = Database::connect();
            $sql = "SELECT c.*, 
                           u.fullname AS instructor_name, 
                           cat.name AS category_name,
                           COUNT(DISTINCT e.id) as total_students
                    FROM courses c
                    LEFT JOIN users u ON u.id = c.instructor_id
                    LEFT JOIN categories cat ON cat.id = c.category_id
                    LEFT JOIN enrollments e ON e.course_id = c.id
                    WHERE (c.title LIKE :kw OR c.description LIKE :kw)";
            
            if ($category_id) {
                $sql .= " AND c.category_id = :cat";
            }
            
            $sql .= " GROUP BY c.id ORDER BY c.created_at DESC";
            
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':kw', "%$keyword%", PDO::PARAM_STR);
            
            if ($category_id) {
                $stmt->bindValue(':cat', (int)$category_id, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error in Course::search - ' . $e->getMessage());
            return [];
        }
    }

    public static function getById($id) {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT c.*, 
                       u.fullname AS instructor_name,
                       u.email AS instructor_email,
                       cat.name AS category_name,
                       COUNT(DISTINCT e.id) as total_students
                FROM courses c
                LEFT JOIN users u ON u.id = c.instructor_id
                LEFT JOIN categories cat ON cat.id = c.category_id
                LEFT JOIN enrollments e ON e.course_id = c.id
                WHERE c.id = :id
                GROUP BY c.id
                LIMIT 1
            ");
            $stmt->execute(['id' => (int)$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error in Course::getById - ' . $e->getMessage());
            return null;
        }
    }
}

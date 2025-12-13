<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    
    public static function enroll($studentId, $courseId) {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                INSERT INTO enrollments (course_id, student_id, enrolled_date, status, progress)
                VALUES (:c, :s, NOW(), 'active', 0)
            ");
            return $stmt->execute([
                'c' => (int)$courseId, 
                's' => (int)$studentId
            ]);
        } catch (PDOException $e) {
            error_log('Error in Enrollment::enroll - ' . $e->getMessage());
            return false;
        }
    }

    public static function isEnrolled($studentId, $courseId) {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT id FROM enrollments 
                WHERE student_id = :s AND course_id = :c 
                LIMIT 1
            ");
            $stmt->execute([
                's' => (int)$studentId, 
                'c' => (int)$courseId
            ]);
            return $stmt->fetch() ? true : false;
        } catch (PDOException $e) {
            error_log('Error in Enrollment::isEnrolled - ' . $e->getMessage());
            return false;
        }
    }

    public static function getMyCourses($studentId) {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                SELECT c.*, 
                       e.progress, 
                       e.status, 
                       e.enrolled_date,
                       u.fullname AS instructor_name,
                       cat.name AS category_name
                FROM enrollments e
                JOIN courses c ON c.id = e.course_id
                LEFT JOIN users u ON u.id = c.instructor_id
                LEFT JOIN categories cat ON cat.id = c.category_id
                WHERE e.student_id = :s 
                ORDER BY e.enrolled_date DESC
            ");
            $stmt->execute(['s' => (int)$studentId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error in Enrollment::getMyCourses - ' . $e->getMessage());
            return [];
        }
    }
}

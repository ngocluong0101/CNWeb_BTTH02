<?php
require_once __DIR__ . '/../config/Database.php';

class Category 
{
    /**
     * Get all categories
     * @return array
     */
    public static function getAll() 
    {
        try {
            $db = Database::connect();
            return $db->query("
                SELECT * FROM categories 
                ORDER BY name
            ")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error in Category::getAll - ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if a category exists
     * @param int $id
     * @return bool
     */
    public static function exists($id) 
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("SELECT 1 FROM categories WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => (int)$id]);
            return (bool)$stmt->fetch();
        } catch (PDOException $e) {
            error_log('Error in Category::exists - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get category by ID
     * @param int $id
     * @return array|null
     */
    public static function getById($id) 
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("SELECT * FROM categories WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => (int)$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $e) {
            error_log('Error in Category::getById - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get categories with course count
     * @return array
     */
    public static function getAllWithCourseCount() 
    {
        try {
            $db = Database::connect();
            return $db->query("
                SELECT c.*, 
                       COUNT(co.id) as course_count
                FROM categories c
                LEFT JOIN courses co ON co.category_id = c.id
                GROUP BY c.id
                ORDER BY c.name
            ")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error in Category::getAllWithCourseCount - ' . $e->getMessage());
            return [];
        }
    }
}
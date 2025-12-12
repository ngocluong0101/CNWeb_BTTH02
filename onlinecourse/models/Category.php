<?php
require_once __DIR__ . '/../config/Database.php';

class Category {
    
    public static function getAll() {
        try {
            $db = Database::connect();
            return $db->query("
                SELECT * FROM categories 
                ORDER BY name
            ")->fetchAll();
        } catch (PDOException $e) {
            error_log('Error in Category::getAll - ' . $e->getMessage());
            return [];
        }
    }
}

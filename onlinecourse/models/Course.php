<?php

require_once __DIR__ . '/../config/Database.php';

class Course
{
    /* ===================== STATIC – STUDENT / PUBLIC ===================== */

    public static function getAll($limit = null, $offset = 0)
    {
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

            if ($limit !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }

            $stmt = $db->prepare($sql);

            if ($limit !== null) {
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log('Course::getAll - ' . $e->getMessage());
            return [];
        }
    }

    public static function search($keyword = null, $category_id = null, $limit = 50, $offset = 0)
    {
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
                    WHERE 1=1";

            $params = [];

            if (!empty($keyword)) {
                $sql .= " AND (c.title LIKE :kw1 OR c.description LIKE :kw2)";
                $params['kw1'] = '%' . $keyword . '%';
                $params['kw2'] = '%' . $keyword . '%';
            }

            if (!empty($category_id)) {
                $sql .= " AND c.category_id = :cat";
                $params['cat'] = (int)$category_id;
            }

            $sql .= " GROUP BY c.id ORDER BY c.created_at DESC LIMIT :limit OFFSET :offset";

            $stmt = $db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log('Course::search - ' . $e->getMessage());
            return [];
        }
    }

    public static function getById($id)
    {
        try {
            $db = Database::connect();

            $stmt = $db->prepare("
                SELECT c.*, 
                       u.fullname AS instructor_name,
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
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

        } catch (PDOException $e) {
            error_log('Course::getById - ' . $e->getMessage());
            return null;
        }
    }

    /* ===================== INSTANCE – INSTRUCTOR ===================== */

    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /** Instructor chỉ xem course của mình */
    public function getByInstructor($instructorId)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM courses WHERE instructor_id = ?"
        );
        $stmt->execute([$instructorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
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

    public function update($id, $data)
    {
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

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id=?");
        return $stmt->execute([$id]);
    }
}

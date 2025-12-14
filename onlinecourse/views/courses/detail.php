<?php 
$pageTitle = isset($course['title']) ? $course['title'] : 'Chi tiết khóa học';
require __DIR__ . '/../layouts/header.php'; 

// Kiểm tra đã đăng ký chưa
$isEnrolled = false;
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 0) {
    require_once __DIR__ . '/../../models/Enrollment.php';
    $isEnrolled = Enrollment::isEnrolled($_SESSION['user_id'], $course['id']);
}
?>

<div class="course-detail">
    <h1><?= htmlspecialchars($course['title']) ?></h1>
    
    <div class="course-info">
        <p><strong>👤 Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name'] ?? 'Chưa có') ?></p>
        <p><strong>📁 Danh mục:</strong> <?= htmlspecialchars($course['category_name'] ?? 'Chưa phân loại') ?></p>
        <?php if (isset($course['total_students'])): ?>
            <p><strong>👥 Học viên:</strong> <?= (int)$course['total_students'] ?> người</p>
        <?php endif; ?>
        <p class="price"><strong>💰 Giá:</strong> <?= number_format($course['price'], 0, ',', '.') ?> đ</p>
    </div>
    
    <div class="course-description">
        <h2>Mô tả khóa học</h2>
        <p><?= nl2br(htmlspecialchars($course['description'])) ?></p>
    </div>
    
    <div class="course-actions">
        <?php if ($isEnrolled): ?>
            <div class="alert alert-success">
                ✅ Bạn đã đăng ký khóa học này
            </div>
            <a href="index.php?controller=student&action=myCourses" 
               class="btn btn-primary">
                📚 Xem khóa học của tôi
            </a>
        <?php else: ?>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 0): ?>
                <a href="index.php?controller=enrollment&action=enroll&id=<?= (int)$course['id'] ?>" 
                   class="btn btn-primary"
                   onclick="return confirm('Bạn có chắc muốn đăng ký khóa học này?')">
                    🎓 Đăng ký khóa học
                </a>
            <?php else: ?>
                <a href="index.php?controller=auth&action=login" 
                   class="btn btn-primary">
                    🔐 Đăng nhập để đăng ký
                </a>
            <?php endif; ?>
        <?php endif; ?>
        
        <a href="index.php?controller=course&action=index" 
           class="btn btn-secondary">
            ← Quay lại danh sách
        </a>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

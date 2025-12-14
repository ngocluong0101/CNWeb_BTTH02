<?php 
$pageTitle = 'Khóa học của tôi';
require __DIR__ . '/../layouts/header.php'; 

// Lấy danh sách khóa học đã đăng ký
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

require_once __DIR__ . '/../../models/Enrollment.php';
$courses = Enrollment::getMyCourses($_SESSION['user_id']);
?>

<h1>Khóa học của tôi</h1>

<?php if (empty($courses)): ?>
    <div class="empty-state">
        <p>Bạn chưa đăng ký khóa học nào.</p>
        <a href="index.php?controller=course&action=index" class="btn btn-primary">
            🔍 Khám phá khóa học
        </a>
    </div>
<?php else: ?>
    <div class="my-courses-list">
        <?php foreach ($courses as $c): ?>
            <div class="course-card enrolled">
                <h3><?= htmlspecialchars($c['title']) ?></h3>
                
                <div class="course-meta">
                    <p>👤 Giảng viên: <?= htmlspecialchars($c['instructor_name'] ?? 'Chưa có') ?></p>
                    <p>📁 Danh mục: <?= htmlspecialchars($c['category_name'] ?? 'Chưa phân loại') ?></p>
                    <p>📅 Đăng ký: <?= date('d/m/Y', strtotime($c['enrolled_date'])) ?></p>
                </div>
                
                <div class="progress-section">
                    <p><strong>Trạng thái:</strong> 
                        <span class="status-<?= htmlspecialchars($c['status']) ?>">
                            <?php
                            $statusText = [
                                'active' => '✅ Đang học',
                                'completed' => '🎉 Hoàn thành',
                                'paused' => '⏸️ Tạm dừng'
                            ];
                            echo $statusText[$c['status']] ?? $c['status'];
                            ?>
                        </span>
                    </p>
                    
                    <p><strong>Tiến độ:</strong> <?= (int)$c['progress'] ?>%</p>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= (int)$c['progress'] ?>%"></div>
                    </div>
                </div>
                
                <div class="course-actions">
                    <a href="index.php?controller=course&action=detail&id=<?= (int)$c['id'] ?>" 
                       class="btn btn-primary">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

<?php 
$pageTitle = 'Kết quả tìm kiếm';
require __DIR__ . '/../layouts/header.php'; 
?>

<h1>Kết quả tìm kiếm</h1>

<?php if (isset($_GET['keyword']) && !empty($_GET['keyword'])): ?>
    <p class="search-info">
        Từ khóa: <strong><?= htmlspecialchars($_GET['keyword']) ?></strong>
    </p>
<?php endif; ?>

<?php if (isset($_GET['category']) && !empty($_GET['category'])): ?>
    <p class="search-info">
        Danh mục: <strong>
            <?php
            foreach ($categories as $cat) {
                if ($cat['id'] == $_GET['category']) {
                    echo htmlspecialchars($cat['name']);
                    break;
                }
            }
            ?>
        </strong>
    </p>
<?php endif; ?>

<p class="result-count">Tìm thấy <?= count($courses) ?> khóa học</p>

<!-- Course List -->
<div class="course-list">
    <?php if (count($courses) === 0): ?>
        <p class="no-results">Không tìm thấy khóa học phù hợp.</p>
        <a href="index.php?controller=course&action=index" class="btn btn-secondary">
            ← Quay lại danh sách
        </a>
    <?php else: ?>
        <?php foreach ($courses as $c): ?>
            <div class="course-card">
                <h3><?= htmlspecialchars($c['title']) ?></h3>
                <p class="description">
                    <?= htmlspecialchars(mb_substr($c['description'], 0, 150)) ?>...
                </p>
                
                <div class="course-meta">
                    <p>👤 Giảng viên: <?= htmlspecialchars($c['instructor_name'] ?? 'Chưa có') ?></p>
                    <p>📁 Danh mục: <?= htmlspecialchars($c['category_name'] ?? 'Chưa phân loại') ?></p>
                    <?php if (isset($c['total_students'])): ?>
                        <p>👥 Học viên: <?= (int)$c['total_students'] ?></p>
                    <?php endif; ?>
                    <p class="price">💰 Giá: <?= number_format($c['price'], 0, ',', '.') ?> đ</p>
                </div>
                
                <a href="index.php?controller=course&action=detail&id=<?= (int)$c['id'] ?>" 
                   class="btn btn-primary">
                    Xem chi tiết
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

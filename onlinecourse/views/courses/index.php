<?php 
$pageTitle = 'Danh sách khóa học';
require __DIR__ . '/../layouts/header.php'; 
?>

<h1>Danh sách khóa học</h1>

<!-- Search Form -->
<form method="get" action="index.php" class="search-form">
    <input type="hidden" name="controller" value="course">
    <input type="hidden" name="action" value="search">
    
    <input type="text" 
           name="keyword" 
           placeholder="Tìm khóa học..."
           class="search-input">
    
    <select name="category" class="search-select">
        <option value="">-- Tất cả danh mục --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat['id']) ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
</form>

<!-- Course List -->
<div class="course-list">
    <?php if (empty($courses)): ?>
        <p>Không có khóa học nào.</p>
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

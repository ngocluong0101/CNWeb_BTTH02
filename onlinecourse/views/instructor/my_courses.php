<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <h2>Khóa học của tôi</h2>

    <a class="btn btn-success" href="index.php?controller=course&action=create">
        + Tạo khóa học
    </a>

    <div class="course-grid">
        <?php foreach ($courses as $c): ?>
            <div class="course-card">
                <h3><?= htmlspecialchars($c['title']) ?></h3>

                <?php if (!empty($c['description'])): ?>
                    <p class="desc"><?= htmlspecialchars($c['description']) ?></p>
                <?php endif; ?>

                <?php if (isset($c['price'])): ?>
                    <p class="price"><?= number_format($c['price']) ?> VNĐ</p>
                <?php endif; ?>

                <div class="card-actions">
                    <a class="btn btn-warning btn-sm"
                       href="index.php?controller=course&action=edit&id=<?= $c['id'] ?>">
                        Sửa
                    </a>

                    <a class="btn btn-danger btn-sm"
                       href="index.php?controller=course&action=delete&id=<?= $c['id'] ?>"
                       onclick="return confirm('Xóa khóa học?')">
                        Xóa
                    </a>

                    <a class="btn btn-success btn-sm"
                       href="index.php?controller=lesson&action=manage&course_id=<?= $c['id'] ?>">
                        Bài học
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

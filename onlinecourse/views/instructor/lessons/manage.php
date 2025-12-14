<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <h3>Danh sách bài học</h3>

    <a href="index.php?controller=lesson&action=create&course_id=<?= $_GET['course_id'] ?>"
       class="btn btn-success">
        + Thêm bài học
    </a>

    <?php if (empty($lessons)): ?>
        <p>Chưa có bài học nào.</p>
    <?php else: ?>
        <ul class="lesson-list">
            <?php foreach ($lessons as $l): ?>
                <li class="lesson-item">
                    <span class="lesson-title">
                        <?= htmlspecialchars($l['title']) ?>
                    </span>

                    <span class="lesson-actions">
                        <a class="btn btn-warning btn-sm"
                           href="index.php?controller=lesson&action=edit&id=<?= $l['id'] ?>&course_id=<?= $_GET['course_id'] ?>">
                            Sửa
                        </a>

                        <a class="btn btn-danger btn-sm"
                           href="index.php?controller=lesson&action=delete&id=<?= $l['id'] ?>"
                           onclick="return confirm('Xóa bài học?')">
                            Xóa
                        </a>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

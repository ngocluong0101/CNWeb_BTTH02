<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <h2>Quản lý khóa học</h2>

    <a href="index.php?controller=course&action=create" class="btn">
        + Tạo khóa học mới
    </a>

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khóa học</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= $course['id'] ?></td>
                <td>
                    <strong><?= htmlspecialchars($course['title']) ?></strong><br>
                    <small>
                        <a href="index.php?controller=lesson&action=manage&course_id=<?= $course['id'] ?>">
                            Quản lý bài học
                        </a>
                    </small>
                </td>
                <td><?= number_format($course['price']) ?> VNĐ</td>
                <td>
                    <a href="index.php?controller=course&action=edit&id=<?= $course['id'] ?>">Sửa</a>
                    |
                    <a class="btn-danger"
                       href="index.php?controller=course&action=delete&id=<?= $course['id'] ?>"
                       onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                        Xóa
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

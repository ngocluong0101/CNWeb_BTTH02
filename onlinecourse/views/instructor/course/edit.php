<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <h2>Sửa khóa học</h2>

    <form method="post">
        <label>Tên khóa học</label>
        <input name="title" value="<?= htmlspecialchars($course['title']) ?>">

        <label>Mô tả</label>
        <textarea name="description"><?= htmlspecialchars($course['description']) ?></textarea>

        <label>Giá</label>
        <input name="price" value="<?= $course['price'] ?>">

        <button type="submit">Lưu thay đổi</button>
    </form>
</div>

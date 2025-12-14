<h3>Sửa bài học</h3>

<form method="post">
    <input type="hidden" name="course_id" value="<?= $_GET['course_id'] ?>">
    <input name="title" value="<?= $lesson['title'] ?>"><br>
    <textarea name="content"><?= $lesson['content'] ?></textarea><br>
    <input name="order" value="<?= $lesson['order'] ?>"><br>
    <button>Lưu</button>
</form>

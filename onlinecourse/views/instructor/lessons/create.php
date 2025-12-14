<h3>Thêm bài học</h3>

<form method="post">
    <input type="hidden" name="course_id" value="<?= $_GET['course_id'] ?>">
    <input name="title" placeholder="Tên bài học"><br>
    <textarea name="content"></textarea><br>
    <input name="order" type="number" placeholder="Thứ tự"><br>
    <button>Lưu</button>
</form>

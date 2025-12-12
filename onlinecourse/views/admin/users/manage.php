<h2>Quản lý tài khoản</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Họ tên</th>
        <th>Role</th>
    </tr>

    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= $u['username'] ?></td>
        <td><?= $u['email'] ?></td>
        <td><?= $u['fullname'] ?></td>
        <td>
            <?= $u['role'] == 0 ? "Học viên" :
                ($u['role'] == 1 ? "Giảng viên" : "Quản trị viên") ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

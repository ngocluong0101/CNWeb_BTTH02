<h2>Quản lý tài khoản người dùng</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Status</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= $u['username'] ?></td>
        <td><?= $u['email'] ?></td>

        <td>
            <form method="POST" action="/cse485/CNWeb_BTTH02/onlinecourse/admin/users/role">
                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                <select name="role" onchange="this.form.submit()">
                    <option value="0" <?= $u['role']==0?'selected':'' ?>>Student</option>
                    <option value="1" <?= $u['role']==1?'selected':'' ?>>Instructor</option>
                    <option value="2" <?= $u['role']==2?'selected':'' ?>>Admin</option>
                </select>
            </form>
        </td>

        <td>
            <?= $u['status'] ? 'Hoạt động' : 'Bị khóa' ?>
        </td>

        <td>
            <?php if ($u['status'] == 1): ?>
                <a href="/cse485/CNWeb_BTTH02/onlinecourse/admin/users/status?id=<?= $u['id'] ?>&status=0">
                    Khóa
                </a>
            <?php else: ?>
                <a href="/cse485/CNWeb_BTTH02/onlinecourse/admin/users/status?id=<?= $u['id'] ?>&status=1">
                    Mở
                </a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

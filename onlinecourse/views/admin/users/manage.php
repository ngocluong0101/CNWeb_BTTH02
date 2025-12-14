<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản người dùng</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background: #2c3e50;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #eef3f7;
        }

        select {
            padding: 6px;
            border-radius: 4px;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-locked {
            color: red;
            font-weight: bold;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-lock {
            background: #e74c3c;
            color: #fff;
        }

        .btn-unlock {
            background: #27ae60;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>

<h2>Quản lý tài khoản người dùng</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Vai trò</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>

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
                <?php if ($u['status'] == 1): ?>
                    <span class="status-active">Hoạt động</span>
                <?php else: ?>
                    <span class="status-locked">Bị khóa</span>
                <?php endif; ?>
            </td>

            <td>
                <?php if ($u['status'] == 1): ?>
                    <a class="btn btn-lock"
                       href="/cse485/CNWeb_BTTH02/onlinecourse/admin/users/status?id=<?= $u['id'] ?>&status=0">
                        Khóa
                    </a>
                <?php else: ?>
                    <a class="btn btn-unlock"
                       href="/cse485/CNWeb_BTTH02/onlinecourse/admin/users/status?id=<?= $u['id'] ?>&status=1">
                        Mở
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

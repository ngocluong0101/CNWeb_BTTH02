<h2>Đăng nhập</h2>

<form action="/auth/login" method="POST">
    <input type="text" name="username" placeholder="Username hoặc Email" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <button type="submit">Đăng nhập</button>
</form>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

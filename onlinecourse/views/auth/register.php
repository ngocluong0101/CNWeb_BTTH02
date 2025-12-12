<h2>Đăng ký tài khoản</h2>

<form action="/auth/register" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="fullname" placeholder="Họ tên" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <button type="submit">Đăng ký</button>
</form>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

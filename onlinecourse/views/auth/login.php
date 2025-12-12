<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .auth-box {
            background: white;
            width: 380px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            animation: fadeIn 0.4s ease;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: 0.2s;
        }
        input:focus {
            border-color: #667eea;
            outline: none;
        }
        button {
            width: 100%;
            padding: 13px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.2s;
        }
        button:hover {
            background: #5567d4;
        }
        .link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #667eea;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
        .error {
            text-align: center;
            color: red;
            margin-bottom: 10px;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(15px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

<div class="auth-box">
    <h2>Đăng nhập</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="/cse485/CNWeb_BTTH02/onlinecourse/auth/login">
        <input type="text" name="username" placeholder="Tên đăng nhập hoặc Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>

        <button type="submit">Đăng nhập</button>
    </form>

    <a class="link" href="/cse485/CNWeb_BTTH02/onlinecourse/register">Chưa có tài khoản? Đăng ký</a>
</div>

</body>
</html>

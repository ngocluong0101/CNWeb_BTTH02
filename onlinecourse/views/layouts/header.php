<?php
// Start session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>OnlineCourse
    </title>

    <!-- CSS (đường dẫn tuyệt đối để KHÔNG lỗi) -->
    <link rel="stylesheet" href="/cse485/CNWeb_BTTH02/onlinecourse/assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container">

        <!-- LOGO -->
        <a href="index.php?controller=course&action=index" class="brand">
            OnlineCourse
        </a>

        <ul class="nav-menu">

            <!-- LUÔN HIỂN THỊ -->
            <li>
                <a href="index.php?controller=course&action=index">
                    Khóa học
                </a>
            </li>

            <?php if (isset($_SESSION['user'])): ?>

                <?php $role = $_SESSION['user']['role']; ?>

                <!-- STUDENT -->
                <?php if ($role == 0): ?>
                    <li>
                        <a href="index.php?controller=course&action=myCourses">
                            Khóa học của tôi
                        </a>
                    </li>
                <?php endif; ?>

                <!-- INSTRUCTOR -->
                <?php if ($role == 1): ?>
                    <li>
                        <a href="index.php?controller=course&action=myCourses">
                            Quản lý khóa học
                        </a>
                    </li>
                    <li>
                        <a href="index.php?controller=course&action=create">
                            Tạo khóa học
                        </a>
                    </li>
                <?php endif; ?>

                <!-- ADMIN -->
                <?php if ($role == 2): ?>
                    <li>
                        <a href="index.php?url=admin/users">
                            Quản trị
                        </a>
                    </li>
                <?php endif; ?>

                <!-- LOGOUT -->
                <li>
                    <a href="index.php?url=logout" class="logout">
                        Đăng xuất
                    </a>
                </li>

            <?php else: ?>

                <!-- CHƯA ĐĂNG NHẬP -->
                <li>
                    <a href="index.php?url=login">
                        Đăng nhập
                    </a>
                </li>

            <?php endif; ?>

        </ul>
    </div>
</nav>

<main class="main-content">
    <div class="container">

        <?php
        // FLASH MESSAGE
        $flashTypes = ['success', 'error', 'warning', 'info'];
        foreach ($flashTypes as $type) {
            if (!empty($_SESSION['flash_' . $type])) {
                echo '<div class="alert alert-' . $type . '">';
                echo htmlspecialchars($_SESSION['flash_' . $type]);
                echo '</div>';
                unset($_SESSION['flash_' . $type]);
            }
        }
        ?>

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
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>OnlineCourse</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="brand">OnlineCourse</a>
            <ul class="nav-menu">
                <li><a href="index.php?controller=course&action=index">Khóa học</a></li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 0): ?>
                        <li><a href="index.php?controller=student&action=myCourses">Khóa học của tôi</a></li>
                    <?php endif; ?>
                    <li><a href="index.php?controller=auth&action=logout">Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="index.php?controller=auth&action=login">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    
    <main class="main-content">
        <div class="container">
            <?php
            // Hiển thị flash messages
            $flashTypes = ['success', 'error', 'warning', 'info'];
            foreach ($flashTypes as $type) {
                if (isset($_SESSION['flash_' . $type])) {
                    echo '<div class="alert alert-' . $type . '">';
                    echo htmlspecialchars($_SESSION['flash_' . $type]);
                    echo '</div>';
                    unset($_SESSION['flash_' . $type]);
                }
            }
            ?>

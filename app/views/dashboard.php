<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>لوحة التحكم - Team To-Do App</title>
<link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
<div class="container">
  <h2>👋 مرحبًا <?= htmlspecialchars($user['email']); ?> </h2>
  <p>تم تسجيل الدخول بنجاح!</p>
  <a href="../controllers/logout.php">تسجيل الخروج</a>
</div>
</body>
</html>

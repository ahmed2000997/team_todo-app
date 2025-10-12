<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>المهام - Team Todo</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <h2>صفحة المهام</h2>
  <p>هنا يمكنك عرض المهام، إضافتها أو تعديلها.</p>
  <a href="home.php">⬅️ العودة للرئيسية</a>
</body>
</html>

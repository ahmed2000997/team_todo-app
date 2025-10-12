<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>الرئيسية - Team Todo</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Cairo', sans-serif;
    background-color: #f5f7fb;
    margin: 0;
    display: flex;
  }
  .sidebar {
    width: 230px;
    background-color: #4A6CF7;
    color: #fff;
    height: 100vh;
    padding: 20px;
    box-sizing: border-box;
  }
  .sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
  }
  .sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 6px;
    margin-bottom: 10px;
    transition: background 0.3s;
  }
  .sidebar a:hover {
    background-color: #3655d9;
  }
  .content {
    flex: 1;
    padding: 40px;
  }
  .logout {
    background-color: #ff4d4d;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    margin-top: 20px;
    padding: 10px;
    display: block;
    text-decoration: none;
  }
  .logout:hover {
    background-color: #e60000;
  }
</style>
</head>
<body>

  <div class="sidebar">
    <h2>Team Todo</h2>
    <a href="home.php">🏠 الرئيسية</a>
    <a href="tasks.php">✅ المهام</a>
    <a href="settings.php">⚙️ الإعدادات</a>
    <a href="../../controllers/logout.php" class="logout">🚪 تسجيل الخروج</a>
  </div>

  <div class="content">
    <h2>مرحبًا <?= htmlspecialchars($user['email']); ?> 👋</h2>
    <p>مرحبًا بك في لوحة تحكم Team Todo App!</p>
    <p>اختر من القائمة الجانبية لبدء إدارة مهامك أو تعديل إعداداتك.</p>
  </div>

</body>
</html>

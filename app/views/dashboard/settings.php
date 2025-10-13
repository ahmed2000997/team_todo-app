<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings - Team To-Do</title>
  <link rel="stylesheet" href="../../../public/css/home.css">
  <script src="../../../public/js/home.js" defer></script>
</head>
<body>
  <div class="main-container">

    <!-- الشريط الجانبي -->
    <div class="sidebar">
      <div class="user-info">
        <span>👤 <?= htmlspecialchars($user['email']); ?></span>
      </div>
      <div class="menu">
        <button class="menu-btn" onclick="navigate('home.php')">🏠 Home</button>
        <button class="menu-btn" onclick="navigate('task.php')">✅ Task</button>
        <button class="menu-btn active" onclick="navigate('settings.php')">⚙️ Setting</button>
      </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="content-box">
      <div class="content-header">
        <h2>Settings</h2>
        <a href="../../../app/controllers/logout.php" class="logout">Logout</a>
      </div>

      <div class="task-team-section">
        <div class="task-section">
          <h3>Profile</h3>
          <form action="#" method="post" class="settings-form">
            <label>Email:</label>
            <input type="email" value="<?= htmlspecialchars($user['email']); ?>" disabled>

            <label>Change Password:</label>
            <input type="password" placeholder="Enter new password">

            <button type="submit">Update</button>
          </form>
        </div>

        <div class="team-section">
          <h3>App Theme</h3>
          <div class="team-box">
            <label><input type="radio" name="theme" checked> 🌞 Light Mode</label>
            <label><input type="radio" name="theme"> 🌙 Dark Mode</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

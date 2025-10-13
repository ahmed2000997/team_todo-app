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
  <title>Tasks - Team To-Do</title>
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
        <button class="menu-btn active" onclick="navigate('task.php')">✅ Task</button>
        <button class="menu-btn" onclick="navigate('settings.php')">⚙️ Setting</button>
      </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="content-box">
      <div class="content-header">
        <h2>Tasks Overview</h2>
        <a href="../../../app/controllers/logout.php" class="logout">Logout</a>
      </div>

      <div class="task-team-section">
        <div class="task-section">
          <h3>All Tasks</h3>
          <ul id="taskList">
            <li>🟢 Design login page</li>
            <li>🟡 Fix database connection</li>
            <li>🔵 Add validation for register form</li>
          </ul>
        </div>

        <div class="team-section">
          <h3>Assigned Members</h3>
          <div class="team-box">
            <label><input type="checkbox" checked> 👤 Ahmed</label>
            <label><input type="checkbox" checked> 👤 Adam997</label>
            <label><input type="checkbox"> 👤 keroum997</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

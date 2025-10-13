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
  <title>Team To-Do</title>
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
        <button class="menu-btn active" onclick="navigate('home.php')">🏠 Home</button>
        <button class="menu-btn" onclick="navigate('task.php')">✅ Task</button>
        <button class="menu-btn" onclick="navigate('settings.php')">⚙️ Setting</button>
      </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="content-box">
      <div class="content-header">
        <h2>Team To-Do</h2>
        <a href="../../../app/controllers/logout.php" class="logout">Logout</a>
      </div>

      <div class="task-team-section">
        <!-- قسم المهام -->
        <div class="task-section">
          <h3>My Task</h3>
          <div class="task-input">
            <input type="text" id="taskInput" placeholder="Enter new Task">
            <button onclick="addTask()">Add</button>
          </div>
          <ul id="taskList"></ul>
        </div>

        <!-- قسم الفريق -->
        <div class="team-section">
          <h3>Team</h3>
          <div class="team-box">
            <label><input type="checkbox" checked> 👤 Amin dpm</label>
            <label><input type="checkbox" checked> 👤 Adam997</label>
            <label><input type="checkbox" checked> 👤 keroum997</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

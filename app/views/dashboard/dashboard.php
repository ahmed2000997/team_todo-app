<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit;
}
$user = $_SESSION['user'];

$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'task', 'team', 'settings'];
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>Team Dashboard</title>
<link rel="stylesheet" href="../../../public/css/home.css">
<script src="../../../public/js/home.js" defer></script>

<style>
  body {
    font-family: "Tajawal", sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fb;
    color: #222;
    height: 100vh;
    display: flex;
  }

  /* ✅ الحاوية العامة */
  .main-container {
    display: flex;
    width: 100%;
    height: 100vh;
  }

  /* ✅ الشريط الجانبي */
  .sidebar {
    width: 230px;
    background-color: #ffffff;
    color: #222;
    padding: 25px 20px;
    border-right: 1px solid #e0e0e0;
    display: flex;
    flex-direction: column;
  }

  /* ✅ اسم الموقع في الأعلى */
  .site-name {
    font-size: 22px;
    font-weight: bold;
    color: #1e90ff;
    margin-bottom: 35px;
    text-align: center;
  }

  .menu {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .menu-btn {
    background: transparent;
    color: #333;
    border: none;
    text-align: left;
    padding: 10px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
    font-size: 15px;
    font-weight: 500;
  }

  .menu-btn:hover {
    background: #f0f0f5;
  }

  .menu-btn.active {
    background: #1e90ff;
    color: white;
  }

  /* ✅ منطقة المحتوى */
  .content-area {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #fff;
    height: 100vh;
    overflow-y: auto;
  }

  /* ✅ الشريط العلوي */
  .topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 25px;
    background: #f9fafc;
    border-bottom: 1px solid #e0e0e0;
  }

  .username {
    font-weight: 600;
    color: #333;
    font-size: 15px;
  }

  /* ✅ زر تسجيل الخروج */
  .logout {
    background: #d3d3d3;
    color: #000;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s, color 0.3s;
    font-size: 14px;
    font-weight: 500;
  }

  .logout:hover {
    background: #bfbfbf;
  }

  /* ✅ المحتوى الداخلي */
  .content-box {
    flex: 1;
    padding: 30px;
    overflow-y: auto;
  }
</style>
</head>

<body>
  <div class="main-container">

    <!-- ✅ الشريط الجانبي -->
    <div class="sidebar">
      <div class="site-name">Team To-Do</div>
      <div class="menu">
        <button class="menu-btn <?= $page == 'home' ? 'active' : '' ?>" onclick="navigateDashboard('home')">🏠 الصفحة الرئيسية</button>
        <button class="menu-btn <?= $page == 'task' ? 'active' : '' ?>" onclick="navigateDashboard('task')">✅ المهام</button>
        <button class="menu-btn <?= $page == 'team' ? 'active' : '' ?>" onclick="navigateDashboard('team')">👥 الفريق</button>
        <button class="menu-btn <?= $page == 'settings' ? 'active' : '' ?>" onclick="navigateDashboard('settings')">⚙️ الإعدادات</button>
      </div>
    </div>

    <!-- ✅ منطقة المحتوى -->
    <div class="content-area">
      <!-- الشريط العلوي -->
      <div class="topbar">
        <div class="username">👤 <?= htmlspecialchars($user['email']); ?></div>
        <a href="../../controllers/logout.php" class="logout">Logout</a>
      </div>

      <!-- المحتوى الديناميكي -->
      <div class="content-box">
        <?php
          $page_path = __DIR__ . "/{$page}.php";
          if (file_exists($page_path)) {
              include $page_path;
          } else {
              echo "<p>❌ الصفحة غير موجودة.</p>";
          }
        ?>
      </div>
    </div>
  </div>

<script>
function navigateDashboard(page) {
  window.location.href = "dashboard.php?page=" + page;
}
</script>
</body>
</html>

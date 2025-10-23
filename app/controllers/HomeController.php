<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/HomeModel.php";

if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json");

// ✅ تحقق من تسجيل الدخول
if (!isset($_SESSION['user']) || empty($_SESSION['user']['id_user'])) {
  echo json_encode(["success" => false, "message" => "⚠️ يرجى تسجيل الدخول."]);
  exit;
}

$userId = $_SESSION['user']['id_user'];
$homeModel = new HomeModel($pdo);

/* ==========================================================
   🔹 إضافة مهمة جديدة
   ========================================================== */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
  $title = trim($_POST["title"] ?? '');
  $description = trim($_POST["description"] ?? '');

  if (empty($title)) {
    echo json_encode(["success" => false, "message" => "⚠️ يرجى إدخال عنوان المهمة."]);
    exit;
  }

  try {
    $added = $homeModel->addTask($userId, $title, $description);

    if ($added) {
      echo json_encode(["success" => true, "message" => "✅ تم إضافة المهمة بنجاح."]);
    } else {
      echo json_encode(["success" => false, "message" => "❌ فشل في إضافة المهمة."]);
    }
  } catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "❌ خطأ أثناء إضافة المهمة: " . $e->getMessage()]);
  }

  exit; // 🧩 مهم لإيقاف التنفيذ بعد الإضافة
}

/* ==========================================================
   🔹 حذف مهمة
   ========================================================== */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "delete") {
  $taskId = intval($_POST["task_id"] ?? 0);

  if ($taskId <= 0) {
    echo json_encode(["success" => false, "message" => "❌ معرف المهمة غير صالح."]);
    exit;
  }

  try {
    $deleted = $homeModel->deleteTask($taskId, $userId);

    if ($deleted) {
      echo json_encode(["success" => true, "message" => "✅ تم حذف المهمة بنجاح."]);
    } else {
      echo json_encode(["success" => false, "message" => "⚠️ لم يتم العثور على المهمة أو لا تملك صلاحية حذفها."]);
    }
  } catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "❌ خطأ أثناء حذف المهمة: " . $e->getMessage()]);
  }

  exit;
}

/* ==========================================================
   🔹 جلب الفريق والمهام (الطلب الافتراضي)
   ========================================================== */
try {
  $members = $homeModel->getTeamMembers($userId);
  $tasks = $homeModel->getTasksByUserId($userId);

  echo json_encode([
    "success" => true,
    "members" => $members,
    "tasks" => $tasks
  ]);
} catch (Exception $e) {
  echo json_encode(["success" => false, "message" => "❌ فشل في جلب البيانات: " . $e->getMessage()]);
}
?>

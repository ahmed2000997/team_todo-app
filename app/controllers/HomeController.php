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

    // استقبال الأعضاء: نتوقع members[] أو فارغ
    $members = [];
    if (isset($_POST['members']) && is_array($_POST['members'])) {
        $members = $_POST['members'];
    } elseif (isset($_POST['members'])) {
        // حالة وصول قيمة واحدة كـ string (غير محتمل بعد التعديل) — نحاول تفاديه
        $members = explode(',', $_POST['members']);
    }

    // تنظيف وتحويل إلى أعداد صحيحة لتجنب SQL injection أو قيم غير مرغوبة
    $members = array_map('intval', $members);
    // إزالة القيم الصفرية أو السلبية الناتجة عن تحويل نصوص فارغة
    $members = array_values(array_filter($members, function($v) { return $v > 0; }));

    if (empty($title)) {
        echo json_encode(["success" => false, "message" => "⚠️ يرجى إدخال عنوان المهمة."]);
        exit;
    }

    try {
        $added = $homeModel->addTask($userId, $title, $description, $members);
        echo json_encode([
            "success" => $added,
            "message" => $added ? "✅ تم إضافة المهمة بنجاح." : "❌ فشل في إضافة المهمة."
        ]);
    } catch (Exception $e) {
        // أعد رسالة الخطأ لتساعد في التصحيح، لكن في بيئة انتاجية ضع رسالة عامة بدل التفاصيل
        echo json_encode(["success" => false, "message" => "❌ خطأ أثناء إضافة المهمة: " . $e->getMessage()]);
    }

    exit;
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

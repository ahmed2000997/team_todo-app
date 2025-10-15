<?php
require_once "../../config/database.php";
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user'])) {
  echo json_encode(["success" => false, "message" => "⚠️ يرجى تسجيل الدخول."]);
  exit;
}

$user = $_SESSION['user'];
$id_user = $user['id_user'];

/* ---------------------------------------------------
   🔹 1. عرض أعضاء الفريق الحالي
--------------------------------------------------- */
if (isset($_GET['action']) && $_GET['action'] === 'list') {
  $stmt = $pdo->prepare("
    SELECT u.id_user, u.email
    FROM team t
    JOIN users u ON t.id_team = u.id_user
    WHERE t.id_user = ?
  ");
  $stmt->execute([$id_user]);
  echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  exit;
}

/* ---------------------------------------------------
   🔹 2. البحث أو الإكمال التلقائي بالبريد الإلكتروني
--------------------------------------------------- */
if (isset($_GET['action']) && ($_GET['action'] === 'search' || $_GET['action'] === 'autocomplete')) {
  $email = trim($_GET['email'] ?? '');
  if ($email === '') {
    echo json_encode([]);
    exit;
  }

  $stmt = $pdo->prepare("
    SELECT id_user, email 
    FROM users 
    WHERE email LIKE ? AND id_user != ? 
    ORDER BY email ASC 
    LIMIT 10
  ");
  $stmt->execute(["%$email%", $id_user]);
  echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  exit;
}

/* ---------------------------------------------------
   🔹 3. إضافة عضو إلى الفريق
--------------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $friend_id = $data['friend_id'] ?? null;

  if (!$friend_id) {
    echo json_encode(["success" => false, "message" => "❌ معرف الصديق غير صالح"]);
    exit;
  }

  // تحقق إن كان العضو مضاف مسبقًا
  $check = $pdo->prepare("SELECT * FROM team WHERE id_user = ? AND id_team = ?");
  $check->execute([$id_user, $friend_id]);
  if ($check->rowCount() > 0) {
    echo json_encode(["success" => false, "message" => "✅ هذا الصديق مضاف مسبقًا"]);
    exit;
  }

  // أضف العضو الجديد
  $add = $pdo->prepare("INSERT INTO team (id_user, id_team) VALUES (?, ?)");
  $add->execute([$id_user, $friend_id]);

  echo json_encode(["success" => true, "message" => "👥 تمت إضافة الصديق بنجاح"]);
  exit;
}

/* ---------------------------------------------------
   🔹 4. إزالة عضو من الفريق
--------------------------------------------------- */
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
  $id_remove = $_GET['id'];
  $del = $pdo->prepare("DELETE FROM team WHERE id_user = ? AND id_team = ?");
  $del->execute([$id_user, $id_remove]);
  echo json_encode(["success" => true, "message" => "🚫 تمت إزالة العضو من الفريق"]);
  exit;
}

/* ---------------------------------------------------
   🔹 5. في حالة لم يتطابق أي طلب
--------------------------------------------------- */
echo json_encode(["success" => false, "message" => "طلب غير معروف"]);

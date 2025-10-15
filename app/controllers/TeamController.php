<?php
require_once "../../config/database.php";
require_once "../models/TeamModel.php";

session_start();
header("Content-Type: application/json");

// ✅ تحقق من تسجيل الدخول
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "⚠️ يرجى تسجيل الدخول."]);
    exit;
}

$user = $_SESSION['user'];
$id_user = $user['id_user'];

$model = new TeamModel($pdo);
$action = $_GET['action'] ?? '';

switch ($action) {

    /* ---------------------------------------------------
       🔹 1. عرض أعضاء الفريق الحالي
    --------------------------------------------------- */
    case 'list':
        echo json_encode($model->getTeamMembers($id_user));
        break;

    /* ---------------------------------------------------
       🔹 2. البحث أو الإكمال التلقائي بالبريد
    --------------------------------------------------- */
    case 'search':
    case 'autocomplete':
        $email = trim($_GET['email'] ?? '');
        if ($email === '') {
            echo json_encode([]);
            exit;
        }
        echo json_encode($model->searchUsers($email, $id_user));
        break;

    /* ---------------------------------------------------
       🔹 3. إزالة عضو من الفريق
    --------------------------------------------------- */
    case 'remove':
        $id_remove = $_GET['id'] ?? null;
        if (!$id_remove) {
            echo json_encode(["success" => false, "message" => "❌ معرف العضو غير صالح"]);
            exit;
        }
        $model->removeMember($id_user, $id_remove);
        echo json_encode(["success" => true, "message" => "🚫 تمت إزالة العضو من الفريق"]);
        break;

    /* ---------------------------------------------------
       🔹 4. إضافة عضو إلى الفريق
    --------------------------------------------------- */
    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $friend_id = $data['friend_id'] ?? null;

            if (!$friend_id) {
                echo json_encode(["success" => false, "message" => "❌ معرف الصديق غير صالح"]);
                exit;
            }

            if ($model->isAlreadyInTeam($id_user, $friend_id)) {
                echo json_encode(["success" => false, "message" => "✅ هذا الصديق مضاف مسبقًا"]);
                exit;
            }

            $model->addMember($id_user, $friend_id);
            echo json_encode(["success" => true, "message" => "👥 تمت إضافة الصديق بنجاح"]);
        } else {
            echo json_encode(["success" => false, "message" => "❌ طلب غير معروف"]);
        }
        break;
}

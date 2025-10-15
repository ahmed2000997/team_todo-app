<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../models/HomeModel.php";

if (session_status() === PHP_SESSION_NONE) session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user']) || empty($_SESSION['user']['id_user'])) {
  echo json_encode(["success" => false, "message" => "⚠️ يرجى تسجيل الدخول."]);
  exit;
}

$userId = $_SESSION['user']['id_user'];

// إنشاء كائن من TeamModel
$teamModel = new TeamModel($pdo);

// جلب أعضاء الفريق
try {
  $members = $teamModel->getTeamMembers($userId);
  echo json_encode(["success" => true, "members" => $members]);
} catch (Exception $e) {
  echo json_encode(["success" => false, "message" => "❌ فشل في جلب بيانات الفريق: " . $e->getMessage()]);
}

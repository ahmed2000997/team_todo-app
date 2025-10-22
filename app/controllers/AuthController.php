<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
session_start();

$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($user->register($email, $password)) {
            header("Location: ../../app/views/auth/login.php?registered=1");
            exit;
        } else {
            echo "❌  فشل إنشاء الحساب.";
        }
    }

    if ($action === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $loggedUser = $user->login($email, $password);
        if ($loggedUser) {
            $_SESSION['user'] = $loggedUser;
            header("Location: ../../app/views/dashboard/dashboard.php?page=home");
            exit;
        } else {
            echo "❌ البريد أو كلمة المرور غير صحيحة.";
        }
    }
}
?>

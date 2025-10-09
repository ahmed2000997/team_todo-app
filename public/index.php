<?php
session_start();

// نستخدم مسار نسبي صحيح عبر اسم المجلد
$basePath = '/team_todo-app/';

if (!isset($_SESSION['user'])) {
    header("Location: {$basePath}app/views/auth/login.php");
    exit;
}

header("Location: {$basePath}app/views/dashboard.php");
exit;
?>

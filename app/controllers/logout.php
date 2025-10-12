<?php
// تشغيل الجلسة أولًا إن لم تكن بدأت
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// حذف جميع بيانات الجلسة
$_SESSION = [];

// حذف الكوكيز الخاصة بالجلسة (احتياطًا)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// تدمير الجلسة نهائيًا
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول
header("Location: ../views/auth/login.php");
exit;
?>

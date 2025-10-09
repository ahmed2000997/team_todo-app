<?php
$host = 'localhost'; // اسم السيرفر (Host)
$dbname = 'team';           // اسم قاعدة البيانات
$username = 'root';           // اسم المستخدم
$password = '';      // كلمة المرور

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "✅ Database connected successfully!";
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>

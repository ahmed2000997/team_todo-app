# 🧩 Team Task Management App

تطبيق ويب لإدارة المهام والفرق (Team Task Management App) مبني باستخدام **PHP** و **MySQL** مع بنية **MVC** منظمة.  
يسمح للمستخدمين بتسجيل الدخول، وإنشاء مهام، ومتابعة التقدم لكل فريق في لوحة تحكم سهلة الاستخدام.

---

## 🚀 الميزات الرئيسية
- تسجيل الدخول والتسجيل للمستخدمين.
- إنشاء وحذف وتحديث المهام.
- عرض نسبة إنجاز المهام عبر واجهة رسومية.
- إدارة الفرق (إضافة / حذف أعضاء).
- اتصال بقاعدة بيانات **MySQL أونلاين**.

---

## ⚙️ الأدوات والتقنيات المستخدمة
| التقنية | الاستخدام |
|----------|------------|
| PHP | منطق الخادم ومعالجة الطلبات |
| MySQL (Online) | قاعدة البيانات السحابية |
| HTML / CSS | تصميم واجهات المستخدم |
| JavaScript | التفاعلات الديناميكية |
| Apache | خادم الويب (XAMPP أو استضافة مباشرة) |
| MVC Architecture | تنظيم الكود وفصل المهام |

---

## 🧱 بنية المشروع (Project Architecture)

```
team-todo-app/
│
├── app/
│   ├── controllers/
│   │   ├── AuthController.php     # تسجيل الدخول والتسجيل
│   │   ├── TaskController.php     # إدارة المهام (إضافة، حذف، تحديث)
│   │   └── TeamController.php     # إدارة الفرق والأعضاء
│   │
│   ├── models/
│   │   ├── User.php               # كائن المستخدم (User model)
│   │   ├── Task.php               # كائن المهام (Task model)
│   │   └── Team.php               # كائن الفريق (Team model)
│   │
│   └── views/
│       ├── auth/                  # واجهات الدخول والتسجيل
│       ├── dashboard/             # واجهات المهام، الفريق، الإعدادات
│       └── layout/                # ملفات الرأس والتذييل
│
├── config/
│   └── database.php               # إعداد الاتصال بقاعدة البيانات (Online MySQL)
│
├── public/
│   ├── css/style.css              # تنسيقات الواجهة
│   ├── js/app.js                  # الأكواد الجافاسكريبتية
│   └── index.php                  # نقطة الدخول الرئيسية
│
└── .htaccess                      # توجيه الطلبات إلى index.php
```

---

## 🌐 إعداد الاتصال بقاعدة بيانات MySQL أونلاين

افتح الملف:
```
config/database.php
```

واكتب الإعدادات بهذا الشكل:

```php
<?php
$host = 'sql-yourhost.com'; // رابط السيرفر أو IP
$dbname = 'team_todo_db';
$username = 'db_user';
$password = 'db_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
```

---

## 🧠 ما هو MVC؟

**MVC** اختصار لـ **Model - View - Controller**  
وهي طريقة لتنظيم الكود تسهّل تطوير المشاريع الكبيرة.

| المكوّن | الوصف | مثال |
|----------|--------|-------|
| **Model** | يتعامل مع البيانات وقاعدة البيانات | `User.php`, `Task.php` |
| **View** | واجهة المستخدم التي يراها المستخدم | `login.php`, `dashboard.php` |
| **Controller** | يربط بين الواجهة والبيانات | `AuthController.php` |

**مثال بسيط:**  
عندما يسجل المستخدم دخوله:
1. يرسل النموذج (View) البيانات إلى `AuthController`  
2. `AuthController` يتحقق من المستخدم من خلال `User` (Model)  
3. ثم يعرض النتيجة للمستخدم عبر صفحة `dashboard.php` (View).

---
 🧑‍💻 المطور
**Developed by:** Ahmed Kerou  
**Purpose:** تطبيق عملي لتجربة بنية MVC وربط قاعدة بيانات MySQL أونلاين.

---

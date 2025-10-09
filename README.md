# 🧩 Team Task Management App

A web application for managing teams and tasks, built with **PHP** and **MySQL** following the **MVC architecture**.  
It allows users to register, log in, create and manage tasks, and track progress for each team in a clean dashboard.

---

## 🚀 Main Features
- User authentication (login & registration)
- Task creation, deletion, and updates
- Task progress tracking with visual indicators
- Team management (add/remove members)
- Connection to an **online MySQL database**

---

## ⚙️ Technologies Used
| Technology | Purpose |
|-------------|----------|
| PHP | Backend logic and request handling |
| MySQL (Online) | Cloud database |
| HTML / CSS | Frontend structure and styling |
| JavaScript | Dynamic interactions |
| Apache | Web server (XAMPP or online hosting) |
| MVC Architecture | Code organization and separation of concerns |

---

## 🧱 Project Architecture

```
team-todo-app/
│
├── app/
│   ├── controllers/
│   │   ├── AuthController.php     # Handles login and registration
│   │   ├── TaskController.php     # Manages tasks (add, delete, update)
│   │   └── TeamController.php     # Manages team operations
│   │
│   ├── models/
│   │   ├── User.php               # User model
│   │   ├── Task.php               # Task model
│   │   └── Team.php               # Team model
│   │
│   └── views/
│       ├── auth/                  # Login and registration pages
│       ├── dashboard/             # Task, team, and settings views
│       └── layout/                # Common header/footer files
│
├── config/
│   └── database.php               # Database connection (Online MySQL)
│
├── public/
│   ├── css/style.css              # Stylesheets
│   ├── js/app.js                  # JavaScript logic
│   └── index.php                  # Main entry point
│
└── .htaccess                      # Redirects all requests to index.php
```

---

## 🌐 Online MySQL Database Connection

Open the file:
```
config/database.php
```

And configure your connection like this:

```php
<?php
$host = 'sql-yourhost.com'; // Your server host or IP
$dbname = 'team_todo_db';
$username = 'db_user';
$password = 'db_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
```

---

## 🧠 What is MVC?

**MVC** stands for **Model - View - Controller**, a software architecture pattern that separates the application logic.

| Component | Description | Example |
|------------|--------------|----------|
| **Model** | Handles data and database interaction | `User.php`, `Task.php` |
| **View** | Displays the user interface | `login.php`, `dashboard.php` |
| **Controller** | Connects user input with models and views | `AuthController.php` |

**Example:**  
When a user logs in:  
1. The login form (View) sends data to `AuthController`  
2. `AuthController` checks the user data through the `User` (Model)  
3. If successful, it redirects to the `dashboard.php` (View).

---


## 💡 Notes
- Update the `database.php` file with your own online MySQL credentials.
- You can deploy the app using free hosts like **000webhost** or **InfinityFree** to test the online connection.

---

## 👨‍💻 Developer
**Developed by:** Ahmed Kerou  
**Purpose:** A practical project to demonstrate MVC architecture and online MySQL integration.

---

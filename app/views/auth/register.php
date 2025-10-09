<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>Register - Team To-Do App</title>
<link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
<div class="container">
  <h2>🧾 Create Account</h2>
  <form method="POST" action="../../../app/controllers/AuthController.php">
    <input type="hidden" name="action" value="register">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
  </form>
  <p><a href="login.php">Back to login</a></p>
</div>
</body>
</html>

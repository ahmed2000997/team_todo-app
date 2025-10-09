<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>Team To-Do App - Login</title>
<link rel="stylesheet" href="../../../public/css/style.css">
</head>
<body>
<div class="container">
  <h2>✅ Team To-Do App</h2>
  <form method="POST" action="../../../app/controllers/AuthController.php">
    <input type="hidden" name="action" value="login">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
  </form>
  <p><a href="register.php">Create account</a></p>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Kasir Online</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to right, #00c6ff, #0072ff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      background-color: #fff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-box h2 {
      margin-bottom: 25px;
      color: #333;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      transition: 0.3s ease;
    }

    .login-box input[type="text"]:focus,
    .login-box input[type="password"]:focus {
      border-color: #00c6ff;
      outline: none;
    }

    .login-box input[type="submit"] {
      width: 100%;
      background-color: #0072ff;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .login-box input[type="submit"]:hover {
      background-color: #005cd3;
    }

    .error {
      color: #e74c3c;
      background: #ffe0e0;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .footer-text {
      margin-top: 20px;
      font-size: 14px;
      color: #aaa;
    }

  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login Kasir Online</h2>

    <?php if (isset($_GET['error'])): ?>
      <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Masuk">
    </form>

    <div class="footer-text">
      © <?= date('Y') ?> Kasir Online. All rights reserved By Fatur.
    </div>
  </div>

</body>
</html>

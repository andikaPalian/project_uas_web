<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LOGIN FORM</title>
  <link rel="stylesheet" href="/umkm_app/public/assets/css/login.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="wrapper">
    <form action="?page=login_proses" method="POST">
      <h1>Login</h1>

      <?php if (isset($_SESSION['error'])): ?>
        <div style="color:red; font-weight:bold; margin-bottom:10px; text-align:center">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <div class="input-box">
        <input type="text" placeholder="Username" name="username">
        <i class='bx bxs-user'></i>
      </div>

      <div class="input-box">
        <input type="password" placeholder="Password" name="password">
        <i class='bx bxs-lock-alt'></i>
      </div>

      <button type="submit" class="btn">Login</button>
    </form>
  </div>
</body>
</html>

<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Tambah User</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <div style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form action="?page=user_simpan" method="POST">
    <div>
      <label>Username</label>
      <input type="text" name="username" required>
    </div>
    <div>
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <div>
      <label>Role</label>
      <select name="role" required>
        <option value="admin">Admin</option>
        <option value="kasir">Kasir</option>
      </select>
    </div>
    <br>
    <button type="submit">Simpan</button>
  </form>
</div>

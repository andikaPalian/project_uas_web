<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Daftar User</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <a href="?page=user_tambah">+ Tambah User</a>

  <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:10px;">
    <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Role</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $i => $user): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($user['username']) ?></td>
          <td><?= htmlspecialchars($user['role']) ?></td>
          <td>
            <a href="?page=user_edit&id=<?= $user['id'] ?>">Edit</a> |
            <a href="?page=user_hapus&id=<?= $user['id'] ?>" onclick="return confirm('Hapus user ini?')">Hapus</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

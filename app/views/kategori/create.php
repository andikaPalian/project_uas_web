<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Tambah Kategori</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <div style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <form action="?page=kategori_simpan" method="POST">
    <div>
      <label>Nama Kategori</label>
      <input type="text" name="nama_kategori" required>
    </div>
    <br>
    <button type="submit">Simpan</button>
  </form>
</div>

<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Daftar Kategori</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error'])): ?>
    <div style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <a href="?page=kategori_tambah">+ Tambah Kategori</a>

  <table border="1" cellpadding="8" cellspacing="0" style="margin-top: 10px;">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($kategori as $i => $item): ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($item['nama_kategori']) ?></td>
        <td>
          <a href="?page=kategori_edit&id=<?= $item['id'] ?>">Edit</a> |
          <a href="?page=kategori_hapus&id=<?= $item['id'] ?>" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

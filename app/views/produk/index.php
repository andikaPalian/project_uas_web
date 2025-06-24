<?php require_once BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php require_once BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Daftar Produk</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div style="color: green;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <a href="?page=produk_tambah">+ Tambah Produk</a>

  <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; margin-top: 10px;">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Deskripsi</th>
        <th>Gambar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($produk as $i => $item): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($item['nama']) ?></td>
          <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
          <td><?= $item['stok'] ?></td>
          <td><?= nl2br(htmlspecialchars($item['deskripsi'])) ?></td>
          <td>
            <?php if (!empty($item['gambar'])): ?>
              <img src="uploads/produk/<?= htmlspecialchars($item['gambar']) ?>" width="60" alt="gambar">
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td>
            <a href="?page=produk_edit&id=<?= $item['id'] ?>">Edit</a> |
            <a href="?page=produk_hapus&id=<?= $item['id'] ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Edit Produk</h2>

  <form action="?page=produk_update&id=<?= $produk['id'] ?>" method="POST" enctype="multipart/form-data">
    <div>
      <label>Nama Produk</label>
      <input type="text" name="nama" value="<?= htmlspecialchars($produk['nama']) ?>" required>
    </div>

    <div>
      <label>Harga</label>
      <input type="number" step="0.01" name="harga" value="<?= $produk['harga'] ?>" required>
    </div>

    <div>
      <label>Stok</label>
      <input type="number" name="stok" value="<?= $produk['stok'] ?>" required>
    </div>

    <div>
      <label>Deskripsi</label>
      <textarea name="deskripsi" rows="4"><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
    </div>

    <div>
      <label>Gambar Saat Ini</label><br>
      <?php if ($produk['gambar']): ?>
        <img src="uploads/produk/<?= $produk['gambar'] ?>" width="100"><br>
      <?php endif; ?>
      <label>Ganti Gambar (opsional)</label>
      <input type="file" name="gambar">
    </div>

    <div>
      <label>Kategori</label>
      <select name="id_kategori">
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= $k['id'] ?>" <?= $produk['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['nama']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <button type="submit">Update Produk</button>
  </form>
</div>

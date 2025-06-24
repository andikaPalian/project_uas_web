<?php include BASE_PATH . '/app/views/layouts/navbar.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div class="container">
  <h2>Tambah Produk</h2>

  <form action="?page=produk_simpan" method="POST" enctype="multipart/form-data">
    <div>
      <label>Nama Produk</label>
      <input type="text" name="nama" value="" required>
    </div>

    <div>
      <label>Harga</label>
      <input type="number" step="0.01" name="harga" value="" required>
    </div>

    <div>
      <label>Stok</label>
      <input type="number" name="stok" value="0" required>
    </div>

    <div>
      <label>Deskripsi</label>
      <textarea name="deskripsi" rows="4"></textarea>
    </div>

    <div>
      <label>Gambar</label>
      <input type="file" name="gambar">
    </div>

    <div>
      <label>Kategori</label>
      <select name="id_kategori">
        <option value="">-- Pilih Kategori --</option>
        <!-- contoh statis -->
        <!-- <option value="1">Makanan</option> -->
        <!-- <option value="2">Minuman</option> -->
        <!-- bisa kamu loop dari database juga -->
      </select>
    </div>

    <button type="submit">Simpan Produk</button>
  </form>
</div>

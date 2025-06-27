<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Produk</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="card-title m-0 fw-bold">Tambah Produk Baru</h5>
        </div>
        <div class="card-body">
            <form action="?page=produk_simpan" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                    </div>
                    <!-- Kolom Kanan -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="id_kategori" name="id_kategori" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                         <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            <input class="form-control" type="file" id="gambar" name="gambar">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=produk" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</main>
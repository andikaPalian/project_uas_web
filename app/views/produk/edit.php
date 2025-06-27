<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">
             <a href="?page=produk" class="text-dark text-decoration-none">Edit Produk</a>
        </h4>
    </div>
</nav>

<main class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="card-title m-0 fw-bold">Edit Produk: <span class="text-primary"><?= htmlspecialchars($produk['nama']) ?></span></h5>
        </div>
        <div class="card-body">
            <form action="?page=produk_update&id=<?= $produk['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($produk['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="9"><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Atribut Produk</h6>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="harga" name="harga" value="<?= $produk['harga'] ?>" min="0" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" value="<?= $produk['stok'] ?>" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="id_kategori" name="id_kategori" required>
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        <?php foreach ($kategori as $k): ?>
                                            <option value="<?= $k['id'] ?>" <?= $produk['id_kategori'] == $k['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($k['nama_kategori']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="gambar" class="form-label">Ganti Gambar (Opsional)</label>
                                    <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                                    <?php if ($produk['gambar']): ?>
                                        <div class="mt-2">
                                            <small class="text-muted">Gambar saat ini:</small>
                                            <img src="uploads/produk/<?= $produk['gambar'] ?>" class="img-thumbnail mt-1" width="100" alt="Gambar saat ini">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=produk" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</main>

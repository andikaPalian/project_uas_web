<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Kategori</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0" style="max-width: 600px; margin: auto;">
        <div class="card-header bg-white">
            <h5 class="card-title m-0 fw-bold">Tambah Kategori Baru</h5>
        </div>
        <div class="card-body">
            <!-- Pesan Error -->
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>

            <form action="?page=kategori_simpan" method="POST">
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required autofocus>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="?page=kategori" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</main>
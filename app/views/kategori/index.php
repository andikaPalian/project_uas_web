<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Kategori</h4>
    </div>
</nav>

<main class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title m-0 fw-bold">Daftar Kategori Produk</h5>
            <a href="?page=kategori_tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Kategori
            </a>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>

            <div class="list-group">
                <?php if (empty($kategori)): ?>
                    <div class="text-center p-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Kategori</h5>
                        <p class="text-muted">Silakan tambahkan kategori baru.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($kategori as $item): ?>
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><?= htmlspecialchars($item['nama_kategori']) ?></span>
                            <div class="d-flex gap-2">
                                <a href="?page=kategori_edit&id=<?= $item['id'] ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?page=kategori_hapus&id=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Menghapus kategori akan menghapus produk terkait. Anda yakin?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

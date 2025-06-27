<?php
// /user/index.php

// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Pengguna</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title m-0 fw-bold">Daftar Pengguna</h5>
            <a href="?page=user_tambah" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i> Tambah Pengguna
            </a>
        </div>
        <div class="card-body">
            <!-- Pesan Notifikasi -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Daftar Pengguna -->
            <div class="list-group">
                <?php if (empty($users)): ?>
                    <div class="text-center p-5">
                        <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Pengguna</h5>
                        <p class="text-muted">Silakan tambahkan pengguna baru.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <div class="list-group-item list-group-item-action d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x text-muted me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold"><?= htmlspecialchars($user['username']) ?></h6>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span class="badge bg-primary">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Kasir</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="?page=user_edit&id=<?= $user['id'] ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <?php if ($_SESSION['user']['id'] !== $user['id']): // Mencegah user menghapus diri sendiri ?>
                                <a href="?page=user_hapus&id=<?= $user['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                <?php else: ?>
                                    <button class="btn btn-outline-danger btn-sm" disabled>
                                         <i class="fas fa-trash"></i> Hapus
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

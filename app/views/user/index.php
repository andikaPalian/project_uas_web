<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Pengguna</h4>
        <div class="d-flex align-items-center">
            <span class="me-3">Login sebagai: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></span>
            <a href="?page=logout" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold">Daftar Pengguna</h5>
            <a href="?page=user_tambah" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Pengguna
            </a>
        </div>
        <div class="card-body">
            <!-- Pesan Notifikasi -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data pengguna.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $i => $user): ?>
                                <tr>
                                    <th scope="row"><?= $i + 1 ?></th>
                                    <td class="fw-bold"><?= htmlspecialchars($user['username']) ?></td>
                                    <td>
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <span class="badge bg-primary">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Kasir</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="?page=user_edit&id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <?php if ($_SESSION['user']['id'] !== $user['id']): // Mencegah user menghapus diri sendiri ?>
                                        <a href="?page=user_hapus&id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
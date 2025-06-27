<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Riwayat Transaksi</h4>
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
            <h5 class="card-title m-0 fw-bold">Daftar Transaksi</h5>
            <a href="?page=transaksi_tambah" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Buat Transaksi Baru
            </a>
        </div>
        <div class="card-body">
            <!-- Pesan Sukses -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Transaksi</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Kasir</th>
                            <th scope="col" class="text-end">Total</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transaksi)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada riwayat transaksi.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transaksi as $i => $item): ?>
                                <tr>
                                    <th scope="row"><?= $i + 1 ?></th>
                                    <td>#<?= htmlspecialchars($item['id']) ?></td>
                                    <td><?= date('d M Y, H:i', strtotime($item['tanggal'])) ?></td>
                                    <td><?= htmlspecialchars($item['username'] ?? 'N/A') ?></td>
                                    <td class="text-end fw-bold">Rp<?= number_format($item['total'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="?page=transaksi_detail&id=<?= $item['id'] ?>" class="btn btn-info btn-sm text-white">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
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
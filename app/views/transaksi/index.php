<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Riwayat Transaksi</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title m-0 fw-bold">Daftar Transaksi</h5>
            <a href="?page=transaksi_tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Buat Transaksi Baru
            </a>
        </div>
        <div class="card-body">
            <!-- Pesan Sukses -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>

            <div class="list-group">
                <?php if (empty($transaksi)): ?>
                    <div class="text-center p-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Riwayat Transaksi</h5>
                        <p class="text-muted">Mulai buat transaksi baru untuk melihat riwayat di sini.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($transaksi as $item): ?>
                        <div class="list-group-item list-group-item-action d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-receipt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">ID Transaksi: #<?= htmlspecialchars($item['id']) ?></h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i> <?= date('d M Y, H:i', strtotime($item['tanggal'])) ?> | 
                                        <i class="fas fa-user me-1"></i> <?= htmlspecialchars($item['username'] ?? 'N/A') ?>
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fw-bold fs-5 text-success">Rp<?= number_format($item['total'], 0, ',', '.') ?></span>
                                <a href="?page=transaksi_detail&id=<?= $item['id'] ?>" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

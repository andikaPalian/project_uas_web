<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Detail Transaksi</h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title m-0 fw-bold">ID Transaksi: #<?= $transaksi['id'] ?></h5>
                <small class="text-muted">
                    Tanggal: <?= date('d F Y, H:i', strtotime($transaksi['tanggal'])) ?> | Kasir: <?= htmlspecialchars($transaksi['username'] ?? 'N/A') ?>
                </small>
            </div>
            <a href="?page=transaksi" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Produk</th>
                            <th scope="col" class="text-end">Harga Satuan</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td class="text-end">Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="text-center"><?= $item['jumlah'] ?></td>
                            <td class="text-end">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end fs-5">Total</th>
                            <th class="text-end fs-5 fw-bold">Rp<?= number_format($transaksi['total'], 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>

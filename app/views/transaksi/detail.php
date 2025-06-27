<?php
// /transaksi/detail.php

// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">
             <a href="?page=transaksi" class="text-dark text-decoration-none">Detail Transaksi</a>
        </h4>
    </div>
</nav>

<!-- Konten Utama -->
<main class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h5 class="card-title m-0 fw-bold">Detail Transaksi</h5>
                        <small class="text-muted">ID: #<?= $transaksi['id'] ?></small>
                    </div>
                    <a href="?page=transaksi" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <!-- Info Transaksi -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Tanggal Transaksi:</strong>
                            <p><?= date('d F Y, H:i', strtotime($transaksi['tanggal'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Kasir:</strong>
                            <p><?= htmlspecialchars($transaksi['username'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                    
                    <!-- Tabel Item -->
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
                                    <td class="text-center">x <?= $item['jumlah'] ?></td>
                                    <td class="text-end">Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end border-0 fs-5"><strong>Total Akhir</strong></td>
                                    <td class="text-end border-0 fs-5 fw-bold text-success"><strong>Rp<?= number_format($transaksi['total'], 0, ',', '.') ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                 <div class="card-footer bg-white text-center">
                     <button class="btn btn-outline-primary" onclick="window.print()"><i class="fas fa-print me-2"></i>Cetak Struk</button>
                 </div>
            </div>
        </div>
    </div>
</main>

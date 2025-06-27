<?php
// Memuat layout header dan sidebar
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Produk</h4>
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
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="card-title m-0 fw-bold">Daftar Produk</h5>
            <a href="?page=produk_tambah" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Produk
            </a>
        </div>
        <div class="card-body">
            <!-- Pesan Sukses -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>

            <!-- BARU: Kotak Pencarian -->
            <div class="mb-3">
                <input type="text" id="productSearchInput" class="form-control" placeholder="Cari produk...">
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Stok</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <!-- BARU: ID untuk tbody agar mudah dimanipulasi JS -->
                    <tbody id="productTableBody">
                        <?php if (empty($produk)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data produk.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($produk as $i => $item): ?>
                                <!-- BARU: Class dan data-name untuk filtering -->
                                <tr class="product-row" data-name="<?= strtolower(htmlspecialchars($item['nama'])) ?>">
                                    <th scope="row"><?= $i + 1 ?></th>
                                    <td>
                                        <?php if (!empty($item['gambar'])): ?>
                                            <img src="uploads/produk/<?= htmlspecialchars($item['gambar']) ?>" width="60" height="60" class="rounded object-fit-cover" alt="Gambar Produk">
                                        <?php else: ?>
                                            <img src="https://placehold.co/60x60/eef2f5/9da5b5?text=N/A" class="rounded" alt="Tidak ada gambar">
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold"><?= htmlspecialchars($item['nama']) ?></td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($item['nama_kategori'] ?? 'N/A') ?></span></td>
                                    <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                                    <td><?= $item['stok'] ?></td>
                                    <td class="text-center">
                                        <a href="?page=produk_edit&id=<?= $item['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?page=produk_hapus&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- BARU: Baris untuk pesan "tidak ditemukan" -->
                        <tr id="no-results-row" style="display: none;">
                            <td colspan="7" class="text-center text-muted">Produk tidak ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- BARU: Script untuk fungsionalitas pencarian -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearchInput');
    const tableBody = document.getElementById('productTableBody');
    const productRows = tableBody.querySelectorAll('.product-row');
    const noResultsRow = document.getElementById('no-results-row');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleRows = 0;

        productRows.forEach(row => {
            const productName = row.dataset.name;
            if (productName.includes(searchTerm)) {
                row.style.display = ''; // Tampilkan baris
                visibleRows++;
            } else {
                row.style.display = 'none'; // Sembunyikan baris
            }
        });

        // Tampilkan atau sembunyikan pesan "tidak ditemukan"
        if (visibleRows > 0) {
            noResultsRow.style.display = 'none';
        } else {
            noResultsRow.style.display = '';
        }
    });
});
</script>
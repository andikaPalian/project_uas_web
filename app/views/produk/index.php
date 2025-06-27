<?php
require_once BASE_PATH . '/app/views/layouts/header.php';
require_once BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <h4 class="m-0 fw-bold">Kelola Produk</h4>
    </div>
</nav>

<main class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h4 class="m-0 fw-bold">Daftar Produk</h4>
        <div class="d-flex gap-2 flex-wrap">
            <div class="input-group" style="width: 250px;">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search"></i></span>
                <input type="text" id="productSearchInput" class="form-control border-start-0" placeholder="Cari produk...">
            </div>
            <a href="?page=produk_tambah" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Produk
            </a>
        </div>
    </div>

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

    <div class="row g-4" id="productGrid">
        <?php if (empty($produk)): ?>
            <div class="col-12">
                <div class="card shadow-sm border-0 text-center p-5">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Produk</h5>
                        <p class="text-muted">Silakan tambahkan produk baru untuk memulai.</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($produk as $item): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3 product-card" data-name="<?= strtolower(htmlspecialchars($item['nama'])) ?>">
                    <div class="card h-100 shadow-sm border-0 product-card-hover">
                        <div class="position-relative">
                        <img src="<?= !empty($item['gambar']) ? 'uploads/produk/' . htmlspecialchars($item['gambar']) : 'https://placehold.co/600x400/eef2f5/9da5b5?text=N/A' ?>" class="card-img-top" alt="<?= htmlspecialchars($item['nama']) ?>" style="height: 200px; object-fit: cover;">
                        <span class="badge bg-primary position-absolute top-0 end-0 m-2"><?= htmlspecialchars($item['nama_kategori'] ?? 'N/A') ?></span>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-1 flex-grow-1"><?= htmlspecialchars($item['nama']) ?></h5>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="card-text text-success fw-bold fs-5 m-0">Rp<?= number_format($item['harga'], 0, ',', '.') ?></p>
                                <p class="text-muted small m-0">Stok: <?= $item['stok'] ?></p>
                            </div>

                            <div class="d-grid gap-2 d-flex justify-content-end">
                                <a href="?page=produk_edit&id=<?= $item['id'] ?>" class="btn btn-outline-warning btn-sm px-3">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="?page=produk_hapus&id=<?= $item['id'] ?>" class="btn btn-outline-danger btn-sm px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div id="no-results-card" class="col-12" style="display: none;">
             <div class="card shadow-sm border-0 text-center p-5">
                <div class="card-body">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Produk Tidak Ditemukan</h5>
                    <p class="text-muted">Coba gunakan kata kunci lain untuk pencarian.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .product-card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .product-card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearchInput');
    const productGrid = document.getElementById('productGrid');
    const productCards = productGrid.querySelectorAll('.product-card');
    const noResultsCard = document.getElementById('no-results-card');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCards = 0;

        productCards.forEach(card => {
            const productName = card.dataset.name;
            if (productName.includes(searchTerm)) {
                card.style.display = '';
                visibleCards++;
            } else {
                card.style.display = 'none';
            }
        });

        noResultsCard.style.display = visibleCards > 0 ? 'none' : '';
    });
});
</script>

<aside class="sidebar bg-white shadow-sm d-flex flex-column flex-shrink-0 p-3">
    
    <a href="?page=dashboard" class="d-flex align-items-center mb-4 text-dark text-decoration-none">
        <i class="fas fa-store fa-lg me-2 text-primary"></i>
        <span class="fs-4 fw-bold">UMKM</span>
    </a>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <?php 
        $currentPage = $_GET['page'] ?? 'dashboard'; 
        ?>
        
        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <li class="nav-item">
                <a href="?page=dashboard" class="nav-link <?= ($currentPage === 'dashboard') ? 'active' : 'text-dark' ?>">
                    <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="?page=produk" class="nav-link <?= ($currentPage === 'produk') ? 'active' : 'text-dark' ?>">
                    <i class="fas fa-box-open fa-fw"></i> Kelola Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="?page=kategori" class="nav-link <?= ($currentPage === 'kategori') ? 'active' : 'text-dark' ?>">
                    <i class="fas fa-tags fa-fw"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="?page=user" class="nav-link <?= ($currentPage === 'user') ? 'active' : 'text-dark' ?>">
                    <i class="fas fa-users-cog fa-fw"></i> Kelola User
                </a>
            </li>
            <li class="nav-item">
                <a href="?page=transaksi" class="nav-link <?= ($currentPage === 'transaksi') ? 'active' : 'text-dark' ?>">
                    <i class="fas fa-receipt fa-fw"></i> Transaksi
                </a>
            </li>
        <?php elseif ($_SESSION['user']['role'] === 'kasir'): ?>
            <li class="nav-item">
                <a href="?page=transaksi" class="nav-link <?= ($currentPage === 'transaksi') ? 'active' : 'text-dark' ?>">
                    <i class="fas fa-receipt fa-fw"></i> Transaksi
                </a>
            </li>
        <?php endif; ?>
    </ul>
    
    <div class="mt-auto">
        <hr>
        <div class="d-flex align-items-center">
            <i class="fas fa-user-circle fa-2x text-muted me-3"></i>
            <div class="d-flex flex-column">
                <strong class="text-dark"><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
                <a href="?page=logout" class="text-danger text-decoration-none small">
                    <i class="fas fa-sign-out-alt fa-fw me-1"></i>Logout
                </a>
            </div>
        </div>
    </div>
</aside>

<div class="content-wrapper">

<!-- Sidebar dengan tema gelap dari Bootstrap -->
<aside class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
    <!-- Judul/Branding Sidebar -->
    <a href="?page=dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="fas fa-store fa-lg me-2"></i>
        <span class="fs-4">UMKM Sidrap</span>
    </a>
    <hr>
    
    <!-- Daftar Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <?php 
        // Mengambil halaman saat ini dari URL untuk menandai menu aktif
        $currentPage = $_GET['page'] ?? 'dashboard'; 
        ?>
        
        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <li class="nav-item mb-1">
                <a href="?page=dashboard" class="nav-link text-white <?= ($currentPage === 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="?page=produk" class="nav-link text-white <?= ($currentPage === 'produk') ? 'active' : '' ?>">
                    <i class="fas fa-box-open"></i> Kelola Produk
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="?page=kategori" class="nav-link text-white <?= ($currentPage === 'kategori') ? 'active' : '' ?>">
                    <i class="fas fa-tags"></i> Kategori
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="?page=user" class="nav-link text-white <?= ($currentPage === 'user') ? 'active' : '' ?>">
                    <i class="fas fa-users-cog"></i> Kelola User
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="?page=transaksi" class="nav-link text-white <?= ($currentPage === 'transaksi') ? 'active' : '' ?>">
                    <i class="fas fa-receipt"></i> Transaksi
                </a>
            </li>
        <?php elseif ($_SESSION['user']['role'] === 'kasir'): ?>
            <li class="nav-item mb-1">
                <a href="?page=transaksi" class="nav-link text-white <?= ($currentPage === 'transaksi') ? 'active' : '' ?>">
                    <i class="fas fa-receipt"></i> Transaksi
                </a>
            </li>
        <?php endif; ?>
    </ul>
    <hr>
    <!-- Bisa ditambahkan info user di sini jika mau -->
</aside>

<!-- Wrapper untuk Navbar dan Konten -->
<div class="content-wrapper">

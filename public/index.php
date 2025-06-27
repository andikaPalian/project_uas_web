<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

// Load koneksi hanya sekali
require_once BASE_PATH . '/app/config/koneksi.php';

// Ambil page dari URL
$page = $_GET['page'] ?? 'login';

// Halaman publik (tanpa login)
$publicPages = ['login', 'login_proses'];

// Cek autentikasi untuk halaman yang butuh login
if (!in_array($page, $publicPages) && !isset($_SESSION['user'])) {
    header('Location: ?page=login');
    exit;
}

switch ($page) {
    case 'login':
        require_once BASE_PATH . '/app/controllers/AuthController.php';
        showLogin();
        break;

    case 'login_proses':
        require_once BASE_PATH . '/app/controllers/AuthController.php';
        handleLogin($conn);
        break;

    case 'logout':
        require_once BASE_PATH . '/app/controllers/AuthController.php';
        logout();
        break;

    case 'dashboard':
        require_once BASE_PATH . '/app/views/dashboard/index.php';
        break;

    case 'produk':
        require_once BASE_PATH . '/app/controllers/ProdukController.php';
        listProduk($conn);
        break;

    case 'produk_tambah':
        require_once BASE_PATH . '/app/controllers/ProdukController.php';
        showTambahProdukForm($conn);
        break;

    case 'produk_simpan':
        require_once BASE_PATH . '/app/controllers/ProdukController.php';
        storeProduk($conn);
        break;

    case 'produk_edit':
        require_once BASE_PATH . '/app/controllers/ProdukController.php';
        showFormEditProduk($conn, $_GET['id']);
        break;

    case 'produk_update':
        require_once BASE_PATH . '/app/controllers/ProdukController.php';
        updateProdukProses($conn, $_GET['id']);
        break;

    case 'produk_hapus':
        require_once BASE_PATH . '/app/controllers/ProdukController.php';
        hapusProduk($conn, $_GET['id']);
        break;

    case 'kategori':
        require_once BASE_PATH . '/app/controllers/KategoriController.php';
        listKategori($conn);
        break;

    case 'kategori_tambah':
        require_once BASE_PATH . '/app/controllers/KategoriController.php';
        showFormTambahKategori();
        break;

    case 'kategori_simpan':
        require_once BASE_PATH . '/app/controllers/KategoriController.php';
        simpanKategori($conn);
        break;

    case 'kategori_edit':
        require_once BASE_PATH . '/app/controllers/KategoriController.php';
        showFormEditKategori($conn, $_GET['id']);
        break;

    case 'kategori_update':
        require_once BASE_PATH . '/app/controllers/KategoriController.php';
        updateKategoriProses($conn, $_GET['id']);
        break;

    case 'kategori_hapus':
        require_once BASE_PATH . '/app/controllers/KategoriController.php';
        hapusKategori($conn, $_GET['id']);
        break;

    case 'user':
        require_once BASE_PATH . '/app/controllers/UserController.php';
        listUser($conn);
        break;

    case 'user_tambah':
        require_once BASE_PATH . '/app/controllers/UserController.php';
        showFormTambahUser();
        break;

    case 'user_simpan':
        require_once BASE_PATH . '/app/controllers/UserController.php';
        simpanUser($conn);
        break;

    case 'user_edit':
        require_once BASE_PATH . '/app/controllers/UserController.php';
        showFormEditUser($conn, $_GET['id']);
        break;

    case 'user_update':
        require_once BASE_PATH . '/app/controllers/UserController.php';
        updateUserProses($conn, $_GET['id']);
        break;

    case 'user_hapus':
        require_once BASE_PATH . '/app/controllers/UserController.php';
        hapusUser($conn, $_GET['id']);
        break;

    case 'transaksi':
        require_once BASE_PATH . '/app/controllers/TransaksiController.php';
        listTransaksi($conn);
        break;

    case 'transaksi_tambah':
        require_once BASE_PATH . '/app/controllers/TransaksiController.php';
        showFormTambahTransaksi($conn);
        break;

    case 'transaksi_simpan':
        require_once BASE_PATH . '/app/controllers/TransaksiController.php';
        tambahTransaksi($conn);
        break;

    case 'transaksi_detail':
        require_once BASE_PATH . '/app/controllers/TransaksiController.php';
        detailTransaksi($conn, $_GET['id']);
        break;
    default:
        echo "404 - Halaman tidak ditemukan.";
}

<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

// Load koneksi hanya sekali
require_once BASE_PATH . '/app/config/koneksi.php';

// Ambil page dari URL
$page = $_GET['page'] ?? 'login';

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

    // Tambahan lainnya seperti dashboard, produk, transaksi, dll
    default:
        echo "404 - Halaman tidak ditemukan.";
}

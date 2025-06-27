<?php
require_once BASE_PATH . '/app/models/Produk.php';
require_once BASE_PATH . '/app/models/Kategori.php';

// Tampilkan daftar produk
function listProduk($conn) {
    $produk = getAllProduk($conn);
    require_once BASE_PATH . '/app/views/produk/index.php';
}

// Tampilkan form tambah produk
function showTambahProdukForm($conn) {
    $kategori = getAllKategori($conn);
    require_once BASE_PATH . '/app/views/produk/create.php';
}

// Simpan produk baru
function storeProduk($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama       = $_POST['nama'] ?? '';
        $harga      = $_POST['harga'] ?? 0;
        $stok       = $_POST['stok'] ?? 0;
        $deskripsi  = $_POST['deskripsi'] ?? '';
        $id_kategori = isset($_POST['id_kategori']) && $_POST['id_kategori'] !== '' ? (int) $_POST['id_kategori'] : null;

        $gambar = null;
        if (!empty($_FILES['gambar']['name'])) {
            $uploadDir = BASE_PATH . '/public/uploads/produk/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = time() . '_' . basename($_FILES['gambar']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $gambar = $fileName;
            }
        }

        $berhasil = addProduk($conn, $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori);
        $_SESSION['success'] = $berhasil ? "Produk berhasil ditambahkan." : "Gagal menambahkan produk.";
        header('Location: ?page=produk');
        exit;
    }
}

function showFormEditProduk($conn, $id) {
    $produk = getProdukById($conn, $id);
    if (!$produk) {
        $_SESSION['error'] = "Produk tidak ditemukan.";
        header('Location: ?page=produk');
        exit;
    }

    $kategori = getAllKategori($conn);
    require_once BASE_PATH . '/app/views/produk/edit.php';
}

function updateProdukProses($conn, $id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama       = $_POST['nama'] ?? '';
        $harga      = $_POST['harga'] ?? 0;
        $stok       = $_POST['stok'] ?? 0;
        $deskripsi  = $_POST['deskripsi'] ?? '';
        $id_kategori = isset($_POST['id_kategori']) && $_POST['id_kategori'] !== '' ? (int) $_POST['id_kategori'] : null;

        $gambar = null;
        if (!empty($_FILES['gambar']['name'])) {
            $uploadDir = BASE_PATH . '/public/uploads/produk/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = time() . '_' . basename($_FILES['gambar']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $gambar = $fileName;
            }
        }

        $berhasil = updateProduk($conn, $id, $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori);
        $_SESSION['success'] = $berhasil ? "Produk berhasil diupdate." : "Gagal update produk.";
        header("Location: ?page=produk");
        exit;
    }
}

function hapusProduk($conn, $id) {
    $berhasil = deleteProduk($conn, $id);

    if ($berhasil['success']) {
        $_SESSION['success'] = $berhasil['message'];
    } else {
        $_SESSION['error'] = $berhasil['message'];
    }

    header("Location: ?page=produk");
    exit;
}
?>
<?php
require_once BASE_PATH . '/app/models/Kategori.php';

function listKategori($conn) {
    $kategori = getAllKategori($conn);
    require_once BASE_PATH . '/app/views/kategori/index.php';
}

function showFormTambahKategori() {
    require_once BASE_PATH . '/app/views/kategori/create.php';
}

function simpanKategori($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_kategori = $_POST['nama_kategori'] ?? '';

        if (trim($nama_kategori) === '') {
            $_SESSION['error'] = "Nama kategori harus diisi.";
            header('Location: ?page=kategori_tambah');
            exit;
        }

        $berhasil = addKategori($conn, $nama_kategori);
        $_SESSION['success'] = $berhasil ? "Kategori berhasil ditambahkan." : "Gagal menambahkan kategori.";
        header('Location: ?page=kategori');
        exit;
    }
}

function showFormEditKategori($conn, $id) {
    $kategori = getKategoriById($conn, $id);
    if (!$kategori) {
        $_SESSION['error'] = "Kategori tidak ditemukan.";
        header('Location: ?page=kategori');
        exit;
    }
    require_once BASE_PATH . '/app/views/kategori/edit.php';
}

function updateKategoriProses($conn, $id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_kategori = $_POST['nama_kategori'] ?? '';

        if (trim($nama_kategori) === '') {
            $_SESSION['error'] = "Nama kategori harus diisi.";
            header('Location: ?page=kategori_tambah');
            exit;
        }

        $berhasil = updateKategori($conn, $id, $nama_kategori);
        $_SESSION['success'] = $berhasil ? "Kategori berhasil diupdate." : "Gagal update kategori.";
        header('Location: ?page=kategori');
        exit;
    }
}

function hapusKategori($conn, $id) {
    $berhasil = deleteKategori($conn, $id);
    $_SESSION['success'] = $berhasil ? "Kategori berhasil dihapus." : "Gagal menghapus kategori.";
    header('Location: ?page=kategori');
    exit;
}
?>
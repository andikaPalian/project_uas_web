<?php
require_once BASE_PATH . '/app/models/Transksi.php';
require_once BASE_PATH . '/app/models/Produk.php';

function listTransaksi($conn) {
    $transaksi = getAllTransaksi($conn);
    require_once BASE_PATH . '/app/views/transaksi/index.php';
}

function showFormTambahTransaksi($conn) {
    $produk = getAllProduk($conn);;
    require_once BASE_PATH . '/app/views/transaksi/create.php';
}

function tambahTransaksi($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $produk_ids = $_POST['produk_id'] ?? [];
        $jumlahs = $_POST['jumlah'] ?? [];

        $cart = [];
        foreach ($produk_ids as $index => $id_produk) {
            if (!empty($id_produk) && !empty($jumlahs[$index]) && $jumlahs[$index] > 0) {
                // Ambil data produk
                $produk = getProdukById($conn, $id_produk);
                if ($produk) {
                    $cart[] = [
                        'produk_id' => $id_produk,
                        'jumlah'    => (int) $jumlahs[$index],
                        'harga'     => (float) $produk['harga']
                    ];
                }
            }
        }

        if (count($cart) === 0) {
            $_SESSION['error'] = 'Pilih minimal satu produk untuk transaksi.';
            header('Location: ?page=transaksi_tambah');
            exit;
        }

        $user_id = $_SESSION['user']['id'] ?? null;
        if (!$user_id) {
            $_SESSION['error'] = 'User tidak valid.';
            header('Location: ?page=transaksi_tambah');
            exit;
        }

        $berhasil = addTransaksi($conn, $user_id, $cart);
        $_SESSION['success'] = $berhasil ? "Transaksi berhasil disimpan." : "Gagal menyimpan transaksi.";
        header('Location: ?page=transaksi');
        exit;
    }
}

function detailTransaksi($conn, $id) {
    $transaksi = getTransaksiById($conn, $id);
    if (!$transaksi) {
        $_SESSION['error'] = 'Transaksi tidak ditemukan.';
        header("Location: ?page=transaksi");
        exit;
    }

    $detail = getDetailTranasksi($conn, $id);
    require_once BASE_PATH . '/app/views/transaksi/detail.php';
}
?>
<?php
function getAllProduk($conn) {
    $sql = "SELECT produk.*, kategori_produk.nama_kategori AS nama_kategori FROM produk LEFT JOIN kategori_produk ON produk.id_kategori = kategori_produk.id
            ORDER BY produk.created_at DESC";
    $result = $conn->query($sql);
    $produk = [];
    while ($row = $result->fetch_assoc()) {
        $produk[] = $row;
    }
    return $produk;
}

function getProdukById($conn, $id) {
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function addProduk($conn, $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori) {
    if (is_null($id_kategori)) {
        $sql = "INSERT INTO produk (nama, harga, stok, deskripsi, gambar, id_kategori)
                VALUES (?, ?, ?, ?, ?, NULL)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdiss", $nama, $harga, $stok, $deskripsi, $gambar);
    } else {
        $sql = "INSERT INTO produk (nama, harga, stok, deskripsi, gambar, id_kategori)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdissi", $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori);
    }
    return $stmt->execute();
}

function updateProduk($conn, $id, $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori) {
    // Jika gambar tidak di update, exlude gambar dari query
    if ($gambar) {
        if (is_null($id_kategori)) {
            $sql = "UPDATE produk SET nama = ?, harga = ?, stok = ?, deskripsi = ?, gambar = ?, id_kategori = NULL, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdissi", $nama, $harga, $stok, $deskripsi, $gambar, $id);
        } else {
            $sql = "UPDATE produk SET nama = ?, harga = ?, stok = ?, deskripsi = ?, gambar = ?, id_kategori = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdissii", $nama, $harga, $stok, $deskripsi, $gambar, $id_kategori, $id);
        }
    } else {
        if (is_null($id_kategori)) {
            $sql = "UPDATE produk SET nama = ?, harga = ?, stok = ?, deskripsi = ?, id_kategori = NULL, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdisi", $nama, $harga, $stok, $deskripsi, $id);
        } else {
            $sql = "UPDATE produk SET nama = ?, harga = ?, stok = ?, deskripsi = ?, id_kategori = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdisii", $nama, $harga, $stok, $deskripsi, $id_kategori, $id);
        }
    }
    return $stmt->execute();
}

function deleteProduk($conn, $id) {
    // Cek apakah produk di pakai di transaksi/detail transaksi
    $sqlCheck = "SELECT COUNT(*)  as total FROM  detail_transaksi WHERE produk_id  = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result()->fetch_assoc();

    if ($resultCheck['total'] > 0) {
        return [
            'success' => false,
            'message' => 'Produk tidak dapat dihapus karena masih digunakan dalam transaksi.'
        ];
    }

    // Jika beklum ada transaksi, lanjutkan hapus produk
    $sql = "DELETE FROM produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if ($result) {
        return [
            'success' => true,
            'message' => 'Produk berhasil dihapus.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Gagal menghapus produk.'
        ];
    }
}

function getJumlahProduk($conn) {
    $sql = "SELECT COUNT(*) as total FROM produk";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total'];
}
?>
<?php
function getAllTransaksi($conn) {
    $sql = "SELECT t.*, u.username FROM transaksi t JOIN users u ON t.user_id = u.id ORDER BY t.tanggal DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getTransaksiById($conn, $id) {
    $sql = "SELECT * FROM transaksi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getDetailTranasksi($conn, $transaksi_id) {
    $sql = "SELECT dt.*, p.nama FROM  detail_transaksi dt JOIN produk p ON dt.produk_id = p.id WHERE dt.transaksi_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transaksi_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addTransaksi($conn, $user_id, $cart) {
    $conn->begin_transaction();
    try {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        // Insert transaksi
        $sql = "INSERT INTO transaksi (user_id, tanggal, total) VALUES (?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $user_id, $total);
        $stmt->execute();
        $transaksi_id = $stmt->insert_id;

        // Insert detail transaksi dan kurangi stok produk
        foreach ($cart as $item) {
            $subtotal = $item['harga'] * $item['jumlah'];

            $sqlDetail = "INSERT INTO detail_transaksi (transaksi_id, produk_id, jumlah, harga, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmtDetail = $conn->prepare($sqlDetail);
            $stmtDetail->bind_param("iiidd", $transaksi_id, $item['produk_id'], $item['jumlah'], $item['harga'], $subtotal);
            $stmtDetail->execute();

            // Update stok produk
            $sqlStok = "UPDATE produk SET stok = stok - ? WHERE id = ?";
            $stmtStok = $conn->prepare($sqlStok);
            $stmtStok->bind_param("ii", $item['jumlah'], $item['produk_id']);
            $stmtStok->execute();
        }

        $conn->commit();
        return true;
    } catch (Exception $e) {
        $conn->rollback();
        return false;
    }
}

function getTransaksiStatistik($conn, $tipe = 'bulan') {
    switch ($tipe) {
        case 'hari':
            $format = "%Y-%m-%d";
            break;
        case 'minggu':
            $format = "%Y-%u"; // Minggu ke-
            break;
        case 'bulan':
        default:
            $format = "%Y-%m";
            break;
    }

    $sql = "SELECT DATE_FORMAT(tanggal, '$format') AS label, COUNT(*) AS jumlah
            FROM transaksi
            GROUP BY label
            ORDER BY label ASC";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function getJumlahTransaksi($conn) {
    $sql = "SELECT COUNT(*) as total FROM transaksi";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total'];
}

?>
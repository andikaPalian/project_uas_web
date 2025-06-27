<?php
require_once __DIR__ . '/../../app/config/koneksi.php';

$data = [];

$sql = "SELECT produk.nama AS label, SUM(detail_transaksi.jumlah) AS jumlah FROM detail_transaksi JOIN produk ON detail_transaksi.produk_id = produk.id GROUP BY detail_transaksi.produk_id ORDER BY jumlah DESC LIMIT 10";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'label' => $row['label'],
        'jumlah' => (int)$row['jumlah']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
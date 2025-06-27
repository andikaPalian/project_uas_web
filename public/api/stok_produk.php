<?php
require_once __DIR__ . '/../../app/config/koneksi.php';

$data = [];

$sql = "SELECT nama AS label, stok FROM produk ORDER BY stok ASC LIMIT 10";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'label' => $row['label'],
        'stok' => (int)$row['stok']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
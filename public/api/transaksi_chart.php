<?php
require_once __DIR__ . '/../../app/config/koneksi.php';

$tipe = $_GET['tipe'] ?? 'bulan';
$data = [];

if ($tipe === 'hari') {
    $sql = "SELECT DATE(tanggal) as label, COUNT(*) as jumlah 
            FROM transaksi 
            GROUP BY DATE(tanggal) 
            ORDER BY tanggal ASC";
} elseif ($tipe === 'minggu') {
    $sql = "SELECT YEAR(tanggal) as tahun, WEEK(tanggal) as minggu, COUNT(*) as jumlah 
            FROM transaksi 
            GROUP BY tahun, minggu 
            ORDER BY tahun, minggu ASC";
} else {
    // Default: bulanan
    $sql = "SELECT DATE_FORMAT(tanggal, '%Y-%m') as label, COUNT(*) as jumlah 
            FROM transaksi 
            GROUP BY DATE_FORMAT(tanggal, '%Y-%m') 
            ORDER BY label ASC";
}

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    if ($tipe === 'minggu') {
        $label = 'Minggu ' . $row['minggu'] . ' (' . $row['tahun'] . ')';
    } else {
        $label = $row['label'];
    }

    $data[] = [
        'label' => $label,
        'jumlah' => (int) $row['jumlah']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);

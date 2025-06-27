<?php
// Pengaturan untuk menampilkan error PHP, sangat membantu saat debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set header ke JSON di awal untuk memastikan output yang benar
header('Content-Type: application/json');

require_once __DIR__ . '/../../app/config/koneksi.php';

// Inisialisasi struktur respons default
$response = [
    'chartData' => [],
    'periodTotal' => 0,
    'label' => 'Data tidak ditemukan' // Pesan default
];

try {
    $tipe = $_GET['tipe'] ?? 'hari';
    $sqlChart = '';
    $sqlTotal = '';

    // 1. Siapkan query berdasarkan tipe filter
    switch ($tipe) {
        case 'bulan':
            // Grafik: Pendapatan harian untuk bulan berjalan
            $sqlChart = "SELECT 
                            DATE_FORMAT(tanggal, '%Y-%m-%d') as label, 
                            SUM(total) as jumlah
                         FROM transaksi
                         WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())
                         GROUP BY DATE(tanggal)
                         ORDER BY tanggal ASC";
            
            // Total: Total pendapatan untuk bulan berjalan
            $sqlTotal = "SELECT 
                            SUM(total) as total
                         FROM transaksi
                         WHERE MONTH(tanggal) = MONTH(CURDATE()) AND YEAR(tanggal) = YEAR(CURDATE())";
            
            $response['label'] = 'Pendapatan Bulan Ini';
            break;

        case 'minggu':
            // Grafik: Pendapatan harian untuk minggu berjalan
            // Menggunakan YEARWEEK, mode 1 (Senin adalah hari pertama)
            $sqlChart = "SELECT 
                            DATE_FORMAT(tanggal, '%a, %d') as label, 
                            SUM(total) as jumlah
                         FROM transaksi
                         WHERE YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)
                         GROUP BY DATE(tanggal)
                         ORDER BY tanggal ASC";

            // Total: Total pendapatan untuk minggu berjalan
            $sqlTotal = "SELECT 
                            SUM(total) as total
                         FROM transaksi
                         WHERE YEARWEEK(tanggal, 1) = YEARWEEK(CURDATE(), 1)";

            $response['label'] = 'Pendapatan Minggu Ini';
            break;

        default: // 'hari'
            // Grafik: Pendapatan harian selama 7 hari terakhir
            $sqlChart = "SELECT 
                            DATE_FORMAT(tanggal, '%Y-%m-%d') as label, 
                            SUM(total) as jumlah
                         FROM transaksi
                         WHERE tanggal >= CURDATE() - INTERVAL 6 DAY
                         GROUP BY DATE(tanggal)
                         ORDER BY tanggal ASC";

            // Total: Total pendapatan untuk HARI INI saja
            $sqlTotal = "SELECT 
                            SUM(total) as total
                         FROM transaksi
                         WHERE DATE(tanggal) = CURDATE()";

            $response['label'] = 'Pendapatan Hari Ini';
            break;
    }

    // 2. Eksekusi query untuk data grafik
    if ($sqlChart) {
        $resultChart = $conn->query($sqlChart);
        if ($resultChart === false) {
            // Jika query gagal, lempar exception dengan pesan error dari MySQL
            throw new Exception("Query untuk Chart Gagal: " . $conn->error);
        }
        while ($row = $resultChart->fetch_assoc()) {
            $response['chartData'][] = [
                'label' => $row['label'],
                'jumlah' => (float) $row['jumlah']
            ];
        }
    }

    // 3. Eksekusi query untuk total periode
    if ($sqlTotal) {
        $resultTotal = $conn->query($sqlTotal);
        if ($resultTotal === false) {
            // Jika query gagal, lempar exception
            throw new Exception("Query untuk Total Gagal: " . $conn->error);
        }
        $rowTotal = $resultTotal->fetch_assoc();
        $response['periodTotal'] = (float) ($rowTotal['total'] ?? 0);
    }

} catch (Exception $e) {
    // Jika terjadi error (misal dari query), kirim pesan error dalam format JSON
    http_response_code(500); // Kode error server
    $response = [
        'error' => true,
        'message' => $e->getMessage()
    ];
}

// 4. Selalu kirim respons sebagai JSON di akhir
echo json_encode($response);
?>

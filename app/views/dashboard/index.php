<?php
// Memuat file-file model yang diperlukan
require_once BASE_PATH . '/app/models/Produk.php';
require_once BASE_PATH . '/app/models/Transksi.php';
require_once BASE_PATH . '/app/models/User.php';

// Memuat layout header dan sidebar
include BASE_PATH . '/app/views/layouts/header.php';
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Navbar Atas -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3 mb-4">
    <div class="container-fluid">
        <!-- Judul Halaman Dinamis -->
        <h4 class="m-0 fw-bold">Dashboard</h4>
        <div class="d-flex align-items-center">
            <span class="me-3">Login sebagai: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></span>
            <a href="?page=logout" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>
    </div>
</nav>

<!-- Konten Utama Dashboard -->
<main class="container-fluid">
    <p class="fs-5">Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>!</p>

    <!-- Baris untuk Kartu Statistik -->
    <div class="row mb-4">
        <!-- Kartu Total Produk -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-3 me-4">
                        <i class="fas fa-box-open fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Produk</h6>
                        <h4 class="card-title fw-bold m-0"><?= getJumlahProduk($conn) ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kartu Total Transaksi -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded-3 me-4">
                        <i class="fas fa-receipt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Total Transaksi</h6>
                        <h4 class="card-title fw-bold m-0"><?= getJumlahTransaksi($conn) ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kartu Jumlah Kasir -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-info bg-opacity-10 rounded-3 me-4">
                        <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Jumlah Kasir</h6>
                        <h4 class="card-title fw-bold m-0"><?= getJumlahKasir($conn) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris untuk Grafik -->
    <div class="row">
        <!-- Grafik Transaksi -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pb-0 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold m-0">Grafik Transaksi</h5>
                        <select id="filter" class="form-select form-select-sm" style="width: auto;">
                            <option value="bulan">Per Bulan</option>
                            <option value="minggu">Per Minggu</option>
                            <option value="hari">Per Hari</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="transaksiChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Produk Terlaris -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-bold m-0">Produk Terlaris</h5>
                </div>
                <div class="card-body">
                    <canvas id="produkTerlarisChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grafik Stok Produk -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-bold m-0">Stok Produk Saat Ini</h5>
                </div>
                <div class="card-body">
                     <canvas id="stokChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Sisa dari tag penutup layout -->
</div> <!-- Penutup .content-wrapper -->
</div> <!-- Penutup .d-flex -->

<!-- JAVASCRIPT LIBRARIES -->
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SCRIPT ANDA UNTUK MENGELOLA GRAFIK -->
<script>
    // --- PALET WARNA UNTUK SETIAP GRAFIK ---

    // Palet untuk Grafik Transaksi (nuansa biru & hijau yang tenang)
    const transactionColors = {
        background: [
            'rgba(54, 162, 235, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(117, 182, 219, 0.7)',
            'rgba(141, 207, 207, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(100, 116, 139, 0.7)'
        ],
        border: [
            'rgba(54, 162, 235, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(117, 182, 219, 1)',
            'rgba(141, 207, 207, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(100, 116, 139, 1)'
        ]
    };

    // Palet untuk Produk Terlaris (warna-warni yang kontras)
    const bestSellingColors = [
        'rgba(255, 99, 132, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)',
        'rgba(54, 162, 235, 0.8)'
    ];

    // Palet untuk Stok Produk (nuansa oranye & kuning yang informatif)
    const stockColors = {
        background: [
            'rgba(255, 159, 64, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(252, 187, 108, 0.7)',
            'rgba(252, 222, 150, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(189, 195, 199, 0.7)'
        ],
        border: [
            'rgba(255, 159, 64, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(252, 187, 108, 1)',
            'rgba(252, 222, 150, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(189, 195, 199, 1)'
        ]
    };


    // --- GRAFIK TRANSAKSI ---
    let ctx = document.getElementById('transaksiChart').getContext('2d');
    let transaksiChart;
    
    async function loadChart(tipe = 'bulan') {
      const res = await fetch('api/transaksi_chart.php?tipe=' + tipe);
      const data = await res.json();
      const labels = data.map(d => d.label);
      const jumlah = data.map(d => d.jumlah);
      if (transaksiChart) transaksiChart.destroy();
      transaksiChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: labels,
              datasets: [{
                  label: 'Jumlah Transaksi',
                  data: jumlah,
                  backgroundColor: transactionColors.background,
                  borderColor: transactionColors.border,
                  borderWidth: 1,
                  borderRadius: 4
              }]
          },
          options: {
              responsive: true,
              scales: {
                  y: { beginAtZero: true, ticks: { precision: 0 } }
              },
              plugins: { legend: { display: false } }
          }
      });
    }

    document.getElementById('filter').addEventListener('change', function () {
      loadChart(this.value);
    });
    loadChart();


    // --- GRAFIK PRODUK TERLARIS ---
    let produkCtx = document.getElementById('produkTerlarisChart').getContext('2d');
    let produkChart;

    async function loadProdukTerlaris() {
        const res = await fetch('api/produk_terlaris.php');
        const data = await res.json();
        const labels = data.map(d => d.label);
        const jumlah = data.map(d => d.jumlah);
        if (produkChart) produkChart.destroy();
        produkChart = new Chart(produkCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: jumlah,
                    backgroundColor: bestSellingColors,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }
    loadProdukTerlaris();


    // --- GRAFIK STOK PRODUK ---
    let stokCtx = document.getElementById('stokChart').getContext('2d');
    let stokChart;

    async function loadStokChart() {
        const res = await fetch('api/stok_produk.php');
        const data = await res.json();
        const labels = data.map(d => d.label);
        const stok = data.map(d => d.stok);
        if (stokChart) stokChart.destroy();
        stokChart = new Chart(stokCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stok Saat Ini',
                    data: stok,
                    backgroundColor: stockColors.background,
                    borderColor: stockColors.border,
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }
    loadStokChart();

</script>

</body>
</html>
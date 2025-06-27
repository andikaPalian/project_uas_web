<?php
// Memuat file-file model yang diperlukan
require_once BASE_PATH . '/app/models/Produk.php';
require_once BASE_PATH . '/app/models/Transksi.php'; // Koreksi nama file jika diperlukan
require_once BASE_PATH . '/app/models/User.php';

// Memuat layout header dan sidebar
// Asumsi header.php berisi tag <head> dan pembuka <body>
include BASE_PATH . '/app/views/layouts/header.php'; 
?>

<!-- Tambahan CSS Kustom untuk Tampilan Modern -->
<style>
    :root {
        --primary-rgb: 13, 110, 253;
        --success-rgb: 25, 135, 84;
        --info-rgb: 13, 202, 240;
        --warning-rgb: 255, 193, 7;
        --danger-rgb: 220, 53, 69;
        --light-gray: #f8f9fa;
        --border-color: #dee2e6;
        --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        --card-border-radius: 0.75rem;
    }

    body {
        background-color: var(--light-gray);
    }

    main.dashboard-content {
        padding: 2rem;
        width: 100%;
    }

    .stat-card {
        background-color: #fff;
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08);
    }
    
    .stat-card:hover .stat-icon-bg {
        transform: scale(1.15) rotate(-5deg);
    }

    .stat-card .card-body {
        padding: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .stat-icon-bg {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 5.5rem;
        opacity: 0.15;
        z-index: 1;
        transition: transform 0.3s ease-out;
    }

    .stat-card .stat-number {
        font-size: 2.25rem;
        font-weight: 700;
    }

    .dashboard-card {
        background-color: #fff;
        border: none;
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
    }

    .dashboard-card .card-header {
        background-color: transparent;
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
    }
    
    .dashboard-card .card-body {
        padding: 1.5rem;
    }

    .dashboard-card .card-title {
        font-weight: 600;
    }

</style>

<?php 
// Memuat sidebar setelah CSS agar tidak mengganggu struktur
include BASE_PATH . '/app/views/layouts/sidebar.php';
?>

<!-- Konten Utama -->
<main class="dashboard-content">
    <!-- Header Konten -->
    <header class="mb-4">
        <h2 class="m-0 fw-bold">Dashboard</h2>
        <p class="text-muted mb-0 fs-5">Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>!</p>
    </header>

    <!-- Baris untuk Kartu Statistik -->
    <div class="row g-4 mb-4">
        <!-- Kartu Total Produk -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Produk</h6>
                    <p class="stat-number m-0" style="color: rgb(var(--primary-rgb));"><?= getJumlahProduk($conn) ?></p>
                    <i class="fas fa-box-open stat-icon-bg" style="color: rgb(var(--primary-rgb));"></i>
                </div>
            </div>
        </div>
        <!-- Kartu Total Transaksi -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Total Transaksi</h6>
                    <p class="stat-number m-0" style="color: rgb(var(--success-rgb));"><?= getJumlahTransaksi($conn) ?></p>
                    <i class="fas fa-receipt stat-icon-bg" style="color: rgb(var(--success-rgb));"></i>
                </div>
            </div>
        </div>
        <!-- Kartu Jumlah Kasir -->
        <div class="col-lg-4 col-md-6">
            <div class="stat-card h-100">
                <div class="card-body">
                     <h6 class="card-subtitle mb-2 text-muted">Jumlah Kasir</h6>
                     <p class="stat-number m-0" style="color: rgb(var(--info-rgb));"><?= getJumlahKasir($conn) ?></p>
                     <i class="fas fa-users stat-icon-bg" style="color: rgb(var(--info-rgb));"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris untuk Grafik Utama -->
    <div class="row g-4 mb-4">
        <!-- Grafik Transaksi -->
        <div class="col-lg-7">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Grafik Transaksi</h5>
                    <select id="filter" class="form-select form-select-sm" style="width: auto;">
                        <option value="hari">Per Hari</option>
                        <option value="minggu">Per Minggu</option>
                        <option value="bulan">Per Bulan</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="transaksiChart" style="min-height: 280px; max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Produk Terlaris -->
        <div class="col-lg-5">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title m-0">Produk Terlaris</h5>
                </div>
                <div class="card-body">
                    <canvas id="produkTerlarisChart" style="min-height: 280px; max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris untuk Grafik Tambahan -->
    <div class="row g-4">
        <!-- Grafik Pendapatan -->
        <div class="col-lg-7">
             <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Grafik Pendapatan (Omzet)</h5>
                    <select id="pendapatanFilter" class="form-select form-select-sm" style="width:auto;">
                        <option value="hari">Per Hari</option>
                        <option value="minggu">Per Minggu</option>
                        <option value="bulan">Per Bulan</option>
                    </select>
                </div>
                <div class="card-body">
                    <!-- Elemen ini akan diupdate oleh JavaScript -->
                    <h4 id="pendapatanTotalDisplay" class="fw-bold mb-3">Memuat...</h4>
                    <canvas id="pendapatanChart" style="min-height: 250px; max-height: 280px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Stok Produk -->
        <div class="col-lg-5">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title m-0">Stok Produk Teratas</h5>
                </div>
                <div class="card-body">
                    <canvas id="stokChart" style="min-height: 350px; max-height: 380px;"></canvas>
                </div>
            </div>
        </div>
    </div>

</main>

<!-- Sisa dari tag penutup layout -->
</div> <!-- Penutup .content-wrapper dari sidebar -->
</div> <!-- Penutup .d-flex dari sidebar -->

<!-- JAVASCRIPT LIBRARIES -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SCRIPT ANDA UNTUK MENGELOLA GRAFIK -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- GRAFIK TRANSAKSI ---
    const ctx = document.getElementById('transaksiChart').getContext('2d');
    let transaksiChart;
    
    async function loadChart(tipe = 'hari') {
        try {
            const res = await fetch(`api/transaksi_chart.php?tipe=${tipe}`);
            const data = await res.json();
            const labels = data.map(d => d.label);
            const jumlah = data.map(d => d.jumlah);

            if (transaksiChart) transaksiChart.destroy();

            // Membuat warna gradien untuk bar chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(13, 110, 253, 0.8)');
            gradient.addColorStop(1, 'rgba(13, 110, 253, 0.2)');

            transaksiChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: jumlah,
                        backgroundColor: gradient,
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1,
                        borderRadius: 4,
                        hoverBackgroundColor: 'rgba(13, 110, 253, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        } catch (error) {
            console.error('Gagal memuat data grafik transaksi:', error);
        }
    }

    document.getElementById('filter').addEventListener('change', function () {
        loadChart(this.value);
    });
    loadChart();


    // --- GRAFIK PRODUK TERLARIS ---
    const produkCtx = document.getElementById('produkTerlarisChart').getContext('2d');
    let produkChart;

    async function loadProdukTerlaris() {
        try {
            const res = await fetch('api/produk_terlaris.php');
            const data = await res.json();
            const labels = data.map(d => d.label);
            const jumlah = data.map(d => d.jumlah);

            if (produkChart) produkChart.destroy();
            
            // Palet warna baru yang lebih beragam dan keren
            const bestSellingColors = [
                '#0d6efd', '#6f42c1', '#fd7e14', '#198754', '#ffc107', 
                '#dc3545', '#0dcaf0', '#20c997', '#d63384', '#6610f2'
            ];

            produkChart = new Chart(produkCtx, {
                type: 'doughnut', 
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: jumlah,
                        backgroundColor: bestSellingColors,
                        borderColor: '#fff',
                        borderWidth: 4,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: { 
                                padding: 20, 
                                usePointStyle: true,
                                boxWidth: 8
                            } 
                        }
                    },
                    cutout: '70%'
                }
            });
        } catch(error) {
            console.error('Gagal memuat data produk terlaris:', error);
        }
    }
    loadProdukTerlaris();


    // --- GRAFIK STOK PRODUK ---
    const stokCtx = document.getElementById('stokChart').getContext('2d');
    let stokChart;

    async function loadStokChart() {
        try {
            const res = await fetch('api/stok_produk.php');
            const data = await res.json();
            const topData = data.slice(0, 10);
            const labels = topData.map(d => d.label);
            const stok = topData.map(d => d.stok);
            
            if (stokChart) stokChart.destroy();
            
            const gradient = stokCtx.createLinearGradient(0, 0, 500, 0);
            gradient.addColorStop(0, 'rgba(255, 193, 7, 0.4)');
            gradient.addColorStop(1, 'rgba(255, 193, 7, 1)');

            stokChart = new Chart(stokCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Stok Saat Ini',
                        data: stok,
                        backgroundColor: gradient,
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y', // Bar horizontal agar mudah dibaca
                    scales: {
                        x: { beginAtZero: true, ticks: { precision: 0 } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        } catch(error) {
            console.error('Gagal memuat data stok produk:', error);
        }
    }
    loadStokChart();
    
    // --- GRAFIK PENDAPATAN ---
    const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');
    const pendapatanTotalDisplayEl = document.getElementById('pendapatanTotalDisplay');
    let pendapatanChart;

    async function loadPendapatanChart(tipe = 'hari') {
        try {
            const res = await fetch(`api/pendapatan_chart.php?tipe=${tipe}`);
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            const responseData = await res.json(); 

            const chartData = responseData.chartData;
            const periodTotal = responseData.periodTotal;
            const periodLabel = responseData.label;
            
            const labels = chartData.map(d => d.label);
            const jumlah = chartData.map(d => d.jumlah);

            pendapatanTotalDisplayEl.innerHTML = `${periodLabel}: <strong style="color: rgb(var(--success-rgb));">Rp ${periodTotal.toLocaleString('id-ID')}</strong>`;

            if (pendapatanChart) pendapatanChart.destroy();
            
            // Membuat gradien untuk garis dan area di bawahnya
            const lineGradient = pendapatanCtx.createLinearGradient(0, 0, 0, 280);
            lineGradient.addColorStop(0, 'rgba(25, 135, 84, 1)');
            lineGradient.addColorStop(1, 'rgba(40, 167, 69, 0.5)');

            const areaGradient = pendapatanCtx.createLinearGradient(0, 0, 0, 280);
            areaGradient.addColorStop(0, 'rgba(25, 135, 84, 0.3)');
            areaGradient.addColorStop(1, 'rgba(255, 255, 255, 0)');


            pendapatanChart = new Chart(pendapatanCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: jumlah,
                        backgroundColor: areaGradient,
                        borderColor: lineGradient,
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(25, 135, 84)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        } catch (error) {
            console.error('Gagal memuat atau memproses grafik pendapatan:', error);
            pendapatanTotalDisplayEl.textContent = 'Gagal memuat data.';
        }
    }

    document.getElementById('pendapatanFilter').addEventListener('change', function () {
        loadPendapatanChart(this.value);
    });

    loadPendapatanChart('hari'); 

});
</script>

</body>
</html>

<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ?page=login");
  exit;
}
?>

<?php include BASE_PATH . '/app/views/layouts/navbar.php'; ?>
<?php include BASE_PATH . '/app/views/layouts/sidebar.php'; ?>

<div style="flex-grow:1; padding:20px;">
  <h2>Dashboard Admin</h2>
  <p>Selamat datang, <strong><?= $_SESSION['user']['username']; ?></strong>!</p>

  <div style="display:flex; gap:20px; margin-top:30px;">
    <div style="background:#f2f2f2; padding:20px; border-radius:10px; flex:1;">
      <h4>Total Produk</h4>
      <p>📦 120 Produk</p>
    </div>
    <div style="background:#f2f2f2; padding:20px; border-radius:10px; flex:1;">
      <h4>Total Transaksi</h4>
      <p>🧾 540 Transaksi</p>
    </div>
    <div style="background:#f2f2f2; padding:20px; border-radius:10px; flex:1;">
      <h4>Jumlah Kasir</h4>
      <p>👥 3 User</p>
    </div>
  </div>
</div>
